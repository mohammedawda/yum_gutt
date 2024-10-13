<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\TrueCountryMiddleware;
use getways\admins\controllers\AdminController;
use getways\blog\controllers\CategoriesController;
use getways\blog\controllers\NewsController;
use getways\campaign\controllers\CampaignController;
use getways\cores\controllers\CityController;
use getways\cores\controllers\RoleController;
use getways\goldPrices\controllers\GoldPricesController;
use getways\goldPrices\controllers\GoldPricesHistoryController;
use getways\orders\controllers\CouponController;
use getways\orders\controllers\OrdersController;
use getways\payment\controllers\WithdrawController;
use getways\products\controllers\ManufacturingController;
use getways\products\controllers\ProductController;
use getways\settings\controllers\BranchController;
use getways\settings\controllers\QuestionController;
use getways\settings\controllers\SettingController;
use getways\users\controllers\AdminUsersController;
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


Route::middleware([AdminMiddleware::class])->group(function () {
    
    Route::controller(UsersController::class)->group(function () {
        Route::post('/create-user', 'createUser');
        Route::post('/user/block/{id}', 'block');
        Route::get('/user/active/{id}', 'active');
    });
    Route::controller(AdminUsersController::class)->group(function () {
        Route::get('/users', 'allUsers')->middleware('permission:users_index');
        Route::get('/users/show/{id}', 'user_show')->name('admin_show_user')->middleware('permission:users_show');;
        Route::get('/users/transactions', 'user_transaction')->name('users.transactions');
        Route::post('/users/transactions/block', 'block');
        Route::post('/users/transactions/active', 'active');
        Route::get('/users/usersAnswer', 'allUsersAnswer');
    });
});

