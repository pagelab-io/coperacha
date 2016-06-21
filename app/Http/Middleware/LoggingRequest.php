<?php

namespace App\Http\Middleware;

use Closure;

class LoggingRequest
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

        \Log::info(
            "\n=========== Request =========== \n".
            "Uri: ".$request->getUri()."\n".
            "ClientIp: ".$request->getClientIp()."\n".
            "SessionId: ".$request->getSession()->getId()."\n".
            "content: ".$request->getContent().
            "\n=========== end Request =========== \n"
        );

        return $next($request);
    }
}
