<?php

namespace App\Http\Controllers;

use Session;
use PulkitJalan\Google\Client;
use google;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CardDriveController extends Controller
{


    public function __construct() {
        $this->middleware('auth.user');
    }

    public function home(){
        try {
            $client = new Client(Config::get('google'));
            $googleClient = $client->getclient();
            $googleClient->setAccessToken(Session::get('access_token'));
            $GSDrive = $client->make('drive');
            $about_get = $GSDrive->about->get();


            $parameters = [
                "pageToken"=>null,
                "q"=>"title='CardDriveFiles'"
            ];
            $children = $GSDrive->children->listChildren("root", $parameters);
            $fileID = null;
            foreach ($children->getItems() as $key => $child) {
                $fileID = $child->getId();
            }
            if ($fileID == null) {
                $folder = new \Google_Service_Drive_DriveFile();
        		$folder->setTitle("CardDriveFiles");
        		$folder->setMimeType('application/vnd.google-apps.folder');
    			$result = $GSDrive->files->insert($folder, array(
    				'mimeType' => 'application/vnd.google-apps.folder',
    				));
                Session::set('appfolder_id',$result->id);
            }else{
                Session::set('appfolder_id',$fileID);
            }



            return view('home',[
                    "name"=>$about_get->name
                ]
            );
        } catch (Exception $e) {
            return view('welcome',[
                    "error"=>"Token verify fail."
                ]
            );
        }
    }

}
