<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'setting', 'namespace' => 'Modules\Setting\Http\Controllers'], function()
{
	Route::post('app_logo', 'SettingController@appLogoSave');
    Route::post('app_sidebar', 'SettingController@appSidebarSave');
    Route::post('app_navbar', 'SettingController@appNavbarSave');
    Route::post('user_inbox', 'SettingController@userInboxSave');
    Route::get('faq', 'SettingController@faqList');
    Route::get('faq/create', 'SettingController@faqCreate');
    Route::post('faq/save', 'SettingController@faqStore');
    Route::get('faq/edit/{id}', 'SettingController@faqEdit');
    Route::post('faq/update/{id}', 'SettingController@faqUpdate');
    Route::any('faq/delete/{id}', 'SettingController@faqDelete');
    Route::get('faq/sort', 'SettingController@faqSort');
    Route::post('faq/sort/update', 'SettingController@faqSortUpdate');
    Route::post('update/{id}', 'SettingController@settingUpdate');

    
    Route::get('intro/{key}', 'TutorialController@introList');
    Route::post('intro/save', 'TutorialController@introStore');

    Route::get('level', 'SettingController@levelList');
    Route::get('level/create', 'SettingController@levelCreate');
    Route::post('level/save', 'SettingController@levelStore');
    Route::get('level/edit/{id}', 'SettingController@levelEdit');
    Route::post('level/update/{id}', 'SettingController@levelUpdate');
    Route::any('level/delete/{id}', 'SettingController@levelDelete');

    Route::any('whatsapp', ['middleware' => 'config_control:74,75', 'uses' => 'SettingController@whatsApp']);
	
    /* complete profile */
    Route::any('complete-profile', ['middleware' => 'feature_control:148', 'uses' => 'SettingController@completeProfile']);

    /* confirmation messages */
    Route::any('confirmation-messages','SettingController@confirmationMessages');

    /* confirmation messages */
    Route::any('otp-messages','SettingController@otpMessages');

    /*Text menu*/
    Route::any('text_menu', 'SettingController@textMenu');
    Route::post('text_menu/update/{category}', 'SettingController@updateTextMenu');

    /*Setting Phone*/
    Route::get('phone', ['middleware' => 'feature_control:211', 'uses' => 'SettingController@phoneNumberSetting']);
    Route::post('phone/update', ['middleware' => 'feature_control:211', 'uses' =>'SettingController@updatePhoneNumberSetting']);

    /*maintenance mode*/
    Route::any('maintenance-mode', 'SettingController@maintenanceMode');

    /*Setting Expired time OTP and Email*/
    Route::any('otp-email-rule', 'SettingController@otpEmailRule');

    Route::any('home', 'SettingController@homeSetting');
	Route::any('date', 'SettingController@dateSetting');
    Route::get('{key}', 'SettingController@settingList');
	
	Route::any('background/create', ['middleware' => 'config_control:30,32', 'uses' => 'SettingController@createBackground']);
    Route::any('background/delete', ['middleware' => 'config_control:30,32', 'uses' => 'SettingController@deleteBackground']);
    Route::any('greeting/create', ['middleware' => 'config_control:30,31', 'uses' => 'SettingController@createGreeting']);
    Route::any('greeting/update/{id}', ['middleware' => 'config_control:30,31', 'uses' => 'SettingController@updateGreetings']);
    Route::post('greeting/delete', ['middleware' => 'config_control:30,31', 'uses' => 'SettingController@deleteGreetings']);

    Route::post('default_home', 'SettingController@defaultHomeSave');
    
    Route::any('home/user', 'SettingController@dashboardSetting');
    Route::post('dashboard/delete', 'SettingController@deleteDashboard');
    Route::post('dashboard/ajax', 'SettingController@updateDashboardAjax');
    Route::post('dashboard/default-date', 'SettingController@updateDateRange');
    Route::post('dashboard/visibility-section', 'SettingController@visibilityDashboardSection');
    Route::post('dashboard/order-section', 'SettingController@orderDashboardSection');
    Route::post('dashboard/order-card', 'SettingController@orderDashboardCard');

    /* banner */
    Route::post('banner/create', ['middleware' => 'feature_control:145', 'uses' => 'SettingController@createBanner']);
    Route::post('banner/update', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@updateBanner']);
    Route::post('banner/reorder', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@reorderBanner']);
    Route::get('banner/delete/{id_banner}', ['middleware' => 'feature_control:147', 'uses' => 'SettingController@deleteBanner']);

    /* featured_deal */
    Route::post('featured_deal/create', ['middleware' => 'feature_control:145', 'uses' => 'SettingController@createFeaturedDeal']);
    Route::post('featured_deal/update', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@updateFeaturedDeal']);
    Route::post('featured_deal/reorder', ['middleware' => 'feature_control:146', 'uses' => 'SettingController@reorderFeaturedDeal']);
    Route::get('featured_deal/delete/{id_featured_deal}', ['middleware' => 'feature_control:147', 'uses' => 'SettingController@deleteFeaturedDeal']);

    // point reset
    Route::post('reset/{type}/update', 'SettingController@updatePointReset');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'crm', 'namespace' => 'Modules\Setting\Http\Controllers'], function()
{
    Route::any('setting_email', 'SettingController@settingEmail');
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'version', 'namespace' => 'Modules\Setting\Http\Controllers'], function()
{
    Route::any('/', 'VersionController@index');
});

Route::group(['prefix' => 'setting', 'namespace' => 'Modules\Setting\Http\Controllers'], function()
{
    Route::any('webview/{key}', 'SettingController@aboutWebview');
    Route::any('faq/webview', 'SettingController@faqWebview');
});

/* Promo Setting */
Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'promo-setting', 'namespace' => 'Modules\Setting\Http\Controllers'], function () {
    Route::any('warning-image', ['middleware' => 'feature_control:234', 'uses' => 'PromoSettingController@warningImage']);
    Route::any('cashback', ['middleware' => 'feature_control:236', 'uses' => 'PromoSettingController@promoCashback']);
});
