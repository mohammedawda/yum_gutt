<?php

use App\Http\Middleware\StoreMiddleware;
use getways\orders\controllers\OrdersController;
use getways\products\controllers\ExtraProductController;
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
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('all_sizes', 'allSizes');
        Route::get('all_category', 'allCategory');
        Route::get('menu', 'menu');
        Route::post('create', 'createProduct');
        Route::get('details/{product_id}', 'findProduct');
        Route::put('update/{product_id}', 'updateProduct');
        Route::delete('delete/{product_id}', 'deleteProduct');
    });
    Route::controller(ExtraProductController::class)->prefix('products/{product_id}/extra_product')->group(function () {
        Route::post('create', 'create');
        Route::get('all_category', 'allExtraProductCategory');
        Route::get('category_details/{category_id}', 'extraProduct');

        Route::put('category/update/{category_id}', 'updateExtraProductCategory');
        Route::put('category_details/{category_id}/update/{extraProduct_id}', 'updateExtraProduct');

        Route::delete('category/delete/{category_id}', 'deleteExtraProductCategory');
        Route::delete('category_details/{category_id}/delete/{extraProduct_id}', 'deleteExtraProduct');
    });
//    Route::controller(ScheduleController::class)->group(function () {
//        Route::post('create_schedule', 'createSchedule');
//        Route::post('update_schedule/{schedule_id}', 'updateSchedule');
//        Route::delete('delete_schedule/{schedule_id}', 'deleteSchedule');
//        Route::get('schedule/times', 'scheduleTimes');
//        Route::get('find_schedule/{schedule_id}', 'findSchedule');
//    });
});

