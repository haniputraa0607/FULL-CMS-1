<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'custom-page', 'namespace' => 'Modules\CustomPage\Http\Controllers'], function () {
    Route::get('/', 'CustomPageController@index');

    Route::get('create', ['middleware' => 'config_control:50', 'uses' => 'CustomPageController@create']);
    Route::post('create', ['middleware' => 'config_control:50', 'uses' => 'CustomPageController@store']);

    Route::get('detail/{id}', ['middleware' => 'config_control:50', 'uses' => 'CustomPageController@show']);

    Route::get('edit/{id}', ['middleware' => 'config_control:50', 'uses' => 'CustomPageController@edit']);
    Route::post('edit/{id}', ['middleware' => 'config_control:50', 'uses' => 'CustomPageController@update']);

    Route::get('delete/{id}', ['middleware' => 'config_control:50', 'uses' => 'CustomPageController@destroy']);
});

