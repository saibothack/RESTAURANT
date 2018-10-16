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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');
Route::resource('restaurants', 'RestaurantController');
Route::resource('menus', 'MenuController');
Route::resource('optionals', 'OptionalController');

Route::resource('menus/{id}/images', 'MenuImagesController');

Route::get('restaurants/QR/{id}', 'RestaurantController@generateToQR');
Route::post('restaurants/QR/{id}', 'RestaurantController@printToQR');

Route::get('restaurants/QR/{id}', 'RestaurantController@generateToQR');
Route::post('restaurants/QR/{id}', 'RestaurantController@printToQR');

Route::get('restaurants/images/{id}', 'RestaurantController@getImages');
Route::post('restaurants/images/{id}', 'RestaurantController@setImages');

Route::get('restaurant/{restaurant}/{table}', 'ClientController@getLogin');
Route::post('restaurant/{restaurant}/{table}', 'ClientController@setLogin');

Route::get('restaurant/{restaurant}/{table}/client/{id}', 'MenuController@getMenuClient');
Route::post('restaurant/{restaurant}/{table}/client/{id}', 'MenuController@setMenuClient');

