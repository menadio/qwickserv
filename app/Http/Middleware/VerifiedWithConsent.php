<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedWithConsent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->consent)
            return response()->json([
                'success'   => false,
                'message'   => 'Accept our T&C to continue'
            ], 400);

        return $next($request);
    }
}
