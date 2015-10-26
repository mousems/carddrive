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

    public function getvcard(){

        // $appfolder_info = $this->GSDrive->files->get(Session::get('appfolder_id'));
        //
        // return response()->json($appfolder_info);

        $vcard = new VCard();

        $lastname = 'Desloovere';
        $firstname = 'Jeroen';
        $additional = '';
        $prefix = '';
        $suffix = '';

        // add personal data
        $vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

        // add work data
        $vcard->addCompany('Siesqo');
        $vcard->addJobtitle('Web Developer');
        $vcard->addEmail('info@jeroendesloovere.be');
        $vcard->addPhoneNumber(1234121212, 'PREF;WORK');
        $vcard->addPhoneNumber(123456789, 'WORK');
        $vcard->addAddress(null, null, 'street', 'worktown', null, 'workpostcode', 'Belgium');
        $vcard->addURL('http://www.jeroendesloovere.be');

        // return vcard as a string
        return $vcard->getOutput();
    }

    public function appfolder_createfile(){
        $new_file = new \Google_Service_Drive_DriveFile();
		$new_file->setTitle("test file");
		$new_file_parent = new \Google_Service_Drive_ParentReference();
		$new_file_parent->setId(Session::get('appfolder_id'));
		$new_file->setParents(array($new_file_parent));
		$result = $this->GSDrive->files->insert(
		  $new_file,
		  array(
		    'data' => "helloworld",
		    'mimeType' => 'text/plain',
		    'uploadType' => 'media'
		  )
		);
        return Response()->json(downloadFile($result));
    }

    public function appfolder_list(){

        $parameters = [
            "pageToken"=>null
        ];
        $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);
        $return = [];
        foreach ($children->getItems() as $key => $child) {
            $return[] = $this->downloadFileByID($child->getId());
        }
        return Response()->json($return);
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
        $parameters['q'] = "title='me'";
        $children = $this->GSDrive->children->listChildren(Session::get('appfolder_id'), $parameters);
        foreach ($children->getItems() as $key => $child) {
            return $this->downloadFileByID($child->getId());
        }
        return Response()->json(["error"=>"notfound"]);

    }
}
