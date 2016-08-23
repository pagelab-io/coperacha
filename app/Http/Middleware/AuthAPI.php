<?php

namespace App\Http\Middleware;

use Closure;

class AuthAPI
{

    public function handle($request, Closure $next)
    {
        if (!$request->exists("api-key")) {
            return response('Unauthorized, api-key is required', 403);
        }

        if ($request->get('api-key') != env('api-key')) {
            return response('Unauthorized, incorrect api-key.', 403);
        }

        return $next($request);
    }
}
