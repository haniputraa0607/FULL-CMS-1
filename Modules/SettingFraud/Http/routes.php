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
    Route::any('report/device', 'SettingFraudController@fraudReportDevice');//this route for fraud device
    Route::any('report/transaction-point', 'SettingFraudController@fraudReportTrxPoint');//this route for fraud transaction poin
    Route::any('report/promo-code', 'SettingFraudController@fraudReportPromoCode');//this route for fraud validate promo code
    Route::any('report/referral-user', 'SettingFraudController@fraudReportReferralUser');
    Route::any('report/referral', 'SettingFraudController@fraudReportReferral');
    Route::any('report/{type}', 'SettingFraudController@fraudReportTrx');//this route for fraud trx day, trx week, and trx in between
    Route::get('report/detail/device/{device_id}', 'SettingFraudController@fraudReportDeviceDetail');
    Route::get('report/detail/transaction-day/{id}', 'SettingFraudController@fraudReportTransactionDayDetail');
    Route::get('report/detail/transaction-week/{id}', 'SettingFraudController@fraudReportTransactionWeekDetail');
    Route::get('report/detail/transaction-between/{id_user}/{date}', 'SettingFraudController@fraudReportTransactionBetweenDetail');
    Route::get('report/detail/promo-code/{id}', 'SettingFraudController@fraudReportPromoCodeDetail');
    Route::post('update/suspend/{type}/{phone}', 'SettingFraudController@updateSuspend');
    Route::post('update/log/{type}', 'SettingFraudController@updateStatusLog');
    Route::post('update/device/login', 'SettingFraudController@updateStatusDeviceLogin');

    /*== Suspend ==*/
    Route::any('suspend-user', 'SettingFraudController@logFraudUser');
    Route::any('suspend-user/detail/{phone}', 'SettingFraudController@detailLogFraudUser');
});
