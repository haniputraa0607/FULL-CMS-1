<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'setting-fraud-detection', 'namespace' => 'Modules\SettingFraud\Http\Controllers'], function()
{
    Route::any('/', 'SettingFraudController@index');
    Route::any('detail/{id}', 'SettingFraudController@detail');
    Route::post('update/status', 'SettingFraudController@updateStatus');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'fraud-detection', 'namespace' => 'Modules\SettingFraud\Http\Controllers'], function()
{
    Route::any('filter/reset/{session}', 'SettingFraudController@searchReset');
    /*== Report ==*/
    Route::post('update/status', 'SettingFraudController@updateStatus');
    Route::any('report/{type}', 'SettingFraudController@fraudReport');
    Route::get('report/detail/device/{device_id}', 'SettingFraudController@fraudReportDeviceDetail');
    Route::get('report/detail/transaction-day/{id}', 'SettingFraudController@fraudReportTransactionDayDetail');
    Route::get('report/detail/transaction-week/{id}', 'SettingFraudController@fraudReportTransactionWeekDetail');
    Route::post('update/suspend/{type}/{phone}', 'SettingFraudController@updateSuspend');
    Route::post('update/log/{type}', 'SettingFraudController@updateStatusLog');
    Route::post('update/device/login', 'SettingFraudController@updateStatusDeviceLogin');

    /*== Suspend ==*/
    Route::any('suspend-user', 'SettingFraudController@suspendUser');
    Route::any('suspend-user/detail/{phone}', 'SettingFraudController@detailLogFraudUser');
});
