<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PushSubscriptionCollection;
use \NotificationChannels\WebPush\PushSubscription;
use \App\User;

class PushSubscriptionController extends Controller
{
    public function store(Request $request) {
        $validated = $this->validate($request, [
            'device' => 'required',
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);

        $user = User::findByGithubUser($request->user);
        
        $user->updatePush($request->endpoint, $request->device, $request->keys['auth'], $request->keys['p256dh']);
        
        return response('Added succesfully', 201);
    }

    public function index(Request $request)
    {
        $user = User::findByGithubUser($request->user);

        return new PushSubscriptionCollection($user->pushSubscriptions);
    }

    public function delete(Request $request, $id)
    {
        PushSubscription::destroy($id);

        return response(204);
    }
}
