<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GzipMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (strpos($request->server('HTTP_ACCEPT_ENCODING'), 'gzip') !== false) {
            $response->header('Content-Encoding', 'gzip');
            $response->setContent(gzencode($response->getContent(), 9));
        }

        return $response;
    }
}
