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

Route::prefix('user-rating')->middleware(['web', 'validate_session'])->group(function() {
	Route::post('option','RatingOptionController@store');
    Route::get('/detail/{id}', 'UserRatingController@show');
    Route::get('/', 'UserRatingController@index');
    Route::post('/', 'UserRatingController@setFilter');
    Route::get('setting', 'UserRatingController@setting');
    Route::post('setting', 'UserRatingController@settingUpdate');
    Route::get('setting', 'UserRatingController@setting');
    Route::post('setting', 'UserRatingController@settingUpdate');
    Route::any('autoresponse', 'UserRatingController@autoresponse');
    Route::group(['prefix'=>'report'],function(){
	    Route::get('/', 'UserRatingController@report');
	    Route::post('/', 'UserRatingController@setReportFilter');
	    Route::get('outlet', 'UserRatingController@reportOutlet');
	    Route::get('outlet/{outlet_code}', 'UserRatingController@reportOutletDetail');
	    Route::get('rating/{rating}', 'UserRatingController@reportRatingDetail');
	});
});
