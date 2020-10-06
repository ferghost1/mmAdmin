<?php

namespace App\Http\Middleware;

use Closure;

class UserAuth
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
        $user = app('App\User')->whereNotNull('api_token')
            ->where('api_token', $request->header('ApiToken'))->first();
        
        if (!$user) {
            die(json_encode([
                'success'   => false,
                'data'      => [],
                'message'   => '',
                'errors'    => ['Unauthorised']
            ]));
        }

        auth()->login($user);
        return $next($request);
    }
}
