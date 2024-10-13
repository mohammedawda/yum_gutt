<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiPasswordMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(empty($request->header('x-api-key'))) {
            return sendMessage(false, __('Missing required headers'), "", 400);
        } elseif($request->header('x-api-key') != env('API_PASSWORD', 'yum_gutt_1666')) {
            return sendMessage(false, __('You are not authorized'), "", 401);
        }
        return $next($request);
    }
}
