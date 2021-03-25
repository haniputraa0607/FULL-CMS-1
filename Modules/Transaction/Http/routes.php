<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function()
{
    Route::get('/setting/rule', 'TransactionController@ruleTransaction');
    Route::post('/setting/rule/update', 'TransactionController@ruleTransactionUpdate');
    Route::get('/internalcourier', 'TransactionController@internalCourier');

    Route::post('/manual-payment-save', ['middleware' => 'config_control:17', 'uses' => 'TransactionController@manualPaymentSave']);
    Route::post('/manual-payment-update/{id}', ['middleware' => 'config_control:17', 'uses' => 'TransactionController@manualPaymentUpdate']);

    Route::get('/point', 'TransactionController@pointUser');
    Route::get('/balance', 'TransactionController@balanceUser');
    Route::group(['prefix' => 'manualpayment', 'middleware' => 'config_control:17'], function()
    {
		Route::any('/banks', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksList']);
		Route::any('/banks/create', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksCreate']);
		Route::get('/banks/delete/{id}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@banksDelete']);
        Route::any('/banks/method/create', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@bankMethodsCreate']);
        Route::any('/banks/method', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksMethodList']);
		Route::get('/banks/method/delete/{id}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@bankMethodsDelete']);

        Route::get('/', ['middleware' => 'feature_control:64', 'uses' => 'TransactionController@manualPaymentList']);
        Route::any('/list/{type?}', 'TransactionController@manualPaymentUnpay');
        Route::any('/reset/{type?}', 'TransactionController@manualPaymentUnpay');
        Route::get('/create', ['middleware' => 'feature_control:66', 'uses' => 'TransactionController@manualPaymentCreate']);
        Route::get('/edit/{id}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentEdit']);
        Route::get('/detail/{id}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentDetail']);
        Route::get('/delete/{id}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@manualPaymentDelete']);
        Route::get('/getData/{id}', 'TransactionController@manualPaymentGetData');
        Route::post('/method/save', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@manualPaymentMethod']);
        Route::post('/method/delete', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@manualPaymentMethodDelete']);

        Route::any('/confirm/{id}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentConfirm']);
    });

    Route::get('/admin/{receipt}/{phone}', 'TransactionController@adminOutlet');
    Route::get('/admin/{type}/{status}/{receipt}/{id}', 'TransactionController@adminOutletConfirm');

    /*[POS] Transaction online failed*/
    Route::any('online-pos', 'TransactionController@transactionPOS');
    Route::get('online-pos/failed', 'TransactionController@transactionFailed');
    Route::any('online-pos/resend', 'TransactionController@resendTransactionFailed');
    Route::any('online-pos/autoresponse', 'TransactionController@autoresponseTransactionFailed');

    /*[POS] Cancel Transaction online failed*/
    Route::any('cancel-online-pos', 'TransactionController@cancelTransactionPOS');
    Route::get('cancel-online-pos/failed', 'TransactionController@cancelTransactionFailed');
    Route::any('cancel-online-pos/resend', 'TransactionController@resendCancelTransactionFailed');
    Route::any('cancel-online-pos/autoresponse', 'TransactionController@autoresponseCancelTransactionFailed');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function()
{
    Route::get('/setting/cashback', 'TransactionSettingController@list');
    Route::post('/setting/cashback/update', 'TransactionSettingController@update');
    Route::any('/setting/free-delivery', 'TransactionController@freeDelivery');
    Route::any('/setting/go-send-package-detail', 'TransactionController@goSendPackageDetail');
    Route::any('/setting/timer-payment-gateway', 'TransactionController@timerPaymentGateway');
    Route::get('/setting/available-payment', 'TransactionController@availablePayment');
    Route::post('/setting/available-payment', 'TransactionController@availablePaymentUpdate');
    Route::get('/setting/available-shipment', 'TransactionController@availableShipment');
    Route::post('/setting/available-shipment', 'TransactionController@availableShipmentUpdate');
});

Route::group(['prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function()
{
    Route::any('/web/view/detail', 'WebviewController@detail');
    Route::any('/web/view/detail/check', 'WebviewController@check');
    Route::any('/web/view/detail/point', 'WebviewController@detailPoint');
    Route::any('/web/view/detail/balance', 'WebviewController@detailBalance');
    Route::any('/web/view/trx', 'WebviewController@success');
    Route::any('/web/view/outletapp', 'WebviewController@receiptOutletapp');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function()
{
    Route::any('/create/fake', 'TransactionController@fakeTransaction');
    Route::get('/', ['middleware' => 'feature_control:69', 'uses' => 'TransactionController@transactionList']);
    Route::get('/detail/{id}/{key}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionDetail']);
    Route::get('/delete/{id}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionDelete']);

    Route::any('/{key}/{slug}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transaction']);
    Route::any('/{key}/{slug}/filter', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionFilter']);

    Route::any('/point/filter/{date}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@pointUserFilter']);
    Route::any('/balance/filter/{date}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@balanceUserFilter']);
    // Route::any('/{key}/{slug}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transaction']);
});
