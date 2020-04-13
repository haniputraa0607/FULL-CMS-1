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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product-variant'],function() {
	Route::group(['prefix'=>'group'],function(){
	    Route::get('/', ['middleware' => 'feature_control:217', 'uses' => 'ProductGroupController@index']);
	    Route::post('/', ['middleware' => 'feature_control:217', 'uses' => 'ProductGroupController@indexAjax']);
	    Route::get('/create', ['middleware' => 'feature_control:219', 'uses' => 'ProductGroupController@create']);
        Route::any('/image', ['middleware' => 'feature_control:217', 'uses' => 'ProductGroupController@indexImage']);
        Route::any('/image/detail', ['middleware' => 'feature_control:217', 'uses' => 'ProductGroupController@indexImageDetail']);
	    Route::post('/create', ['middleware' => 'feature_control:219', 'uses' => 'ProductGroupController@store']);
	    Route::post('/delete', ['middleware' => 'feature_control:219', 'uses' => 'ProductGroupController@destroy']);
	    Route::get('/reorder', ['middleware' => 'feature_control:220', 'uses' => 'ProductGroupController@reorder']);
	    Route::post('/reorder', ['middleware' => 'feature_control:220', 'uses' => 'ProductGroupController@reorderAjax']);
	    Route::get('/category', ['middleware' => 'feature_control:220', 'uses' => 'ProductGroupController@category']);
	    Route::post('/category', ['middleware' => 'feature_control:220', 'uses' => 'ProductGroupController@categoryUpdate']);
		Route::post('export/{type}', ['middleware' => ['feature_control:220'], 'uses' => 'ProductGroupController@export']);
		Route::post('import/{type}', ['middleware' => ['feature_control:220'], 'uses' => 'ProductGroupController@import']);
		Route::get('import/{type}', ['middleware' => ['feature_control:220'], 'uses' => 'ProductGroupController@importView']);
	    Route::get('/{id}', ['middleware' => 'feature_control:218', 'uses' => 'ProductGroupController@edit']);
	    Route::post('/{id}', ['middleware' => 'feature_control:220', 'uses' => 'ProductGroupController@update']);
	    Route::post('/{id}/assign', ['middleware' => 'feature_control:220', 'uses' => 'ProductGroupController@assign']);
	});
    Route::get('/', ['middleware' => 'feature_control:212', 'uses' => 'ProductVariantController@index']);
    Route::get('/create', ['middleware' => 'feature_control:214', 'uses' => 'ProductVariantController@create']);
    Route::post('/create', ['middleware' => 'feature_control:214', 'uses' => 'ProductVariantController@store']);
    Route::post('/delete', ['middleware' => 'feature_control:216', 'uses' => 'ProductVariantController@destroy']);
    Route::post('/reorder', ['middleware' => 'feature_control:216', 'uses' => 'ProductVariantController@reorder']);
    Route::get('/{id}', ['middleware' => 'feature_control:213', 'uses' => 'ProductVariantController@edit']);
    Route::post('/{id}', ['middleware' => 'feature_control:215', 'uses' => 'ProductVariantController@update']);
});
