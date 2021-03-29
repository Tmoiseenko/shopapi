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


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', 'AuthController@logout');
    Route::get('/user', function(Request $request) {
        dd(\App\Product::with('category')->paginate());
    });
    Route::resource('categories', 'CategoryController');
    Route::resource('products', 'ProductController');
});
