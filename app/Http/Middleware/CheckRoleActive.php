<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleActive
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
        if(! $request->session()->has('role_active')){
            $request->session()->invalidate();
            return redirect('/login');
        }
        return $next($request);
    }
}
