<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'report', 'namespace' => 'Modules\Report\Http\Controllers'], function()
{
    // Route::any('/global', ['middleware' => 'feature_control:114', 'uses' => 'ReportController@reportGlobal']);
    // Route::any('/product', ['middleware' => 'feature_control:116', 'uses' => 'ReportController@reportProduct']);
    // Route::any('/product/detail', ['middleware' => 'feature_control:116', 'uses' => 'ReportController@reportProductDetail']);
    // Route::any('/customer/summary', ['middleware' => 'feature_control:115', 'uses' => 'ReportController@customerSummary']);
    // Route::any('/customer/detail/{id}', ['middleware' => 'feature_control:115', 'uses' => 'ReportController@customerDetail']);

    Route::any('/global', [ 'uses' => 'ReportController@reportGlobal']);
    Route::any('/product', [ 'uses' => 'ReportController@reportProduct']);
    Route::any('/product/detail', [ 'uses' => 'ReportController@reportProductDetail']);
    
    
    Route::any('/global', ['middleware' => 'feature_control:125', 'uses' => 'ReportDuaController@reportGlobal']);
    Route::any('/product', ['middleware' => 'feature_control:127', 'uses' => 'ReportDuaController@reportProductAll']);
    Route::any('/product/detail/{id}/{id_outlet}/{start}/{end}', ['middleware' => 'feature_control:127', 'uses' => 'ReportDuaController@reportProductDetail']);
    
    
    Route::any('/customer/summary', ['middleware' => 'feature_control:126','uses' => 'ReportController@customerSummary']);
    Route::any('/customer/detail/{id}/{type}', ['middleware' => 'feature_control:126', 'uses' => 'ReportController@customerDetail']);
    
    Route::post('/outlet/detail/form', ['middleware' => 'feature_control:128', 'uses' => 'ReportDuaController@formOutletDetail']);
    Route::any('/outlet', [ 'middleware' => 'feature_control:128', 'uses' => 'ReportDuaController@reportOutletAll']);
    Route::any('/outlet/detail/{id}/{start}/{end}', ['middleware' => 'feature_control:128', 'uses' => 'ReportDuaController@reportOutletDetail']);
    Route::any('/outlet/detail/trx/{id}/{start}/{end}', ['middleware' => 'feature_control:128', 'uses' => 'ReportDuaController@reportOutletDetailTrx']);

    // MAGIC REPORT
    Route::any('/magic', ['middleware' => 'feature_control:84', 'uses' => 'MagicReportController@magicReport']);
    Route::get('/other/recommendation/{exclude_rec}', ['middleware' => 'feature_control:84', 'uses' => 'MagicReportController@otherRecommedantion']);
    Route::any('/tag/detail/{id}/{start}/{end}/{id_outlet}', ['middleware' => 'feature_control:84', 'uses' => 'MagicReportController@reportTagDetail']);
    Route::post('newtop', ['middleware' => 'feature_control:84', 'uses' => 'MagicReportController@newTop']);
    
    // SINGLE REPORT
    Route::any('/', [ 'uses' => 'SingleReportController@index']);
    Route::post('/ajax', [ 'uses' => 'SingleReportController@ajaxSingleReport']);

    // COMPARE REPORT
    Route::any('compare/', [ 'uses' => 'CompareReportController@index']);
    Route::post('compare/ajax', [ 'uses' => 'CompareReportController@ajaxCompareReport']);

    // SMS REPORT
    Route::any('sms', [ 'uses' => 'SmsReportController@index']);
});
