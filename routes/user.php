<?php

use App\Http\Middleware\StoreMiddleware;
use App\Http\Middleware\UserMiddleware;
use getways\orders\controllers\OrdersController;
use getways\stores\controllers\StoresController;
use getways\users\controllers\ProfileController;
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

Route::middleware([UserMiddleware::class])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/user_profile', 'getUserProfile');
        Route::post('/update_profile', 'update_data');
        Route::post('/update_password', 'update_password');
    });
    Route::controller(UsersController::class)->group(function () {
        Route::post('/charge_wallet', 'chargeWallet');
        Route::get('/user_wallet', 'Wallet');
        Route::get('/user_wallet_actions', 'WalletActions');
        Route::get('/currency', 'currency');
        Route::get('/transactions', 'transactions');
    });
});

Route::middleware([StoreMiddleware::class])->group(function () {
    Route::prefix('store')->group(function() {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/store_profile', 'getStoreProfile');
        });
        Route::controller(StoresController::class)->group(function () {
            Route::get('stat', 'getStats');
        });
        Route::controller(OrdersController::class)->group(function () {
            Route::get('/orders/to/deliver', 'ordersToDeliver');
            Route::get('/orders', 'storeOrders');
        });
    });
});

