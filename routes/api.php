<?php

use Illuminate\Http\Request;

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

//Rotas dos produtos
Route::namespace('Api')->name('api.')->group(function(){
    Route::prefix('products')->group(function(){
        
        Route::get('/','ProductController@index')->name('products_index');
        Route::get('/{id}','ProductController@store')->name('products_id');

    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
