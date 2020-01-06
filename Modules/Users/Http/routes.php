<?php



Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'user', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
	Route::get('ajax/phone', 'UsersController@listPhoneUser');
	Route::get('ajax/email', 'UsersController@listEmailUser');
	Route::get('ajax/name', 'UsersController@listNameUser');
	Route::get('ajax/log/{id}/{log_type}', 'UsersController@showDetailLog');

	Route::any('/', ['middleware' => 'feature_control:1', 'uses' => 'UsersController@index']);

	Route::group(['middleware' => 'config_control:5', 'prefix' => 'adminoutlet'], function()
	{
		Route::any('/', ['middleware' => 'feature_control:9', 'uses' => 'UsersController@indexAdminOutlet']);
		Route::any('/{phone}/{id_outlet}', ['middleware' => 'feature_control:4', 'uses' => 'UsersController@updateAdminOutlet']);
		Route::any('/delete/{phone}/{id_outlet}', ['middleware' => 'feature_control:4', 'uses' => 'UsersController@deleteAdminOutlet']);
		Route::any('/create', ['middleware' => 'feature_control:4', 'uses' => 'UsersController@createAdminOutlet']);
	});

	Route::any('create', ['middleware' => 'feature_control:4', 'uses' => 'UsersController@create']);
	Route::any('export', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@getExport']);
	Route::any('activity', ['middleware' => 'feature_control:6', 'uses' => 'UsersController@activity']);
	Route::any('activity/export', ['middleware' => 'feature_control:6', 'uses' => 'UsersController@getExportActivities']);
    Route::any('search/reset', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@searchReset']);
    Route::get('delete/{phone}', ['middleware' => 'feature_control:5', 'uses' => 'UsersController@delete']);
	Route::get('delete/logApp/{id}', ['middleware' => 'feature_control:5', 'uses' => 'UsersController@deleteLogApp']);
	Route::get('delete/logBE/{id}', ['middleware' => 'feature_control:5', 'uses' => 'UsersController@deleteLogBE']);
    Route::any('detail/{phone}', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@show']);
    Route::any('detail/{phone}/favorite', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@favorite']);
    Route::any('detail/log/{phone}', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@showLog']);
    Route::any('log/{phone}', ['middleware' => 'feature_control:2', 'uses' => 'UsersController@showAllLog']);
    Route::any('detail/transaction/{phone}', 'UsersController@showTransaction');
    Route::any('detail/treatment/{phone}', 'UsersController@showTreatment');
    Route::any('autoresponse/{subject}', ['middleware' => 'feature_control:92', 'uses' =>'UsersController@autoResponse']);
    Route::any('/{page}', ['middleware' => 'feature_control:1', 'uses' => 'UsersController@index']);
	Route::any('activity/{page}', ['middleware' => 'feature_control:6', 'uses' => 'UsersController@activity']);
});

/* Webview */
Route::group(['prefix' => 'webview/complete-profile', 'namespace' => 'Modules\Users\Http\Controllers'], function()
{
    Route::any('/', 'WebviewUserController@completeProfile');
    Route::post('/submit', 'WebviewUserController@completeProfileSubmit');
    Route::get('/success', 'WebviewUserController@completeProfileSuccess');
});