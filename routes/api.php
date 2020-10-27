<?php

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

Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');
Route::post('/products', 'ProductController@index');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'API\AuthController@logout');
    Route::post('/addproduct', 'ProductController@store');
    Route::post('/dashboard/products', 'ProductController@index');
    Route::post('/delete', 'ProductController@destroy');
    Route::post('/order/get', 'OrderController@index');
    Route::post('/order/create', 'OrderController@store');
    Route::post('/order/complete', 'OrderController@update');
    Route::post('/users', 'API\AuthController@index');
    Route::post('/user/delete', 'API\AuthController@destroy');
    
});
