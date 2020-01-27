<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web', 'validate_session', 'config_control:95'], 'prefix' => 'promo-campaign'], function () {
    Route::any('/', 'PromoCampaignController@index');
    Route::any('list', 'PromoCampaignController@index');
    Route::any('list/filter', 'PromoCampaignController@index');
    Route::get('step1', function(){ return redirect('promo-campaign');});
    Route::get('step2', function(){ return redirect('promo-campaign');});
    Route::any('create', 'PromoCampaignController@step1');
    Route::any('detail/{slug}', 'PromoCampaignController@detail');
    Route::any('detail-coupon/{slug}', 'PromoCampaignController@detail');
    Route::get('getTag', 'PromoCampaignController@getTag');
    Route::get('check', 'PromoCampaignController@checkCode');
    Route::get('step1/getTag', 'PromoCampaignController@getTag');
    Route::get('step1/check', 'PromoCampaignController@checkCode');
    Route::any('step2/getData', 'PromoCampaignController@getData');
    Route::post('delete', 'PromoCampaignController@delete');

    Route::any('step1/{slug}', 'PromoCampaignController@step1');
    Route::any('step2/{slug}', 'PromoCampaignController@step2');

});
