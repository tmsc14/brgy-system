<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function clearNotifications(Request $request)
    {
        // Clear the session notification
        Session::forget('success');

        // Optionally, you can clear other notifications or log the action here

        return response()->json(['message' => 'Notifications cleared'], 200);
    }
}
