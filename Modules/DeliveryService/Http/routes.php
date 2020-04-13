<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'delivery-service', 'namespace' => 'Modules\DeliveryService\Http\Controllers'], function () {
    Route::get('/', 'DeliveryServiceController@index');
    Route::post('store', 'DeliveryServiceController@store');
});

Route::group(['prefix' => 'delivery-service', 'namespace' => 'Modules\DeliveryService\Http\Controllers'], function () {
    Route::get('webview', 'DeliveryServiceController@detailWebview');
});
