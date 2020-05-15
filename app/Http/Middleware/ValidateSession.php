<?php

namespace App\Http\Middleware;

use Closure;

class ValidateSession
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
        if(session()->has('phone')){
            if(!strpos(url()->current(),'user/detail') && !strpos(url()->current(),'user/ajax') && !strpos(url()->current(),'user/log')){
                session(['secure' => false]);
            }elseif(session('secure') && session('secure_last_activity') >= (time() - 900)){
                session(['secure_last_activity' => time()]);
            }
            return $next($request);
        }
        else{ return redirect('login')->withErrors(['e' => 'Please login.']);}
    }
}
