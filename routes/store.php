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
    Route::prefix('question')->controller(QuestionController::class)->group(function () {
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/destroy/{id}', 'destroy');
        Route::post('/change_status/{id}', 'change_status');
        Route::delete('/answer/delete/{id}', 'destroyQuestionAnswer');
    });
    Route::prefix('city')->controller(CityController::class)->group(function () {
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/destroy/{id}', 'destroy');
        Route::post('/change_status/{id}', 'change_status');
    });
    Route::prefix('roles')->controller(RoleController::class)->group(function () {
        Route::get('/all_permissions', 'all_permissions');
        Route::get('/admin_permissions', 'admin_permissions');
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/destroy/{id}', 'destroy');
    });
    Route::prefix('branch')->controller(BranchController::class)->group(function () {
        Route::get('', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/destroy/{id}', 'destroy');
        Route::post('/change_status/{id}', 'change_status');
    });
    Route::controller(AdminController::class)->group(function () {
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/destroy/{id}', 'destroy');
        Route::post('/change_status/{id}', 'change_status');
        Route::get('/currency', 'getAdminCurrency');
    });
    Route::prefix('coupons')->controller(CouponController::class)->group(function () {
        Route::get('', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/destroy/{id}', 'destroy');
    });
   Route::controller(ProductController::class)->group(function () {
        Route::post('/create-product', 'createProduct');
        Route::post('/update-product/{id}', 'updateProduct');
        Route::delete('/delete-product/{id}', 'deleteProduct');
        Route::get('/list-products', 'listProducts');
        Route::get('/find-product/{id}', 'findProduct');
   });
   Route::controller(ManufacturingController::class)->group(function () {
        Route::get('/manufactures-list', 'manufactureList');
   });
   Route::controller(GoldPricesController::class)->group(function () {
        Route::get('/list_gold-prices', 'listGoldPrices');
        Route::get('/gold_price/details/{id}', 'findGoldPrices');
        Route::post('/gold_price/update_local/{id}', 'updateLocalGoldPrices')->name('update_gold_local_price');
        Route::post('/gold_price/update_global/{id}', 'updateGlobalGoldPrices')->name('update_gold_global_price');
    });
   Route::controller(GoldPricesHistoryController::class)->group(function () {
        Route::get('/gold_prices/history/list', 'listHistories');
        Route::get('/gold_prices/history/details/{history_id}', 'findHistory');
        Route::post('/gold_prices/history/update/{history_id}', 'updateHistory');
        Route::delete('/gold_prices/history/delete/{history_id}', 'deleteHistory');
    });
    Route::controller(OrdersController::class)->group(function () {
        Route::get('/orders/report', 'allOrdersReport');
        Route::get('/track_order', 'trackOrder');
        Route::get('/order/details/{order_id}', 'findOrder');
        Route::post('/order/change/delivery_status/{order_id}', 'changeDeliveryStatus');
        Route::post('/order/change/accepted_status/{order_id}', 'changeAcceptedStatus');
    });
    Route::put('/settings/update', [SettingController::class, 'updateSetting']);

    Route::controller(WithdrawController::class)->group(function () {
        Route::get('/list/withdraws', 'listWithdraws');
        Route::post('/withdraw/action/{withdraw_id}', 'withdrawAction');
    });

    Route::controller(CampaignController::class)->group(function () {
        Route::post('/create/campaign', 'createCampaign');
        Route::post('/update/campaign/{campaign_id}', 'updateCampaign');
        Route::get('/list/campaigns', 'listCampaigns');
        Route::get('/campaign/details/{campaign_id}', 'findCampaign');
        Route::delete('/delete/campaign/{campaign_id}', 'deleteCampaign');
    });

    
    Route::controller(CategoriesController::class)->group(function () {
        Route::post('/create/category', 'createCategory');
        Route::post('/update/category/{category_id}', 'updateCategory');
        Route::get('/list/categories', 'listCategories');
        Route::get('/category/details/{category_id}', 'findCategory');
        Route::delete('/delete/category/{category_id}', 'deleteCategory');
    });

        
    Route::controller(NewsController::class)->group(function () {
        Route::post('/create/news', 'createNews');
        Route::post('/update/news/{news_id}', 'updateNews');
        Route::get('/list/news', 'listNews');
        Route::get('/news/details/{news_id}', 'findNews');
        Route::delete('/delete/news/{news_id}', 'deleteNews');
    });
});

