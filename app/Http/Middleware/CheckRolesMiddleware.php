<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckRolesMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        if (Auth::check()) {
            $userRoles = auth()->user()->roles->pluck('name')->toArray();
            $permittedRoles= explode("|",$roles);

            $result= array_intersect($userRoles,$permittedRoles);

            if(auth()->check()){
                if(count($result)>=1){
                    return $next($request);
                }

                // return abort(403);
                return back()->withError("accion no permitida");
            }
        }
        
        return redirect('/login');
    }
}
