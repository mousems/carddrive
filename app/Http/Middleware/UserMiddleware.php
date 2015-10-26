<?php

namespace App\Http\Middleware;

use Session;
use Config;
use PulkitJalan\Google\Client;
use google;

use Closure;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Session::has('access_token')){
            $client = new Client(Config::get('google'));
            $this->googleClient = $client->getclient();
            $this->googleClient->setAccessToken(Session::get('access_token'));

    		if ($this->googleClient->isAccessTokenExpired()) {
    			// $this->googleClient->refreshToken($client->getRefreshToken());
    			// Session::set("access_token",$this->googleClient->getAccessToken());
                return redirect('/logout');
    		}
        }else{
            return redirect('/');
        }
        return $next($request);
    }
}
