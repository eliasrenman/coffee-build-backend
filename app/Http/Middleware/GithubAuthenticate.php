<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
            $user = Socialite::driver('github')
                ->stateless()
                ->userFromToken(Str::after($request->header('Authorization'), 'Bearer '));
            
            $request->merge(['user' => $user ]);
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
            
            return $next($request);
        } catch (\Exception $e) {
            return abort(401, "Invalid Credentials");
        }

    }
}
