<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    if (Session::has('access_token')) {
        return redirect('/home');
    }else{
        $client = new PulkitJalan\Google\Client(Config::get('google'));
        $googleClient = $client->getclient();
        $auth_url = $googleClient->createAuthUrl();
        return view('welcome', [
            "url"=>$auth_url
        ]);
    }

});


Route::get('/auth_callback', function () {
    $client = new PulkitJalan\Google\Client(Config::get('google'));
    $googleClient = $client->getclient();
    $auth_url = $googleClient->createAuthUrl();
    try {
        $accessToken_pack = $googleClient->authenticate(Request::input('code'));

		Session::Set("access_token", $accessToken_pack);
        return redirect('/home');


    } catch (Exception $e) {
        return view('welcome', [
            "error"=>"Oops! Something wrong.",
            "url"=>$auth_url
        ]);
    }
});


Route::get('/home', 'CardDriveController@home');

Route::get('/logout', function(){
    Session::flush();
    return redirect('/');
});

Route::get('/api/appfolder/info', 'GDController@appfolder_info');

Route::get('/api/appfolder/createfile', 'GDController@appfolder_createfile');

Route::get('/api/appfolder/showall', 'GDController@appfolder_list');
Route::get('/api/file/{fileID}', 'GDController@getFileByID');


Route::get('/api/vcard/get', 'GDController@getvcard');
Route::get('/api/contact/me', 'GDController@contact_me');
