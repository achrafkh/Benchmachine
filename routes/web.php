<?php

// Test route
Route::get('/testing', 'TestController@test')->name('testing');

Route::get('payment/done/{token}', 'PaymentController@done');
Route::get('payment/error/{token}', 'PaymentController@error');
Route::post('payment/pay/{id}', 'PaymentController@Initpayment');

Route::get('check/{fname}', 'BenchmarksController@tt');

/*
 * Authentication Routes
 */
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/*
 * Authentication is NOT required to access this routes
 */
Route::get('/', 'HomeController@index')->name('login');
Route::get('benchmarks/render/{id}/{secret}', 'BenchmarksController@render')->name('Render');
/*
 * Authentication is required to access this routes
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@home')->name('home');

    /**
     ** Benchmarks Routes
     **/
    Route::prefix('benchmarks')->group(function () {
        Route::get('{id}', 'BenchmarksController@showStatic')->name('showBench');
        //Route::get('{id}', 'BenchmarksController@show')->name('showBench');
        Route::get('gen/{id}', 'BenchmarksController@generate')->name('Generate');
        Route::get('download/{id}', 'BenchmarksController@download')->name('showBench');
        Route::get('wkdownload/{id}', 'BenchmarksController@wkdownload')->name('wkdownload');

        Route::post('create', 'BenchmarksController@create')->name('newBench');
        Route::post('create-demo', 'BenchmarksController@createDemo')->name('newDemoBench');
        Route::post('wkdownload/{id}', 'BenchmarksController@wkdownload')->name('wkdownloadPost');
    });

});
