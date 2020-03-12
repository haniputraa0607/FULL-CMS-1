<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'outlet', 'namespace' => 'Modules\Outlet\Http\Controllers'], function()
{
    Route::get('list', ['middleware' => 'feature_control:24', 'uses' => 'OutletController@index']);
    Route::any('ovo/list', ['middleware' => 'feature_control:24', 'uses' => 'OutletController@ovoList']);
    Route::any('ajax_handler', ['middleware' => 'feature_control:24', 'uses' => 'OutletController@ajaxHandler']);
    Route::get('getuser', ['middleware' => 'feature_control:40', 'uses' => 'OutletController@getUser']);
    Route::get('ajax', ['middleware' => 'feature_control:24', 'uses' => 'OutletController@indexAjax']);
    Route::get('ajax/filter/{type}', ['middleware' => 'feature_control:24', 'uses' => 'OutletController@indexAjaxFilter']);
    Route::any('create', ['middleware' => 'feature_control:26', 'uses' => 'OutletController@create']);
    Route::get('detail/{id}', ['middleware' => 'feature_control:25', 'uses' => 'OutletController@detail']);
    Route::post('detail/{id}', ['middleware' => 'feature_control:27', 'uses' => 'OutletController@detail']);
    Route::get('manage-location', ['middleware' => 'feature_control:27', 'uses' => 'OutletController@manageLocation']);
    Route::post('manage-location', ['middleware' => 'feature_control:27', 'uses' => 'OutletController@manageLocationPost']);
    Route::post('update/status', ['middleware' => 'feature_control:27', 'uses' => 'OutletController@updateStatus']);
    Route::post('get/city', 'OutletController@getCity');
    Route::post('delete', ['middleware' => 'feature_control:28', 'uses' => 'OutletController@delete']);
    Route::get('export', ['middleware' => ['feature_control:33', 'config_control:3'], 'uses' => 'OutletController@exportForm']);
    Route::post('export', ['middleware' => ['feature_control:33', 'config_control:3'], 'uses' => 'OutletController@exportData']);
    Route::get('import', ['middleware' => ['feature_control:32,33', 'config_control:2,3,or'], 'uses' => 'OutletController@import']);
    Route::post('import', ['middleware' => 'feature_control:32', 'uses' => 'OutletController@importOutlet']);
    Route::any('qrcode', ['middleware' => 'feature_control:32', 'uses' => 'OutletController@qrcodeView']);
    Route::any('qrcode/export', ['middleware' => 'feature_control:32','uses' => 'OutletController@qrcodeExport']);
    Route::any('qrcode/reset', ['middleware' => 'feature_control:32', 'uses' => 'OutletController@qrcodeReset']);
    Route::get('qrcode/print', ['middleware' => 'feature_control:32', 'uses' => 'OutletController@qrcodePrint']);
    Route::get('export-import', ['middleware' => ['feature_control:32,33', 'config_control:2,3,or'], 'uses' => 'OutletController@exportImport']);
    Route::post('import-brand', ['middleware' => 'feature_control:32', 'uses' => 'OutletController@importBrand']);
    Route::get('export/brand-outlet', ['middleware' => 'feature_control:32', 'uses' => 'OutletController@exportBrandOutle']);
    Route::get('export-city', 'OutletController@exportDataCity');

    // photo
    Route::post('photo/delete', ['middleware' => 'feature_control:31', 'uses' => 'OutletController@deletePhoto']);
    Route::post('schedule/save', ['middleware' => 'feature_control:31', 'uses' => 'OutletController@scheduleSave']);
    //different price
    Route::get('different-price', ['middleware' => 'feature_control:24', 'uses' => 'OutletController@differentPrice']);
    Route::post('different-price', ['middleware' => 'feature_control:24', 'uses' => 'OutletController@getDifferentPrice']);
    Route::post('different-price/update', ['middleware' => 'feature_control:24', 'uses' => 'OutletController@updateDifferentPrice']);

    // holiday
    Route::group(['middleware' => 'config_control:4'], function()
    {
        Route::get('holiday', ['middleware' => 'feature_control:34', 'uses' => 'OutletController@Holiday']);
        Route::any('holiday/{id_holiday}', ['middleware' => 'feature_control:35', 'uses' => 'OutletController@detailHoliday']);
        Route::post('create/holiday', ['middleware' => 'feature_control:36', 'uses' => 'OutletController@createHoliday']);
        Route::post('delete/holiday', ['middleware' => 'feature_control:38', 'uses' => 'OutletController@deleteHoliday']);
    });

    Route::group(['prefix' => 'detail/{outlet_code}/admin', 'middleware' => 'config_control:5'], function()
    {
        Route::any('create', ['middleware' => 'feature_control:40', 'uses' => 'OutletController@createAdminOutlet']);
        Route::post('delete', ['middleware' => 'feature_control:42', 'uses' => 'OutletController@deleteAdminOutlet']);
        Route::get('edit/{id_user_outlet}', ['middleware' => 'feature_control:39', 'uses' => 'OutletController@detailAdminOutlet']);
        Route::post('edit/{id_user_outlet}', ['middleware' => 'feature_control:41', 'uses' => 'OutletController@updateAdminOutlet']);
    });

});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'outlet', 'namespace' => 'Modules\Advert\Http\Controllers'], function()
{
    /* ADVERT */
    Route::any('advert', 'AdvertController@index');
});

Route::group(['prefix' => 'outlet', 'namespace' => 'Modules\Outlet\Http\Controllers'], function()
{
    Route::any('webview/{id}', 'WebviewController@detailWebview');
    Route::any('webview/gofood/list', 'WebviewGofoodController@listOutletGofood');
    Route::any('webview/gofood/list/v2', 'WebviewGofoodController@listOutletGofood');
});