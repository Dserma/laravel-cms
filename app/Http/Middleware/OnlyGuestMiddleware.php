<?php

namespace App\Http\Middleware;

use Closure;

class OnlyGuestMiddleware
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
        if ($request->user() != false) {
            return response()->redirectTo(route('sistema.index'));
        }

        return $next($request);
    }
}
