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

Route::get('/test',
    function (){
        return 'hi';
    }
);
Route::get('/', function () {
    return 'Bakery';
});
//Route::group(['middleware'=>'web'],function (){
<<<<<<< HEAD
Route::post('/signup','UserController@signup');

=======
   Route::post('/{lang}/signup',
       'UserController@signup($lang)');
   Route::get('/test',
>>>>>>> a71f1863da467cfb1de57e877b01d8c1f2578146

//});
