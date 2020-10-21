<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'campaign', 'namespace' => 'Modules\Campaign\Http\Controllers'], function()
{
	Route::any('/', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignList']);
	Route::any('/page/{page}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignList']);
	
    Route::any('email/outbox', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailOutbox']);
    Route::any('email/outbox/page/{page}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailOutbox']);
    Route::any('email/outbox/detail/{id}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailOutboxDetail']);
	
	Route::any('sms/outbox', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsOutbox']);
	Route::any('sms/outbox/page/{page}', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsOutbox']);
	Route::any('sms/outbox/detail/{id}', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsOutboxDetail']);
	
	Route::any('push/outbox', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushOutbox']);
	Route::any('push/outbox/page/{page}', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushOutbox']);
	Route::any('push/outbox/detail/{id}', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushOutboxDetail']);
	
    Route::any('whatsapp/outbox', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappList']);
    Route::any('whatsapp/outbox/page/{page}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappList']);
    Route::any('whatsapp/outbox/detail/{id}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappDetail']);
	
    Route::get('create', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@create']);
    Route::post('create', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@createPost']);
    Route::get('step1/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep1']);
    Route::post('step1/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep1Post']);
    
    Route::get('step2/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep2']);
    Route::post('step2/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep2Post']);
	
	Route::get('step3/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep3']);
	Route::post('step3/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep3Post']);

    Route::get('recipient/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@showRecipient']);
    Route::post('delete', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@destroy']);
});
