<?php

use App\Http\Middleware\StoreMiddleware;
use getways\orders\controllers\OrdersController;
use getways\products\controllers\ProductController;
use getways\schedule\controllers\ScheduleController;
use getways\stores\controllers\StoresController;
use getways\users\controllers\ProfileController;
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

Route::middleware([StoreMiddleware::class])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('store_profile', 'getStoreProfile');
    });
    Route::controller(StoresController::class)->group(function () {
        Route::get('stat', 'getStats');
    });
    Route::controller(OrdersController::class)->group(function () {
        Route::get('orders/to/deliver', 'ordersToDeliver');
        Route::get('orders', 'storeOrders');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::post('create_product', 'createProduct');
        Route::post('update_product/{product_id}', 'updateProduct');
        Route::delete('delete_product/{product_id}', 'deleteProduct');
        Route::get('menu', 'menu');
        Route::get('find_product/{product_id}', 'findProduct');
    });
    Route::controller(ScheduleController::class)->group(function () {
        Route::post('create_schedule', 'createSchedule');
        Route::post('update_schedule/{schedule_id}', 'updateSchedule');
        Route::delete('delete_schedule/{schedule_id}', 'deleteSchedule');
        Route::get('schedule/times', 'scheduleTimes');
        Route::get('find_schedule/{schedule_id}', 'findSchedule');
    });
});

