<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'autocrm', 'namespace' => 'Modules\Autocrm\Http\Controllers'], function()
{
    Route::get('/', ['middleware' => ['config_control:55', 'feature_control:119'], 'uses' => 'AutocrmController@list']);
    Route::any('create', ['middleware' => ['config_control:55', 'feature_control:121'], 'uses' => 'AutocrmController@create']);
    Route::any('cron/delete', ['middleware' => ['config_control:55', 'feature_control:113'], 'uses' => 'AutocrmController@deleteAutocrmCron']);
    Route::get('edit/{id_autocrm}', ['middleware' => ['config_control:55', 'feature_control:120,122'], 'uses' => 'AutocrmController@detail']);
    Route::post('edit/{id_autocrm}', ['middleware' => ['config_control:55', 'feature_control:122'], 'uses' => 'AutocrmController@detail']);
    Route::get('step-2', 'AutocrmController@step2');
    Route::post('email', 'AutocrmController@email');
    Route::post('sms', 'AutocrmController@sms');
    Route::post('push', 'AutocrmController@push');
    Route::post('inbox', 'AutocrmController@inbox');
    Route::post('forward', 'AutocrmController@forward');
    Route::get('{media}/turnon/{id}', 'AutocrmController@mediaOn');
});

Route::group(['middleware' => ['web', 'validate_session'],'namespace' => 'Modules\Autocrm\Http\Controllers'], function()
{
  Route::any('autoresponse/{type}/{subject}', 'AutocrmController@autoResponse');
});