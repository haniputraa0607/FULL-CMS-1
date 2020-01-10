<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'point-injection', 'namespace' => 'Modules\PointInjection\Http\Controllers'], function () {
    Route::any('/', 'PointInjectionController@index');
    Route::get('create', 'PointInjectionController@create');
    Route::post('create', 'PointInjectionController@store');
    Route::get('review/{id_point_injection}', 'PointInjectionController@review');
    Route::get('edit/{id_point_injection}', 'PointInjectionController@show');
    Route::post('edit/{id_point_injection}', 'PointInjectionController@update');
    Route::get('delete/{id_point_injection}', 'PointInjectionController@destroy');
    Route::post('edit/{id_point_injection}/page/{page}', 'PointInjectionController@update');
    Route::any('/page/{page}', 'PointInjectionController@index');
    Route::any('/review/{id_point_injection}/page/{page}', 'PointInjectionController@review');
    Route::get('/edit/{id_point_injection}/page/{page}', 'PointInjectionController@show');
});
