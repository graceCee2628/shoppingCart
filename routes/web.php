<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/shop/{id}/view', 'HomeController@shop_view');
Route::post('/shop/{id}/add_to_cart', 'HomeController@cart');
Route::get('/shop/my_cart', 'HomeController@my_cart');
Route::post('/shop/{id}/delete_cart_item', 'HomeController@delete_cart_item');
Route::get('/shop/checkout', 'HomeController@checkout');






	Route::post('save-product', 'HomeController@save_product');
	Route::get('admin', 'HomeController@show');
	Route::get('admin/{id}','HomeController@view_data');
	Route::post('admin/{id}/','HomeController@update');    


