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

//add admin
Route::get('addadmin', [
	'uses' => 'HomeController@addAdmin',
	'as' => 'addadmin'
]);

Route::post('registeradmin', [
	'uses' => 'HomeController@registerAdmin',
	'as' => 'registeradmin'
]);	

//my profile
Route::get('myprofile', [
	'uses' => 'HomeController@myProfile',
	'as' => 'myprofile'
]);

Route::post('admineditprofile', [
	'uses' => 'HomeController@editMyProfile',
	'as' => 'admineditprofile'
]);

Route::post('adminchangepassword', [
	'uses' => 'HomeController@changePassword',
	'as' => 'adminchangepassword'
]);

//category

Route::get('/restorecategory/{id}', [
	'uses' => 'CategoriesController@restoreCategory',
	'as' => 'restorecategory'
]);

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

Route::get('/restore/{id}', [
	'uses' => 'ProductsController@restoreProduct',
	'as' => 'restore'
]);

Route::get('/addstock_view/{id}', [
	'uses' => 'ProductsController@viewAddStock',
	'as' => 'addstock_view'
]);

Route::post('addstock', [
	'uses' => 'ProductsController@addStockProduct',
	'as' => 'addstock'
]);

//////////////////////////////////////////////////////////////
//customers
Route::get('customers', [
	'uses' => 'CustomersController@getIndex',
	'as' => 'customers'
]);

Route::post('sendmessage', [
	'uses' => 'CustomersController@sendCustomerEmail',
	'as' => 'sendmessage'
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

Route::get('/notify/{pid}/{oid}', [
	'uses' => 'OrdersController@notifyOutOfStock',
	'as' => 'notify'
]);

//////////////////////////////////////////////////////////////

//reports
Route::get('reports',[
	'uses' => 'ReportsController@getIndex',
	'as' => 'reports'
]);

Route::post('showreports', [
	'uses' => 'ReportsController@generateReport',
	'as' => 'showreports'
]);

Route::get('/printreport/{datefrom}/{dateto}', [
	'uses' => 'ReportsController@printReport',
	'as' => 'printreport'
]);

Route::get('printreporttoday', [
	'uses' => 'ReportsController@printReportToday',
	'as' => 'printreporttoday'
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

Route::post('editprofile', [
	'uses' => 'ShopController@updateProfile',
	'as' => 'editprofile'
]);

Route::post('customerchangepassword', [
	'uses' => 'ShopController@changePassword',
	'as' => 'customerchangepassword'
]);

Route::get('indicatorverify', [
	'uses' => 'ShopController@indicatorVerify',
	'as' => 'indicatorverify'
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

		Route::get('/verifyaccount/{id}', [
			'uses' => 'ShopController@verifyAccount',
			'as' => 'user.verifyaccount'
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

		Route::get('/customer_profile', [
			'uses' => 'ShopController@customerProfile',
			'as' => 'user.customer_profile',
		]);

	});

});
