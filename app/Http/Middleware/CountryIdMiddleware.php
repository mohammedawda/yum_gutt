<?php

namespace App\Http\Middleware;

use Closure;
use getways\users\models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class CountryIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( $request->header('X-country-id')){
            $country = Country::where('code', $request->header('X-country-id'))->first();
            if ($country && $country->status){
                Config::set('app.country_id',$country->id );
                return $next($request);
            }
            return response()->json([
                'status'=>false,
                'message'=>__('This country may not be accessible at this time.')
            ]);

        }
        return response()->json([
            'status'=>false,
            'message'=>__('X-country-id required in headers')
        ]);
    }
}
