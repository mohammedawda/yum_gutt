<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Request()->server('HTTP_ACCEPT_LANGUAGE')) {
            App::setLocale(Request()->server('HTTP_ACCEPT_LANGUAGE'));
        } else {
            App::setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
