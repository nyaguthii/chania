<?php

namespace App\Http\Middleware;

use Closure;

class Cashier
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
        if (!$request->user()->hasRole(['CASHIER','MANAGER','ADMIN'])) {
            return response("You are not suppossed to be here", 401);
        }else{
            return $next($request);
        }
       
    }
}
