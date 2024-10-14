<?php

use App\Http\Middleware\AdminMiddleware;
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
        Route::post('/create_user', 'createUser');
        Route::get('find/user/{user_id}', 'userFind');
        Route::get('delete/user/{user_id}', 'deleteUser');
        Route::get('/stores/all', 'allStores');
        Route::get('/users/all', 'allUsers');
        Route::post('/user/block/{id}', 'block');
        Route::get('/user/active/{id}', 'active');
    });
    Route::controller(AdminUsersController::class)->group(function () {
        Route::get('/users/show/{id}', 'user_show')->name('admin_show_user')->middleware('permission:users_show');;
        Route::get('/users/transactions', 'user_transaction')->name('users.transactions');
        Route::post('/users/transactions/block', 'block');
        Route::post('/users/transactions/active', 'active');
        Route::get('/users/usersAnswer', 'allUsersAnswer');
    });
});

