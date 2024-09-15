<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            $role = session('role');
    
            if ($role === 'barangay_staff' || $role === 'barangay_official') {
                return route('barangay_roles.showUnifiedLogin'); // Redirect to unified login for roles
            }
    
            return route('barangay_captain.login'); // Redirect to barangay captain login
        }
    }
}
