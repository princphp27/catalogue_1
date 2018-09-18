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

Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/**
 *  ================  Client routes group here ==================================
 */
Route::group(['namespace' => 'Client', 'prefix' => 'client'],function(){
	
	Route::group(['middleware' => 'auth' ],function(){
		
		Route::get('/','DashboardController@index')->name('client.dashboard');
		
		// Client categories routes here
		Route::get('/categories','CategoryController@index')->name('client.categories');
		Route::get('/categories/create','CategoryController@create')->name('client.categories.create');
		Route::post('/categories/store','CategoryController@store')->name('client.categories.store');
		Route::get('/categories/edit/{id}','CategoryController@edit')->name('client.categories.edit');
		Route::put('/categories/update/{id}','CategoryController@update')->name('client.categories.update');
		Route::delete('/categories/delete/{id}','CategoryController@destroy')->name('client.categories.delete');
		Route::get('/categories/show/{id}','CategoryController@show')->name('client.categories.show');
		
		// Client sub-categories routes here
		Route::get('/sub-categories','SubCategoryController@index')->name('client.sub-categories');
		Route::get('/sub-categories/create','SubCategoryController@create')->name('client.sub-categories.create');
		Route::post('/sub-categories/store','SubCategoryController@store')->name('client.sub-categories.store');
		Route::get('/sub-categories/edit/{id}','SubCategoryController@edit')->name('client.sub-categories.edit');
		Route::put('/sub-categories/update/{id}','SubCategoryController@update')->name('client.sub-categories.update');
		Route::delete('/sub-categories/delete/{id}','SubCategoryController@destroy')->name('client.sub-categories.delete');
		Route::get('/sub-categories/show/{id}','SubCategoryController@show')->name('client.sub-categories.show');
		Route::get('/sub-categories/json/{id}','SubCategoryController@getSubCategoriesJSON');
		
		
		// Client products routes here
		Route::get('/products','ProductController@index')->name('client.products');
		Route::get('/products/create','ProductController@create')->name('client.products.create');
		Route::post('/products/store','ProductController@store')->name('client.products.store');
		Route::get('/products/edit/{id}','ProductController@edit')->name('client.products.edit');
		Route::put('/products/update/{id}','ProductController@update')->name('client.products.update');
		Route::delete('/products/delete/{id}','ProductController@destroy')->name('client.products.delete');
		Route::get('/products/show/{id}','ProductController@show')->name('client.products.show');
		Route::get('/products/json/{id}','ProductController@getCategoriesJSON');
		Route::get('/category/json/{id}','ProductController@getCategoriesJSON');
		// Client Enquiry routes here//

		 Route::get('/enquiry','EnquiryController@index')->name('client.enquiry');
		 Route::post('/enquiry/store','EnquiryController@store')->name('client.enquiry.store');
		 Route::get('/getdata','EnquiryController@getdata')->name('client.enquiry.getdata');
		// Client settings routes here
		Route::get('/settings/theme','SettingController@getTheme')->name('client.theme');
		Route::get('/settings/theme/edit','SettingController@editTheme')->name('client.theme.edit');
		Route::put('/products/theme/update','SettingController@updateTheme')->name('client.theme.update');

	});
});
/**
 *  ================  Admin routes group here ==================================
 */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'],function(){


	Route::get('/login','AuthController@getLogin')->name('admin.login');
	Route::post('/login','AuthController@postLogin');
	
	Route::get('/logout','AuthController@getLogout')->name('admin.logout');
	Route::post('/logout','AuthController@getLogout')->name('admin.logout');

	Route::group(['middleware' => 'auth:admin' ],function(){
	
		Route::get('/client/json/{id}','ClientController@getCategoriesJSON');
		
		Route::get('/category/json/{id}','ClientController@getSubCategoriesJSON');
		Route::get('/','DashboardController@index')->name('admin.dashboard');
		
		Route::get('/profile','ProfileController@index')->name('admin.profile');
		Route::get('/profile/edit','ProfileController@edit')->name('admin.profile.edit');
		Route::post('/profile/update','ProfileController@update')->name('admin.profile.update');
		Route::get('/profile/change-password','ProfileController@changePassword')->name('admin.profile.change-password');
		Route::post('/profile/update-password','ProfileController@updatePassword')->name('admin.profile.update-password');
		

		/*
		Route::get('/customer','CustomerController@index')->name('admin.customers');
		Route::get('/customer/edit/{id}','CustomerController@edit')->name('admin.customers.edit');
		Route::put('/customer/update/{id}','CustomerController@update')->name('admin.customers.update');
		Route::get('/customer/show/{id}','CustomerController@show')->name('admin.customers.show');
		
		*/

		// Admin clients routes here
		
		Route::get('/clients','ClientController@index')->name('admin.clients');
		Route::get('/clients/create','ClientController@create')->name('admin.clients.create');
		Route::post('/clients/store','ClientController@store')->name('admin.clients.store');
		Route::get('/clients/edit/{id}','ClientController@edit')->name('admin.clients.edit');
		Route::put('/clients/update/{id}','ClientController@update')->name('admin.clients.update');
		Route::get('/clients/delete/{id}','ClientController@destroy')->name('admin.clients.delete');
		Route::get('/clients/show/{id}','ClientController@show')->name('admin.clients.show');
		
		// Admin categories routes here
		Route::get('/categories','CategoryController@index')->name('admin.categories');
		Route::get('/categories/create','CategoryController@create')->name('admin.categories.create');
		Route::post('/categories/store','CategoryController@store')->name('admin.categories.store');
		Route::get('/categories/edit/{id}','CategoryController@edit')->name('admin.categories.edit');
		Route::put('/categories/update/{id}','CategoryController@update')->name('admin.categories.update');
		Route::delete('/categories/delete/{id}','CategoryController@destroy')->name('admin.categories.delete');
		Route::get('/categories/show/{id}','CategoryController@show')->name('admin.categories.show');
		Route::get('/categories/json/{id}','CategoryController@getCategoriesJSON')->name('admin.categories.json');
		// Admin sub-categories routes here
		Route::get('/sub-categories','SubCategoryController@index')->name('admin.sub-categories');
		Route::get('/sub-categories/create/{id}','SubCategoryController@create')->name('admin.sub-categories.create');
		Route::post('/sub-categories/store/{id}','SubCategoryController@store')->name('admin.sub-categories.store');
		Route::get('/sub-categories/edit/{id}','SubCategoryController@edit')->name('admin.sub-categories.edit');
		Route::put('/sub-categories/update/{id}','SubCategoryController@update')->name('admin.sub-categories.update');
		Route::delete('/sub-categories/delete/{id}','SubCategoryController@destroy')->name('admin.sub-categories.delete');
		Route::get('/sub-categories/show/{id}','SubCategoryController@show')->name('admin.sub-categories.show');
		Route::get('/category/json/{id}','SubCategoryController@getCategoriesJSON');
		 
		
		//Admin product route here
		Route::get('/products','ProductController@index')->name('admin.products');
		Route::get('/products/create','ProductController@create')->name('admin.products.create');
		Route::post('/products/store','ProductController@store')->name('admin.products.store');
		Route::get('/products/edit/{id}','ProductController@edit')->name('admin.products.edit');
		Route::put('/products/update/{id}','ProductController@update')->name('admin.products.update');
		Route::delete('/products/delete/{id}','ProductController@destroy')->name('admin.products.delete');
		Route::get('/products/show/{id}','ProductController@show')->name('admin.products.show');
		Route::get('/products/json/{id}','ProductController@getCategoriesJSON')->name('admin.products.json');
		Route::get('/category/json/{id}','ProductController@getSubCategoriesJSON');
		Route::get('/sub-categories/json/{id}','ProductController@getSubCategoriesJSON');
		

	});	

});
