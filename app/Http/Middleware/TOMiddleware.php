<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class TOMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check() && Auth::user()->position_id == 4){
            return $next($request);
        }
        else
            return redirect()->back();
    }
}
