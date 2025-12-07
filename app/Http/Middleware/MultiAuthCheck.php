<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class MultiAuthCheck
{
    /**
     * Handle an incoming request.
     * Check if user is authenticated via session
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Share user data with all views
        view()->share('currentUser', [
            'id' => Session::get('user_id'),
            'name' => Session::get('user_name'),
            'role' => Session::get('user_role'),
        ]);

        return $next($request);
    }
}
