<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureBarangayCaptainIsAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('barangay_captain')->check()) {
            return redirect()->route('barangay_captain.login')->with('error', 'You must be logged in to access this page.');
        }

        return $next($request);
    }
}
