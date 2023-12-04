<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenMiddleware
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
        $apiToken = $request->header('api_token');

        if (!$apiToken) {
            // Token is not present, redirect to login
            return redirect('/login');
        }

        // Check if the token is valid (adjust this based on your actual implementation)
        $user = Auth::guard('api')->user();

        if (!$user) {
            // Invalid token, redirect to login
            return redirect('/login');
        }

        // Token is valid, continue with the request
        return $next($request);
    }
}
