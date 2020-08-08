<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\User;
use App\Notifications\WebPushNotification;

class NotifyController extends Controller
{ 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $eid)
    {
        $user = User::findByEID($eid);
        if($user == null)
            return abort(404);

        Notification::send($user, new WebPushNotification($request->all()));
        return response("no content", 204);
    }
    
}

class StoreRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:128',
            'body' => 'nullable|string|max:255',
        ];
    }
}