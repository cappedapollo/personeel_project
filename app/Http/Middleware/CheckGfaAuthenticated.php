<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Google2FA;

class CheckGfaAuthenticated
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
            $role_code = Auth::user()->user_role->role_code;
            if(Auth::user()->gfa_authenticated == 1 || $role_code=='employee') {
               return $next($request);
            }
            
            if(!isset($redirect)) {
                Google2FA::logout();
                Auth::logout();
                return redirect('login');
            }
            return redirect($redirect);
        }

        return route('login');
    }
}
