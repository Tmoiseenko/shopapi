<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', 'AuthController@register')->name('register');
Route::post('/auth/login', 'AuthController@login')->name('login');
Route::get('/product-by-slug/{slug}', 'ProductController@getBySlug')->name('productBySlug');
Route::resource('/features', 'FeaturesController');
Route::post('/add-to-cart', 'CartController@add')->name('addToCart');
Route::get('/get-cart', 'CartController@get')->name('getCart');
Route::post('/update-cart', 'CartController@update')->name('updateCart');
Route::delete('/remove-cart', 'CartController@remove')->name('removeCart');
Route::get('/clear-cart', 'CartController@clear')->name('clearCart');
Route::post('/create-value', 'FeatureValueController@create');
Route::post('/delete-value/{value}', 'FeatureValueController@delete');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', 'AuthController@logout');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/products', 'ProductController');
    Route::resource('/orders', 'OrderController');
    Route::get('/user-orders', 'OrderController@userOrders');
});
