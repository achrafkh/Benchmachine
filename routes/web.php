<?php

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
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/', 'HomeController@index')->name('login');
Route::get('/home', 'HomeController@home')->name('home');

Route::post('/benchmarks/render/{id}', 'BenchmarksController@render')->name('Render');
Route::get('/benchmarks/wkdownload/{id}', 'BenchmarksController@wkdownload')->name('wkdownload');

Route::get('/benchmarks/gen/{id}', 'BenchmarksController@generate')->name('Generate');
Route::get('/benchmarks/static', 'BenchmarksController@showStatic')->name('showStatic');

Route::post('/benchmarks/create', 'BenchmarksController@create')->name('newBench');
Route::get('/benchmarks/{id}', 'BenchmarksController@show')->name('showBench');
Route::get('/benchmarks/download/{id}', 'BenchmarksController@download')->name('showBench');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
