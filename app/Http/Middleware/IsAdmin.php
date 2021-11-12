<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
 
class IsAdmin
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
        if(auth()->user()!=null && (auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'SuperAdmin')){
            return $next($request);
        }
   
        return redirect('/')->with('error',"You don't have admin access.");
    }
}
