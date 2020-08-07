<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \NotificationChannels\WebPush\PushSubscription;

class PushSubscriptionController extends Controller
{
    public function store(Request $request) {
        $validated = $this->validate($request, [
            'device' => 'required',
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $id = $request->user->id;
        $user = \App\User::find($id);
        $user->updatePush($request->endpoint, $request->device, $request->keys['auth'], $request->keys['p256dh']);
        
        return [
            'message' => 'Success',
        ];
    }
}
