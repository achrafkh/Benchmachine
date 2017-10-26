<?php

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

Route::post('payement/callback', 'PaymentController@callback');
Route::post('/pages/validate', 'BenchmarksController@validatePages');
Route::get('/core/end-history/{token}/{id}', 'CoreController@benchmarkReady');
Route::post('/benchmarks/update-title', 'BenchmarksController@updateTitle')->name('updateTitle');
