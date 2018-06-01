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

// Route::get('/', function () {
//     return view('auth.login');
// });

Auth::routes();

Route::get('/', 'Auth\LoginController@index')->name('');

//dashboard
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('categories', 'CategoriesController');
Route::resource('products', 'ProductsController');
Route::resource('transactions', 'TransactionsController');
Route::resource('shop', 'ShopController');


//products
Route::post('/update_image', 'ProductsController@updateImage')->name('update_image');

Route::get('exportproduct', [
	'uses' => 'ProductsController@exportProduct',
	'as' => 'exportproduct'
]);

Route::post('importexcel', [
	'uses' => 'ProductsController@importExcelfile',
	'as' => 'importexcel'
]);

Route::post('processexcel', [
	'uses' => 'ProductsController@processExcelfile',
	'as' => 'processexcel'
]);


//////////////////////////////////////////////////////////////
//customers
Route::get('customers', [
	'uses' => 'CustomersController@getIndex',
	'as' => 'customers'
]);

////////////////////////////////////////////////////////////

//orders 
Route::get('orders', [
	'uses' => 'OrdersController@getIndex',
	'as' => 'orders'
]);

Route::get('/processorder/{id}', [
	'uses' => 'OrdersController@processOrder',
	'as' => 'processorder'
]);

Route::get('/deliverorder/{id}', [
	'uses' => 'OrdersController@deliverOrder',
	'as' => 'deliverorder'
]);

Route::get('/rejectorder/{id}', [
	'uses' => 'OrdersController@rejectOrder',
	'as' => 'rejectorder'
]);

Route::get('sendemail', [
	'uses' => 'OrdersController@sendEmail',
	'as' => 'sendemail'
]);

//////////////////////////////////////////////////////////////

//reports
Route::get('reports',[
	'uses' => 'ReportsController@getIndex',
	'as' => 'reports'
]);



///////////////////////////////////////////////////////////////
// shop
Route::get('/add-to-cart/{id}', [
	'uses' => 'ShopController@getAddToCart',
	'as' => 'product.addToCart'
]);

Route::get('/addByOne/{id}', [
	'uses' => 'ShopController@getAddByOne',
	'as' => 'product.addByOne'
]);

Route::get('/reduceByOne/{id}', [
	'uses' => 'ShopController@getReduceByOne',
	'as' => 'product.reduceByOne'
]);

Route::get('/remove/{id}', [
	'uses' => 'ShopController@getRemoveItem',
	'as' => 'product.revomeItem'
]);

Route::get('/shopping-cart', [
	'uses' => 'ShopController@getCart',
	'as' => 'product.shoppingCart'
]);

Route::get('/checkout', [
	'uses' => 'ShopController@getCheckout',
	'as' => 'checkout',
	'middleware' => 'auth'
]);

Route::post('/checkout', [
	'uses' => 'ShopController@saveOrder',
	'as' => 'checkout'
]);

Route::post('/cancelorder', [
	'uses' => 'ShopController@cancelOrder',
	'as' => 'cancelorder'
]);

Route::get('/vieworder/{id}', [
	'uses' => 'ShopController@viewOrderList',
	'as' => 'order.vieworder'
]);

Route::get('/category/{id}', [
	'uses' => 'ShopController@filterByCategory',
	'as' => 'shop.category'
]);


Route::group(['prefix' => 'user'], function() {

	Route::group(['middleware' => 'guest'], function() {

		Route::get('/customer_register', [
			'uses' => 'ShopController@customerRegister',
			'as' => 'user.customer_register',
		]);

		Route::post('/customer_signup', [
			'uses' => 'ShopController@customerSignup',
			'as' => 'user.customer_signup',
		]);

		Route::get('/customer_login', [
			'uses' => 'ShopController@customerLogin',
			'as' => 'user.customer_login',
		]);

		Route::post('/customer_signin', [
			'uses' => 'ShopController@customerSignin',
			'as' => 'user.customer_signin',
		]);

	});
	
	Route::group(['middleware' => 'auth'], function() {

		Route::get('/customer_logout', [
			'uses' => 'ShopController@customerLogout',
			'as' => 'user.customer_logout',
		]);

		Route::get('/customer_orders', [
			'uses' => 'ShopController@customerOrders',
			'as' => 'user.customer_orders',
		]);

	});

	

	

});

