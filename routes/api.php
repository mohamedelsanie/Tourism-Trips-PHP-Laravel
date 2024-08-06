<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Payment Routes
Route::namespace('App\Http\Controllers')->prefix('payment')->name('payment.')->group(function(){
    Route::post('pay', 'PaymentController@pay')->name('pay');
    Route::get('error', 'PaymentController@error')->name('error');
    Route::get('success', 'PaymentController@success')->name('success');
});