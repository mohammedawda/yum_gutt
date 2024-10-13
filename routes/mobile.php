<?php

use App\Http\Middleware\TrueCountryMiddleware;
use App\Http\Middleware\UserMiddleware;
use getways\orders\controllers\CouponController;
use getways\orders\controllers\OrdersController;
use getways\products\controllers\ProductController;
use getways\users\controllers\AddressController;
use getways\users\controllers\AuthController;
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
        Route::get('/profile', 'get_data');
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
    Route::controller(OrdersController::class)->group(function () {
        Route::post('/purchase/{order_type}', 'purchaseOrder');
        Route::post('/normal_order/add_to_cart', 'addToCart');
        Route::get('/normal_order/user_bag', 'bag');
        Route::delete('/normal_order/delete_from_cart/{cart_id}', 'deleteFromBag');
        Route::get('/track_order', 'trackOrder');
    });

    Route::get('/coupon/check', [CouponController::class, 'couponCheck']);

    Route::prefix('address')->controller(AddressController::class)->group(function () {
        Route::get('', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/destroy/{id}', 'destroy');
    });

});

