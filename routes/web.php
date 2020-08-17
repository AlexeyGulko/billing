<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PaymentController@create')->name('payments.create');
Route::post('/register', 'PaymentController@store')->name('payments.store');
Route::get('/payments/{payment}', 'PaymentController@show')->name('payments.show');
Route::post('/payments/{payment}', 'PaymentController@resolve')->name('payments.resolve');
