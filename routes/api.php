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
Route::get('/core/end-history/{token}/{id}', 'CoreController@benchmarkReady');
Route::post('/benchmarks/update-title', 'BenchmarksController@updateTitle')->name('updateTitle');

Route::get('/admin/users', 'admin\UsersController@usersJson');

Route::get('/admin/benchmarks/{id?}', 'admin\UsersController@benchmarksJson');

Route::get('/admin/invitations', 'admin\InvitationsController@getInvitations');
Route::post('/admin/invitations/new', 'admin\InvitationsController@generate');

Route::post('/admin/invitations/delete/{id}', 'admin\InvitationsController@delete');
