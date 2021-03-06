<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class UserAccessRestrictMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (Auth::id() === $request->user->id || Auth::user()->can($permission)) {
            return $next($request);
        } else {
            return abort(403);
        }
    }
}
