<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPlaymi
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (!$request->user()->hasRole("playmi") && $request->user()->hasRole("super admin")) {
                return response()->view("errors.401");
            }
        }

        return $next($request);
    }
}
