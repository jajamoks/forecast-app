<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class LatLonValidator
 *
 * Used to validate API requests
 *
 * @package App\Http\Middleware
 */
class LatLonValidator
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
        if (empty($request->get('lat')) || empty($request->get('lon'))) {
            return response('Missing latitude or longitude params.', 400);
        }
        return $next($request);
    }
}
