<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Carbon;

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
        $user['uuid'] = Hashids::encode(floor(Carbon::now()->timestamp / 2) . $user['id'] . rand(0, 10));

        $dbUser = \App\User::where('github_id', $user['id'])->firstOr(function() use($user) {
            return \App\User::create([ 
                'github_id' => $user['id'],
                'uuid' => $user['uuid'],
                'api_token' => $user['token']
            ]);
        });
        $user['uuid'] = $dbUser['uuid'];

        return $user;
    }
}