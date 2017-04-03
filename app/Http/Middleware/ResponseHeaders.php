<?php

namespace App\Http\Middleware;

use Closure;

class ResponseHeaders
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

        $response->headers->set('X-Experience-API-Version', '1.0.1');

        if (isset($_SERVER['HTTP_ORIGIN'])) {
          $response->headers->set('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN']);
        }

        return $response;
    }
}
