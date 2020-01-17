<?php

namespace App\Http\Middleware;

use Closure;
use Stevebauman\Location\LocationServiceProvider;
use Stevebauman\Location\Drivers\Driver;

class IPAddressCheck
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
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $getLocation = \Location::get($ip);

        if($getLocation && isset($getLocation->countryCode)){
            if($getLocation->countryCode == 'SG' || $getLocation->countryCode == "ID"){
                return $next($request);
            }else{
                return abort(403, 'Unauthorized');
            }
        }else{
            return abort(403, 'Unauthorized');
        }

    }
}
