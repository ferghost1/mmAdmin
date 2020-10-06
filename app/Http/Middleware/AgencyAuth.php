<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class AgencyAuth extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    public function handle($request, Closure $next)
    {
        $agency = app('App\Agency')->where('agency_token', $request->header('AgencyToken'))->first();
        
        if (!$agency) {
            die(json_encode([
                'success'   => false,
                'data'      => [],
                'message'   => '',
                'errors'    => ['Unvalid agency token']
            ]));
        }
        
        session()->put('agency', (object) $agency->toArray());
        return $next($request);
    }
}
