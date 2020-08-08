<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Carbon;
use \App\User;
use \App\Http\Resources\UserResource;


class EidController extends Controller
{
    public function update(Request $request)
    {
        $githubUser = $request->user;
        $user = User::findByGithubUser($githubUser);
        $user->eid = Hashids::encode(floor(Carbon::now()->timestamp / 2) . $githubUser->id . rand(0, 10));
        $user->save();
        $subscriptions = $user->pushSubscriptions;
        return new UserResource(collect($user)->merge($githubUser)->merge(['subscriptions' => $subscriptions]));
    }
}
