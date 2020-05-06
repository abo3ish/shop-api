<?php

namespace App\Http\Middleware;

use Closure;

class VerifiedUserMiddleware
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
        if (!auth()->user()->verified) {
            return response()->json([
                'message' => "You Number is not verified"
            ], 401);
        }
        return $next($request);
    }
}
