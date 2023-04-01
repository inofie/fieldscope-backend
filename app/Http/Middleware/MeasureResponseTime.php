<?php // File: app/Http/Middleware/MeasureResponseTime.php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MeasureResponseTime
{
    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @param  \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        // Add response time as an HTTP header. For better accuracy ensure this middleware
        // is added at the end of the list of global middlewares in the Kernel.php file
        if (defined('LARAVEL_START') and $response instanceof Response) {
            $response->headers->add(['X-RESPONSE-TIME' => microtime(true) - LARAVEL_START]);
        }

        return $response;
    }

    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @param  \Symfony\Component\HttpFoundation\Response $response
     * @return void
     */
    public function terminate($request, $response)
    {

//        logger('MeasureResponseTime',['terminate'=> 'Inside method']);
        // At this point the response has already been sent to the browser so any
        // modification to the response (such adding HTTP headers) will have no effect
        if (defined('LARAVEL_START') and $request instanceof Request) {

            logger('Response time', [[
                'method' => $request->getMethod(),
                'uri' => $request->getRequestUri(),
                'seconds' => microtime(true) - LARAVEL_START,
            ]]);
//            app('log')->debug('Response time');
        }
    }
}