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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('categories', 'CategoriesController');
Route::resource('products', 'ProductsController');
Route::resource('transactions', 'TransactionsController');
Route::resource('shop', 'ShopController');


//products
Route::post('/update_image', 'ProductsController@updateImage')->name('update_image');

//shop
Route::get('/customer_register','ShopController@customerRegister')->name('customer_register');
Route::get('/customer_login','ShopController@customerLogin')->name('customer_login');
Route::get('/customer_logout','ShopController@customerLogout')->name('customer_logout');
Route::post('/customer_signup', 'ShopController@customerSignup')->name('customer_signup');
Route::post('/customer_signin', 'ShopController@customerSignin')->name('customer_signin');

// Route::get('/customer_register', [
// 		'uses' => 'ShopController@customerRegister',
// 		'as' => 'user.customer_register',
// 		'middleware' => 'auth'
// 	]);

// Route::get('/customer_login', [
// 		'uses' => 'ShopController@ccustomerLogin',
// 		'as' => 'user.customer_login',
// 	]);
