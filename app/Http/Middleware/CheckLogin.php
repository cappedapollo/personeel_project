<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Google2FA;

class CheckLogin
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
        if(Auth::check()) {
            if(Auth::user()->gfa_setup == 1) {
               return $next($request);
            }else {
                $redirect = app()->getLocale().'/verify';
            }
            
            if(!isset($redirect)) {
                Google2FA::logout();
                Auth::logout();
                return redirect(app()->getLocale().'/login');
            }
            return redirect($redirect);
        }

        //return route('login', app()->getLocale());
        return redirect( app()->getLocale().'/login');
    }
}
