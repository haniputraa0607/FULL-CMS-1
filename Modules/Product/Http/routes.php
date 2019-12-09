<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product', 'namespace' => 'Modules\Product\Http\Controllers'], function()
{
	/**
	 * product
	 */
	Route::get('/', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@listProduct']);
	Route::any('/visible/{key?}', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@visibility']);
	Route::any('/hidden/{key?}', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@visibility']);
	Route::post('/id_visibility', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@addIdVisibility']);
	Route::post('update/visible', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@updateVisibilityProduct']);
	Route::get('import', ['middleware' => ['feature_control:56,57', 'config_control:10,11,or'], 'uses' => 'ProductController@importProduct']);
	Route::post('import/save', ['middleware' => ['feature_control:56', 'config_control:10'], 'uses' => 'ProductController@importProductSave']);
	Route::get('ajax', ['middleware' => 'feature_control:48', 'uses' => 'ProductController@listProductAjax']);
	Route::any('create', ['middleware' => 'feature_control:50', 'uses' => 'ProductController@create']);
	Route::any('update', ['middleware' => 'feature_control:51', 'uses' => 'ProductController@update']);
	Route::post('update/allow_sync', ['middleware' => 'feature_control:51', 'uses' => 'ProductController@updateAllowSync']);
	Route::post('update/visibility/global', ['middleware' => 'feature_control:51', 'uses' => 'ProductController@updateVisibility']);
	Route::any('delete', ['middleware' => 'feature_control:52', 'uses' => 'ProductController@delete']);
	Route::any('detail/{product_code}', ['middleware' => 'feature_control:49', 'uses' => 'ProductController@detail']);
	Route::any('example', ['middleware' => ['feature_control:57', 'config_control:11'], 'uses' => 'ProductController@example']);
	Route::any('price/{key?}', ['middleware' => ['feature_control:62', 'config_control:11'], 'uses' => 'ProductController@price']);
	Route::any('category/assign', ['middleware' => ['feature_control:44', 'config_control:11'], 'uses' => 'ProductController@categoryAssign']);

	Route::get('position/assign', ['middleware' => ['feature_control:44'], 'uses' => 'ProductController@positionAssign']);
	// ajax for ordering position
	Route::post('position/assign', ['middleware' => ['feature_control:44'], 'uses' => 'ProductController@positionProductAssign']);

	/**
	 * photo
	 */
	Route::group(['prefix' => 'photo'], function() {
    	Route::any('delete', ['middleware' => 'feature_control:55', 'uses' => 'ProductController@deletePhoto']);
    	Route::any('default', ['middleware' => 'feature_control:55', 'uses' => 'ProductController@photoDefault']);
	});

	/**
	 * category
	 */
	Route::group(['prefix' => 'category'], function() {
    	Route::get('/', ['middleware' => 'feature_control:43', 'uses' => 'CategoryController@categoryList']);
    	Route::any('edit/{id}', ['middleware' => 'feature_control:44', 'uses' => 'CategoryController@update']);
    	Route::any('create', ['middleware' => 'feature_control:45', 'uses' => 'CategoryController@create']);
    	Route::post('delete', ['middleware' => 'feature_control:47', 'uses' => 'CategoryController@delete']);
		/* position/ order */
		Route::post('position/assign', ['middleware' => ['feature_control:44'], 'uses' => 'CategoryController@positionCategoryAssign']);
	});

	/**
	 * modifier
	 */
	Route::group(['prefix' => 'modifier'], function() {
		Route::get('price/{id_outlet?}', ['middleware' => 'feature_control:190', 'uses' => 'ModifierController@listPrice']);
		Route::post('price/{id_outlet}', ['middleware' => 'feature_control:191', 'uses' => 'ModifierController@updatePrice']);

		Route::get('/', ['middleware' => 'feature_control:185', 'uses' => 'ModifierController@index']);
		Route::get('/create', ['middleware' => 'feature_control:186', 'uses' => 'ModifierController@create']);
		Route::post('/', ['middleware' => 'feature_control:186', 'uses' => 'ModifierController@store']);
		Route::get('/{id}', ['middleware' => 'feature_control:187', 'uses' => 'ModifierController@show']);
		Route::put('/{id}', ['middleware' => 'feature_control:188', 'uses' => 'ModifierController@update']);
		Route::delete('/{id}', ['middleware' => 'feature_control:189', 'uses' => 'ModifierController@delete']);
	});

	/**
	 * discount
	 */
	Route::group(['prefix' => 'discount'], function() {
    	Route::any('delete', 'ProductController@deleteDiscount');
	});

	/**
	 * tag
	 */
	Route::group(['prefix' => 'tag'], function() {
    	Route::get('/', ['middleware' => 'feature_control:43', 'uses' => 'TagController@list']);
    	Route::post('create', ['middleware' => 'feature_control:45', 'uses' => 'TagController@create']);
    	Route::post('update', ['middleware' => 'feature_control:44', 'uses' => 'TagController@update']);
    	Route::post('delete', ['middleware' => 'feature_control:47', 'uses' => 'TagController@delete']);
    	Route::get('detail/{id}', ['middleware' => 'feature_control:47', 'uses' => 'TagController@listProductTag']);
    	Route::post('delete/product-tag', ['middleware' => 'feature_control:47', 'uses' => 'TagController@deleteProductTag']);
    	Route::post('create/product-tag', ['middleware' => 'feature_control:47', 'uses' => 'TagController@createTagProduct']);
	});

});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product', 'namespace' => 'Modules\Advert\Http\Controllers'], function()
{
    /* ADVERT */
    Route::any('advert', 'AdvertController@index');
});
