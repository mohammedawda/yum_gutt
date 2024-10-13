<?php

use getways\cores\controllers\GeneralApiController;
use getways\settings\controllers\SettingController;
use getways\users\controllers\AuthController;
use getways\users\controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/admin/login', 'admin_login');
    Route::post('/register', 'register')->name('register');
    Route::post('/verify', 'verify_user');
    Route::post('/forget_password', 'reset');
    Route::post('/change_password', 'change_password');
    Route::post('/send_verify', 'send_verify_user');
    Route::post('/logout', 'logout')->middleware('auth:api');
    Route::post('/admin_logout', 'admin_logout')->middleware('auth:api');
});
Route::get('/settings', [SettingController::class, 'setting']);
Route::get('/payment_methods', [GeneralApiController::class, 'payment_method'])/*->withoutMiddleware(TrueCountryMiddleware::class)*/;
Route::get('/cities', [GeneralApiController::class, 'cities']);
Route::get('/countries', [GeneralApiController::class, 'countries']);

Route::prefix('user')->group(function () {
    Route::get('/branches', [UsersController::class, 'branches']);
    require __DIR__ . '/mobile.php';
});

Route::prefix('admin')->group(function () {
    require __DIR__ . '/admin.php';
});
