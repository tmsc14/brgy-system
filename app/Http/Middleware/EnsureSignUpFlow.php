<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSignUpFlow
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
        // Check if the required session variables are set
        if (!$request->session()->has('role') || !$request->session()->has('user_details')) {
            // Redirect to the first step if the session variables are not set
            return redirect()->route('barangay_roles.showSelectRole');
        }

        return $next($request);
    }
}
