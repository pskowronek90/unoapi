<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyClientCredentials
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            ($request->headers->has('client-name') && $request->header('client-name') === $_ENV['API_DATA_CLIENT_NAME']) &&
            ($request->headers->has('client-secret') && $request->header('client-secret') === $_ENV['API_DATA_CLIENT_SECRET'])
        ) {
            return $next($request);
        } else {
            return response()->json('401 Unauthorized', 401);
        }
    }
}
