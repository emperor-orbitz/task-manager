<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

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
        $isAdmin = config('constants.options.IS_ADMIN');

        if(Auth::user()['role'] === $isAdmin){
            return $next($request);
        }
        else{
            return abort(401);
        }
    }
}
