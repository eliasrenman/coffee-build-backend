<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {

            Socialite::driver('github')
                ->stateless()
                ->userFromToken($request->header('Authorization'));
            return $next($request);
        } catch (\Exception $e) {
            return abort(401, "Invalid Credentials");
        }

    }
}
