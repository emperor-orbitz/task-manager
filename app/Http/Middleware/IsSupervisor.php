<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;

class IsSupervisor
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
        $isSupervisor = config('constants.options.IS_DEPT');

        if (Auth::user()['role'] === $isSupervisor) {
            return $next($request);
        } else {
            return abort(401);
        }
    }
}
