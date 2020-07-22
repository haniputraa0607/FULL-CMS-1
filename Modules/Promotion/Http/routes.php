<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'promotion', 'namespace' => 'Modules\Promotion\Http\Controllers'], function()
{
	Route::any('/', ['middleware' => 'feature_control:109', 'uses' => 'PromotionController@index']);
	Route::any('/page/{page}', ['middleware' => 'feature_control:109', 'uses' => 'PromotionController@create']);
	
	Route::get('create', ['middleware' => 'feature_control:111', 'uses' => 'PromotionController@create']);
    Route::post('create', ['middleware' => 'feature_control:111', 'uses' => 'PromotionController@store']);
	Route::get('step1/{id_promotion}', ['middleware' => 'feature_control:110,112', 'uses' => 'PromotionController@step1']);
    Route::post('step1/{id_promotion}', ['middleware' => 'feature_control:112', 'uses' => 'PromotionController@step1Post']);
	Route::get('step2/{id_promotion}', ['middleware' => 'feature_control:110,112', 'uses' => 'PromotionController@step2']);
	Route::post('step2/{id_promotion}', ['middleware' => 'feature_control:112', 'uses' => 'PromotionController@step2Post']);
	Route::get('step3/{id_promotion}', ['middleware' => 'feature_control:110,112', 'uses' => 'PromotionController@step3']);
	Route::post('step3/{id_promotion}', ['middleware' => 'feature_control:112', 'uses' => 'PromotionController@step3Post']);
	Route::get('sent/list/{id_promotion_content}/{page?}/{type?}', ['middleware' => 'feature_control:110', 'uses' => 'PromotionController@sentList']);
	Route::get('voucher/list/{id_promotion_content}/{page?}/{type?}', ['middleware' => 'feature_control:110', 'uses' => 'PromotionController@voucherList']);
	Route::get('voucher/trx/{id_promotion_content}/{page?}', ['middleware' => 'feature_control:110', 'uses' => 'PromotionController@voucherTrx']);
	Route::get('linkclicked/list/{id_promotion_content}/{page?}/{type?}', ['middleware' => 'feature_control:110', 'uses' => 'PromotionController@linkClickedList']);
	Route::post('delete', ['middleware' => 'feature_control:113', 'uses' => 'PromotionController@delete']);

	Route::get('recipient/{id_promotion}', ['middleware' => 'config_control:110', 'uses' => 'PromotionController@showRecipient']);
});