<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authedAdmin = Auth::user();
        if ($authedAdmin && $authedAdmin->role_id == 1 /* role of admin */) {
            config(['app.admin_country' => $authedAdmin->country ? $authedAdmin->country->id : null]);
            return $next($request);
        }

        return response()->json([
            'status' => false,
            'code' => 403,
            'message' =>__("You don't have access on this page because this page for admin") ,
        ], 403);
    }
}
