<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'brand', 'namespace' => 'Modules\Brand\Http\Controllers'], function () {
    Route::get('/', 'BrandController@index');
    Route::post('/reorder', 'BrandController@reOrder');
    Route::get('create', 'BrandController@create');

    Route::get('detail/{id}', 'BrandController@show');
    Route::get('outlet/{id}', 'BrandController@show');
    Route::get('product/{id}', 'BrandController@show');
    Route::get('deals/{id}', 'BrandController@show');

    Route::post('outlet/{id}/list', 'BrandController@list');
    Route::post('product/{id}/list', 'BrandController@list');

    Route::post('outlet/store', 'BrandController@createOutlet');
    Route::post('product/store', 'BrandController@createProduct');

    Route::post('store', 'BrandController@store');
    Route::any('delete', 'BrandController@destroy');
    Route::any('inactive-image', 'BrandController@inactiveImage');

    Route::get('switch_status', 'BrandController@switchStatus');
    Route::get('switch_visibility', 'BrandController@switchVisibility');

    Route::group(['prefix' => 'delete'], function () {
        Route::post('outlet', 'BrandController@destroy');
        Route::post('product', 'BrandController@destroy');
        Route::post('deals', 'BrandController@destroy');
    });
});
