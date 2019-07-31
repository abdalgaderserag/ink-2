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
    return redirect('/home');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::group(function () {
Route::get('/profile', 'UserController@index')->name('profile');
Route::get('/register', 'UserController@create')->name('register');
Route::post('/register', 'UserController@store')->name('register');
Route::get('/profile/{slug}', 'UserController@show')->name('profile');
Route::get('/edit/profile', 'UserController@edit')->name('profile.edit');
Route::put('/edit/profile', 'UserController@update')->name('profile.edit');
Route::put('/delete/account', 'UserController@destory')->name('profile.delete');
//});