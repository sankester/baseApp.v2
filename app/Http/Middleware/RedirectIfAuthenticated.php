<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // get role active
            $role = $request->session()->get('role_active');
            if(!isset($role->default_page)){
                $request->session()->invalidate();
                return redirect('/login');
            }
            // set return
            return redirect($role->default_page);
        }

        return $next($request);
    }
}
