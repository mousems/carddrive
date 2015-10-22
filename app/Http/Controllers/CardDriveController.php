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
        $client = new Client(Config::get('google'));
        $googleClient = $client->getclient();
        $googleClient->setAccessToken(Session::get('access_token'));
        $GSDrive = $client->make('drive');
        $about_get = $GSDrive->about->get();
        $appfolder_info = $GSDrive->files->get("appfolder");
        Session::set('appfolder_id', $appfolder_info->id);
        return response()->json($appfolder_info);
        exit();
        return view('home',[
                "name"=>$about_get->name
            ]
        );
    }

}
