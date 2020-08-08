<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Carbon;
use \App\User;
use \App\Http\Resources\UserResource;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->stateless()->redirect()->getTargetUrl();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = collect(Socialite::driver('github')->stateless()->user())->only([
          'token', 'name', 'avatar', 'id'
        ]);
        
        $dbUser = User::firstOrCreate(['github_id' => $user['id']],[
            'eid' => Hashids::encode(floor(Carbon::now()->timestamp / 2) . $user['id'] . rand(0, 10)),
        ]);
        $subscriptions = $dbUser->pushSubscriptions;
        
        return new UserResource($user->merge($dbUser)->merge(['subscriptions' => $subscriptions]));
    }
}