<?php

use App\Http\Controllers\OnlinePaymentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/fully_verify', function () {
    return view('emails.fully_verify');
})->name('fully_verify');
Route::get('/processing_document', function () {
    return view('emails.processing_document');
})->name('processing_document');
Route::get('/receive_document', function () {
    return view('emails.receive_document');
})->name('receive_document');
Route::get('/verify', function () {
    return view('emails.verify');
})->name('verify');

Route::get('/clear_cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return  'cleared';
});

Route::get('/callback', [OnlinePaymentController::class, 'paymentCallback'])->name('payTapsCallback');
//Route::post('/callback', [OnlinePaymentController::class, 'paymentCallback'])->name('payTapsCallback');
