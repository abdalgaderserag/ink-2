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

Route::get('/', 'HomeController@index');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/edit/profile', 'UserController@edit')->name('profile.edit');
    Route::put('/edit/profile', 'UserController@update')->name('profile.edit');
    Route::put('/delete/account', 'UserController@destory')->name('profile.delete');
    Route::post('/logout', 'UserController@logout')->name('logout');
    Route::get('/profile', 'UserController@index')->name('user.profile');
    Route::get('/edit/profile', 'UserController@edit')->name('edit.profile');
    Route::post('/edit/profile', 'UserController@update')->name('edit.profile');
});

Route::get('/profile/{slug}', 'UserController@show')->name('profile');


Route::get('/log', 'UserController@create')->name('log');
Route::post('/register', 'UserController@register')->name('register');
Route::post('/login', 'UserController@login')->name('login');


Auth::routes();