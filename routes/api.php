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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payments', 'PaymentController@store')->name('api.payments.store');
Route::post('/payments/{payment}', 'PaymentController@resolve')->name('api.payments.resolve');
Route::get('/payments', 'PaymentController@index')->name('api.payments.index');
