<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the 'admin' role
        if ($request->user() && $request->user()->hasRole('admin')) {
            return $next($request);
        }

        // If not, redirect or abort with unauthorized response
        // For example, you can redirect to the login page or return a 403 Forbidden response
        return abort(403, 'Unauthorized.');
    }
}
