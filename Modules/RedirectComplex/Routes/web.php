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

Route::group(['middleware' => ['web', 'validate_session', 'config_control:111'], 'prefix' => 'redirect-complex'], function () {
    Route::any('/', 'RedirectComplexController@index');
    Route::any('create', 'RedirectComplexController@create');
    Route::any('edit/{id}', 'RedirectComplexController@edit');
    Route::post('delete', 'RedirectComplexController@delete');
    Route::get('/list/active', 'RedirectComplexController@listActive');
    Route::any('get-data', 'RedirectComplexController@getMasterData');
});
