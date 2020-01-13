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

Route::prefix('user-rating')->group(function() {
    Route::group(['prefix'=>'option'],function(){
    	Route::get('/','RatingOptionController@index');
    	Route::post('/','RatingOptionController@store');
    	Route::post('update','RatingOptionController@update');
    	Route::post('delete','RatingOptionController@delete');
    });
    Route::get('/detail/{id}', 'UserRatingController@show');
    Route::get('/', 'UserRatingController@index');
    Route::post('/', 'UserRatingController@setFilter');
    Route::get('setting', 'UserRatingController@setting');
    Route::post('setting', 'UserRatingController@settingUpdate');
});
