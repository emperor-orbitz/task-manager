<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsUser
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
        $isUser = config('constants.options.IS_USER');

        if (Auth::user()['role'] === $isUser) {
            return $next($request);
        } else {
            return abort(401);
        }
    }
}
