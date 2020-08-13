<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class allowUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = ""; //place your token here

        if($request->header('token')==$auth){
            return $next($request);
        }

        else{
            return ("<h1><marquee>You not have permissions to view this!!</marquee></h1>");
        }
    }
}
