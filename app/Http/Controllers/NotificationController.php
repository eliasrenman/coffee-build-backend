<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $user = $request->validate([
            ''
        ]);
    }

    public function updateUUID()
    {
        
    }
}
