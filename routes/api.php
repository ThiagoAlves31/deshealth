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
        Route::post('/','ProductController@CreateProduct')->name('products_create');
        Route::put('/{id}','ProductController@UpdateProduct')->name('products_update');
        Route::delete('/{id}','ProductController@DeleteProduct')->name('products_update');

        Route::get('/{id}','ProductController@searchId')->name('products_id');
        Route::get('/description/{text}','ProductController@searchDescription')->name('products_description');

    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
