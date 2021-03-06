<?php

namespace App\Http\Middleware;

use Closure;

class LoggingResponse
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
        $response = $next($request);
        $api = 'api/v1';
        $api_log = strpos($request->getUri(), $api);
        if ($api_log !== false) {
            \Log::info(
                "\n=========== Response =========== \n".
                "SessionId: ".$request->getSession()->getId()."\n".
                "Response: ".$response."\n".
                "\n=========== end Response =========== \n"
            );
        }

        return $response;
    }
}
