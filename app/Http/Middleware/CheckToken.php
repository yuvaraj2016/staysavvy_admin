<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
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

        if(session()->has('token'))
        {
            // session()->flush();
            // echo "sadf";exit;
        }
        else {

            return redirect()->route('home');
        }

         return $next($request);
    }
}
