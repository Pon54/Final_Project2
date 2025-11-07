<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Redirect to /admin if not logged in (session key 'alogin')
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('alogin')) {
            // preserve intended URL and redirect
            return redirect('/admin')->with('error', 'Please log in as admin to access that page.');
        }

        return $next($request);
    }
}
