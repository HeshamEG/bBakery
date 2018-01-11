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
//Route::get('/test',
//    function (){
//        return 'hi';
//    });
Route::post('/editaccount/{lang}','UserController@editaccount');
Route::post('/signup/{lang}','UserController@signup');
Route::post('/login/{lang}','UserController@login');
Route::post('/tweeterAuth','UserController@tweeterAuth');
Route::post('/facebookAuth','UserController@facebookAuth');



///////////////////////////////////////////////////////////////////
Route::get('/getAllCategories/{lang}','CategoryController@getAllCatecories');
Route::get('/getActiveCategories','categoriesController@getActiveCatecories');
Route::post('/makeCategoryActiveDeactivate','categoriesController@makeCategoryActiveDeactivate');
Route::post('/categoryDelete','categoriesController@categoryDelete');
Route::post('/addCategory/{lang}','categoriesController@addCategory');
////////////////////////////////////
Route::post('/addItem','ItemsController@addItem');
Route::get('/getItems/{user_id}/{lang}','ItemsController@getProducts');
//->middleware('apilang');
Route::get('/getCategoryItems/{lang}/{user_id}/{category_id}','ItemsController@getCategoryProducts');
/////////////////////////////////////
Route::put('/addTofavourite','FavoritesController@addToFavorites');
Route::post('/getUserfavourite/{lang}','FavoritesController@getUserfavourite');
Route::post('/deleteItemFromFavourites','FavoritesController@deleteFavorites');
////////////////////////////////////////////////////////
Route::post('/addToCart','CartController@addToCart');
Route::post('/getMyCart/{lang}','CartController@getMyCart');
Route::post('/deleteItemFromCart','CartController@deleteItemFromCart');
Route::put('/addOrderLocation','UserorderlocationsController@addOrderLocation');
Route::post('/getMyLocations','UserorderlocationsController@getMyLocations');
Route::post('/deleteLocation','UserorderlocationsController@deleteLocation');




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
