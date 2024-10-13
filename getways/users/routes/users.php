<?php 

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for users getway. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware' => ['country', 'lang', 'apiPassword']], function () {
    //users routes
    Route::namespace('getways\users\controllers')->group(function () {
        //none authed routes
        Route::post('login', 'UsersController@login');
        Route::post('register', 'UsersController@register');
        Route::post('/reset-password', 'UsersController@reset');
        //authed routes
        Route::group(['middleware' => 'auth:api'], function () {
            //
        });
    });
});