<?php

Route::group(['middleware' => ['web', 'validate_session', 'config_control:25,26,or'], 'prefix' => 'deals', 'namespace' => 'Modules\Deals\Http\Controllers'], function () {
    Route::any('/', ['middleware' => 'feature_control:72', 'uses' => 'DealsController@deals']);
    Route::get('/list/active', ['uses' => 'DealsController@listActiveDeals']);
    Route::any('create', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@create']);
    Route::any('step1/{id}', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@step1']);
    Route::any('step2/{id}', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@step2']);
    Route::any('step3/{id}', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@step3']);
    Route::post('update-complete', ['middleware' => 'feature_control:75', 'uses' => 'DealsController@updateComplete']);
    // Route::any('detail/{id}/{promo}', ['middleware' => 'feature_control:73', 'uses' => 'DealsController@detail']);
    Route::any('detail/{id}', ['middleware' => 'feature_control:73', 'uses' => 'DealsController@detail']);
    Route::any('update', ['middleware' => ['feature_control:75'], 'uses' => 'DealsController@updateReq']);
    Route::any('delete', ['middleware' => 'feature_control:76', 'uses' => 'DealsController@deleteDeal']);
    Route::any('voucher/delete', 'DealsController@deleteVoucher');
    Route::post('export', ['middleware' => ['feature_control:250'], 'uses' => 'DealsController@exportDeals']);
    Route::any('import', ['middleware' => ['feature_control:249'], 'uses' => 'DealsController@importDeals']);

    /* TRANSACTION */
    Route::any('transaction', 'DealsController@transaction');
    Route::any('transaction/filter', 'DealsController@transactionFilter');

    /* MANUAL PAYMENT */

    Route::group(['prefix' => 'manualpayment'], function () {
        Route::any('/list/{type?}', 'DealsPaymentManualController@manualPaymentList');
        Route::any('/reset/{type?}', 'DealsPaymentManualController@resetFilter');
        Route::any('/confirm/{id}', ['middleware' => 'feature_control:65', 'uses' => 'DealsPaymentManualController@manualPaymentConfirm']);
    });
});

/* POINT */
Route::group(['middleware' => ['web', 'validate_session', 'config_control:26'], 'prefix' => 'deals-point', 'namespace' => 'Modules\Deals\Http\Controllers'], function () {
    Route::any('create', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@create']);
    Route::any('/', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@deals']);
    Route::any('detail/{id}/{promo}', ['middleware' => 'feature_control:73', 'uses' => 'DealsController@detail']);
});

/* HIDDEN */
Route::group(['middleware' => ['web', 'validate_session', 'config_control:26'], 'prefix' => 'inject-voucher', 'namespace' => 'Modules\Deals\Http\Controllers'], function () {
    Route::any('/', ['middleware' => 'feature_control:77', 'uses' => 'DealsController@deals']);
    Route::any('create', ['middleware' => 'feature_control:79', 'uses' => 'DealsController@create']);
    Route::any('step1/{id}', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@step1']);
    Route::any('step2/{id}', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@step2']);
    Route::any('step3/{id}', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@step3']);
    Route::post('update-complete', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@updateComplete']);
    Route::any('detail/{id}', ['middleware' => 'feature_control:78', 'uses' => 'DealsController@detail']);
    Route::any('update', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@updateReq']);
    Route::any('delete', ['middleware' => 'feature_control:81', 'uses' => 'DealsController@deleteDeal']);
    Route::any('voucher/delete', 'DealsController@deleteVoucher');
    Route::any('import', ['middleware' => ['feature_control:249'], 'uses' => 'DealsController@importDeals']);
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'deals', 'namespace' => 'Modules\Advert\Http\Controllers'], function () {
    /* ADVERT */
    Route::any('advert', 'AdvertController@index');
});

/* Deals Subscription */
// Route::group(['middleware' => ['web', 'validate_session', 'config_control:25'], 'prefix' => 'deals-subscription', 'namespace' => 'Modules\Deals\Http\Controllers'], function () {
//     Route::get('/', ['middleware' => 'feature_control:139', 'uses' => 'DealsController@subscriptionDeals']);
//     Route::any('create', ['middleware' => 'feature_control:141', 'uses' => 'DealsController@subscriptionCreate']);
//     Route::any('detail/{id_deals}', ['middleware' => 'feature_control:140', 'uses' => 'DealsController@subscriptionDetail']);
//     Route::any('update', ['middleware' => 'feature_control:142', 'uses' => 'DealsController@subscriptionUpdate']);
//     Route::get('delete/{id_deals}', ['middleware' => 'feature_control:143', 'uses' => 'DealsController@deleteSubscriptionDeal']);
// });

/* Webview */
// Route::group(['middleware' => ['web'], 'prefix' => 'webview', 'namespace' => 'Modules\Deals\Http\Controllers'], function () {
//     Route::get('deals/{id_deals}/{deals_type}', 'WebviewDealsController@dealsDetail');
//     Route::get('mydeals/{id_deals_user}', 'WebviewDealsController@dealsClaim');
// });

/* Welcome Voucher */
Route::group(['middleware' => ['web', 'validate_session', 'config_control:26'], 'prefix' => 'welcome-voucher', 'namespace' => 'Modules\Deals\Http\Controllers'], function () {
    Route::any('/', ['middleware' => 'feature_control:77', 'uses' => 'DealsController@deals']);
    Route::any('create', ['middleware' => 'feature_control:79', 'uses' => 'DealsController@create']);
    // Route::any('create', ['middleware' => 'feature_control:79', 'uses' => 'DealsController@welcomeVoucherCreate']);
    Route::any('step1/{id}', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@step1']);
    Route::any('step2/{id}', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@step2']);
    Route::any('step3/{id}', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@step3']);
    Route::post('update-complete', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@updateComplete']);
    Route::any('detail/{id}', ['middleware' => 'feature_control:78', 'uses' => 'DealsController@detail']);
    // Route::any('detail/{id}/{promo}', ['middleware' => 'feature_control:78', 'uses' => 'DealsController@detail']);
    Route::any('update', ['middleware' => 'feature_control:80', 'uses' => 'DealsController@updateReq']);
    Route::any('setting', 'DealsController@welcomeVoucherSetting');
    Route::any('update/status', 'DealsController@welcomeVoucherUpdateStatus');
    Route::any('import', ['middleware' => ['feature_control:249'], 'uses' => 'DealsController@importDeals']);
});

/* Promotion Deals */
Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'promotion', 'namespace' => 'Modules\Promotion\Http\Controllers'], function () {
	Route::group(['prefix' => 'deals'], function()
	{
		Route::get('/', 'PromotionController@listDeals');
	});
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'promotion', 'namespace' => 'Modules\Deals\Http\Controllers'], function () {
	Route::group(['prefix' => 'deals'], function()
	{
		Route::any('/create', 'DealsController@create');
		Route::any('step1/{id}', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@step1']);
	    Route::any('step2/{id}', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@step2']);
	    Route::any('step3/{id}', ['middleware' => 'feature_control:74', 'uses' => 'DealsController@step3']);
	    Route::post('update-complete', ['middleware' => 'feature_control:75', 'uses' => 'DealsController@updateComplete']);
	    // Route::any('detail/{id}/{promo}', ['middleware' => 'feature_control:73', 'uses' => 'DealsController@detail']);
	    Route::any('detail/{id}', ['middleware' => 'feature_control:73', 'uses' => 'DealsController@detail']);
	});
});