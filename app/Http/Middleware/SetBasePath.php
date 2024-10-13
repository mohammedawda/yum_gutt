<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetBasePath
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        URL::forceRootUrl(config('app.url'));
        $scriptName = $request->server('SCRIPT_NAME');
        $basePath = implode('/', array_slice(explode('/', $scriptName), 0, -1));
        URL::forceRootUrl(config('app.url') . $basePath);
        URL::forceScheme($request->getScheme());

        return $next($request);
    }
}
