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

Route::post('/auth/register', 'AuthController@register');
Route::post('/auth/login', 'AuthController@login');
Route::get('/product-by-slug/{slug}', 'ProductController@getBySlug');
Route::resource('/features', 'FeaturesController');
Route::post('/add-to-cart', 'CartController@addToCart')->name('addToCart');
Route::get('/get-cart', 'CartController@getCartItems')->name('getCart');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', 'AuthController@logout');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/products', 'ProductController');

});
