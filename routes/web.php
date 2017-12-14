<?php

Route::post('api/pages/validate', 'HomeController@validatePages');
Route::post('api/details', 'HomeController@saveDetails');
Route::post('/api/update-int', 'ChartsApiController@interactionsData');
Route::post('/api/update-eng', 'ChartsApiController@engagmentData');

Route::get('api/show-modal/{id}', 'HomeController@showModal');

Route::get('/default/{print}', 'HomeController@defaultBenchmark')->name('defaultBench');

Route::get('payment/done/{token}', 'PaymentController@done');
Route::get('payment/error/{token}', 'PaymentController@error');
Route::post('payment/pay/{id}', 'PaymentController@Initpayment');
Route::get('payment/pay/{id}', 'PaymentController@getInitpayment');

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
Route::get('benchmarks/render/{id}/{col}/{type}/{date_en}/{date_in}', 'BenchmarksController@render')->name('Render');
Route::get('benchmarks/init/{id}', 'HomeController@showDemoStatic')->name('showDemoBench');
Route::post('create-demo', 'HomeController@createDemo')->name('newDemoBench');
/*
 * Authentication is required to access this routes
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@home')->name('home');
    Route::post('/email-edit', 'HomeController@editEmail')->name('editEmail');
    Route::post('/payment/stripecheckout', 'CheckoutController@checkout')->name('stripeCheckout');
    Route::post('/payment/gpgcheckout', 'CheckoutController@gpgCheckout')->name('gpgCheckout');

    /**
     ** Benchmarks Routes
     **/
    Route::prefix('benchmarks')->group(function () {
        //Route::get('{id}', 'BenchmarksController@show')->name('showBench');
        Route::get('{id}', 'BenchmarksController@showStatic')->name('showBench');
        Route::get('gen/{id}', 'BenchmarksController@generate')->name('Generate');
        Route::get('download/{id}', 'BenchmarksController@download')->name('showBench');
        Route::get('wkdownload/{id}', 'BenchmarksController@wkdownload')->name('wkdownload');

        Route::post('create', 'BenchmarksController@create')->name('newBench');

        Route::post('wkdownload/{id}', 'BenchmarksController@wkdownload')->name('wkdownloadPost');
    });

});
