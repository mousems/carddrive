<?php

namespace App\Http\Controllers;

use Session;
use PulkitJalan\Google\Client;
use google;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use JeroenDesloovere\VCard\VCard;

use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GDController extends Controller
{

    private $GSDrive;
    public function __construct() {
        $this->middleware('auth.user');
        $client = new Client(Config::get('google'));
        $googleClient = $client->getclient();
        $googleClient->setAccessToken(Session::get('access_token'));
        $this->GSDrive = $client->make('drive');
    }

    public function appfolder_info(){

        $appfolder_info = $this->GSDrive->files->get(Session::get('appfolder_id'));

        return response()->json($appfolder_info);
    }

    public function appfolder_createfile($filename, $data, $mimeType='text/plain'){
        $new_file = new \Google_Service_Drive_DriveFile();
		$new_file->setTitle($filename);
		$new_file_parent = new \Google_Service_Drive_ParentReference();
		$new_file_parent->setId(Session::get('appfolder_id'));
		$new_file->setParents(array($new_file_parent));
		$result = $this->GSDrive->files->insert(
		  $new_file,
		  array(
		    'data' => $data,
		    'mimeType' => $mimeType,
		    'uploadType' => 'media'
		  )
		);
        return Response()->json($this->downloadFile($result));
    }
    public function appfolder_updatefile($fileid, $data){

        $additionalParams = array(
            'newRevision' => FALSE,
            'data' => $data,
            'mimeType' => 'text/plain',
            'uploadType' => 'media'
        );

        try {
            $updatedFile = $this->GSDrive->files->update(
                $fileid,
                $this->GSDrive->files->get($fileid),
                $additionalParams
            );
        } catch (Exception $e) {

        }



    }

    public function appfolder_createcache(){
        $this->appfolder_createfile('cache', "[123,1131313]");
    }
    public function appfolder_list(){

        $parameters = [
            "pageToken"=>null
        ];
        $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);
        $return = [];
        foreach ($children->getItems() as $key => $child) {
            $fileID = $child->getId();
            $return[] = [
                $this->GSDrive->files->get($fileID)->getTitle(),
                $fileID
            ];
        }
        return Response()->json($return);
    }
    public function appfolder_deleteall(){

        $parameters = [
            "pageToken"=>null
        ];
        $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);

        foreach ($children->getItems() as $key => $child) {
            $fileID = $child->getId();
            $this->GSDrive->files->delete($fileID);
        }

    }

    public function read_cache(){

        $parameters = [
            "pageToken"=>null,
            "q"=>"title contains 'CardDrive_".Session::get('email_sha')."_Cache'"
        ];
        $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);
        $return = [];
        foreach ($children->getItems() as $key => $child) {
            return $this->downloadFileByID($child->getId());
        }
        return null;
    }

    public function getFileByID($fileID){
        return Response()->json($this->GSDrive->files->get($fileID));
    }
    public function downloadFileByID($fileID){
        return $this->downloadFile($this->GSDrive->files->get($fileID));
    }
    public function downloadFile($file) {
      $downloadUrl = $file->getDownloadUrl();
      if ($downloadUrl) {
        $request = new \Google_Http_Request($downloadUrl, 'GET', null, null);
        $httpRequest = $this->GSDrive->getClient()->getAuth()->authenticatedRequest($request);
        if ($httpRequest->getResponseHttpCode() == 200) {
          return $httpRequest->getResponseBody();
        } else {
          // An error occurred.
          return null;
        }
      } else {
        // The file doesn't have any content stored on Drive.
        return null;
      }
    }
    public function contact_me(){
        $about_ref = $this->GSDrive->about->get();
        $email_sha = sha1($about_ref->getUser()->getEmailAddress());
        Session::set('email_sha',$email_sha);

        $parameters['q'] = "title contains 'CardDrive_".Session::get('email_sha')."_Cache'";
        $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);
        $Items = $children->getItems();
        if (count($Items) != 0) {
            $cache_fileid = $Items[0]->getId();
            $cache_data = $this->downloadFileByID($cache_fileid);
            $cache_data = explode("\n", $cache_data);
            if(isset($cache_data[5])){
                $cache_data = json_decode($cache_data[5]);
            }else{
                $cache_data = json_decode($cache_data[0]);
            }
        }else{
            return Response()->json(["error"=>"notfound"]);
        }
        if (count($cache_data->FT) == 0){
            $parameters['q'] = "title contains 'CardDrive_".$email_sha."_'";
            $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);
            $MyFilesList = [];
            foreach ($children->getItems() as $key => $child) {
                $MyFilesList[] = $child->getId();
            }
            foreach ($MyFilesList as $MyFilesKey => $MyFileIDs) {
                if (!in_array($MyFileIDs, $cache_data->FT)) {
                    $title = $this->GSDrive->files->get($MyFileIDs)->getTitle();
                    $cache_data->FT[$MyFileIDs] = $title;
                    $cache_data->TF[$title] = $MyFileIDs;
                }
            }

            $additionalParams = array(
                'newRevision' => FALSE,
                'data' => json_encode($cache_data),
                'mimeType' => 'text/plain',
                'uploadType' => 'media'
            );


            try {
                $updatedFile = $this->GSDrive->files->update(
                    $cache_fileid,
                    $this->GSDrive->files->get($cache_fileid),
                    $additionalParams
                );
            } catch (Exception $e) {
                return Response()->json(["error"=>"fail"]);
            }
        }

        $myname = $cache_data->EN->{Session::get('email_sha')};
        return Response()->json(["myname"=>$myname,"myid"=>Session::get('email_sha')]);

    }
    public function contact_data($contact_id){
        $parameters['q'] = "title contains 'CardDrive_".$contact_id."_' and title!='CardDrive_".$contact_id."_Cache'";
        $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);
        $MyFilesList = [];
        foreach ($children->getItems() as $key => $child) {
            $MyFilesList[] = $child->getId();
        }
        $res_arr = [];
        foreach ($MyFilesList as $MyFilesKey => $MyFileIDs) {
            $file_youwant = $this->GSDrive->files->get($MyFileIDs);
            $title = $file_youwant->getTitle();
            $data = $this->downloadFile($file_youwant);
            $res_arr[] = ["title"=>str_replace("CardDrive_".$contact_id."_","",$title) , "data"=>$data];
        }
        return Response()->json($res_arr);
    }
    public function getContentByTitle($title){
        $parameters['q'] = "title contains '".$title."'";
        $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);
        $Items = $children->getItems();
        if (count($Items) != 0) {
            return $this->downloadFileByID($Items[0]->getId());
        }else{
            return null;
        }
    }
    public function first_save(Request $request){
        $email_sha = Session::get('email_sha');
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_LastName",
            $request->input('formLastName')
        );

        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_FirstName",
            $request->input('formFirstName')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_Company",
            $request->input('formCompany')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_Title",
            $request->input('formTitle')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_Phone_".$request->input('formPhoneType'),
            $request->input('formPhone')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_Email_".$request->input('formEmailType'),
            $request->input('formEmail')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressCountry_".$request->input('formAddressType'),
            $request->input('formAddressCountry')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressZIP_".$request->input('formAddressType'),
            $request->input('formAddressZIP')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressCity_".$request->input('formAddressType'),
            $request->input('formAddressCity')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressTownship_".$request->input('formAddressType'),
            $request->input('formAddressTownship')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressStreet_".$request->input('formAddressType'),
            $request->input('formAddressStreet')
        );

        $this->appfolder_createfile(
            "CardDrive_".Session::get('email_sha')."_Cache",
            Response()->json(
                [
                    "FT" => [],
                    "TF" => [],
                    "EN" => [
                            Session::get('email_sha')=>$request->input('formFirstName')." ".$request->input('formLastName')
                    ]
                ]
            )
        );
        return redirect('/home');
    }
    public function update(Request $request){
        $cache = json_decode($this->read_cache());
        $email_sha = Session::get('email_sha');
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_LastName"},
            $request->input('formLastName')
        );

        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_FirstName"},
            $request->input('formFirstName')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_Company"},
            $request->input('formCompany')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_Title"},
            $request->input('formTitle')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_Phone_".$request->input('formPhoneType')},
            $request->input('formPhone')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_Email_".$request->input('formEmailType')},
            $request->input('formEmail')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_AddressCountry_".$request->input('formAddressType')},
            $request->input('formAddressCountry')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_AddressZIP_".$request->input('formAddressType')},
            $request->input('formAddressZIP')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_AddressCity_".$request->input('formAddressType')},
            $request->input('formAddressCity')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_AddressTownship_".$request->input('formAddressType')},
            $request->input('formAddressTownship')
        );
        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".$email_sha."_AddressStreet_".$request->input('formAddressType')},
            $request->input('formAddressStreet')
        );

        $this->appfolder_updatefile(
            $cache->TF->{"CardDrive_".Session::get('email_sha')."_Cache"},
            Response()->json(
                [
                    "FT" => [],
                    "TF" => [],
                    "EN" => [
                            Session::get('email_sha')=>$request->input('formFirstName')." ".$request->input('formLastName')
                    ]
                ]
            )
        );
        return redirect('/home');
    }
    public function share(Request $request){
        $cache = json_decode($this->read_cache());

        $email_sha = Session::get('email_sha');
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_LastName",
            $request->input('formLastName')
        );

        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_FirstName",
            $request->input('formFirstName')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_Company",
            $request->input('formCompany')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_Title",
            $request->input('formTitle')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_Phone_".$request->input('formPhoneType'),
            $request->input('formPhone')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_Email_".$request->input('formEmailType'),
            $request->input('formEmail')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressCountry_".$request->input('formAddressType'),
            $request->input('formAddressCountry')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressZIP_".$request->input('formAddressType'),
            $request->input('formAddressZIP')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressCity_".$request->input('formAddressType'),
            $request->input('formAddressCity')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressTownship_".$request->input('formAddressType'),
            $request->input('formAddressTownship')
        );
        $this->appfolder_createfile(
            "CardDrive_".$email_sha."_AddressStreet_".$request->input('formAddressType'),
            $request->input('formAddressStreet')
        );

        $this->appfolder_createfile(
            "CardDrive_".Session::get('email_sha')."_Cache",
            Response()->json(
                [
                    "FT" => [],
                    "TF" => [],
                    "EN" => [
                            Session::get('email_sha')=>$request->input('formFirstName')." ".$request->input('formLastName')
                    ]
                ]
            )
        );
        return redirect('/home');
    }
}
