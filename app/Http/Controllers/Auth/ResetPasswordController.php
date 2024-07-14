<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/dashboard/barangay-captain';

    protected function broker()
    {
        return \Password::broker('barangay_captains');
    }
}
