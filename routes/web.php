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


//Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/edit/profile', 'UserController@edit')->name('profile.edit');
    Route::put('/edit/profile', 'UserController@update')->name('profile.edit');
    Route::put('/delete/account', 'UserController@destory')->name('profile.delete');
    Route::post('/logout', 'UserController@logout')->name('logout');
    Route::get('/profile', 'UserController@index')->name('user.profile');
    Route::get('/edit/profile', 'UserController@edit')->name('edit.profile');
    Route::post('/edit/profile', 'UserController@update')->name('edit.profile');
    Route::get('/profile/{slug}', 'UserController@show')->name('profile');
});


//Route::middleware('guest')->group(function () {
Route::get('/log', 'UserController@create')->middleware('guest')->name('log');
//    Route::post('/register', 'UserController@register')->name('register');
//    Route::post('/login', 'UserController@login')->name('login');
Auth::routes();
//});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 3,
        'redirect_uri' => 'http://127.0.0.1:9000/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://127.0.0.1:8000/oauth/authorize?' . $query);
});


Route::get('/callback', function (\Illuminate\Http\Request $request) {
//    return redirect('?code='.$request->code);
    $http = new GuzzleHttp\Client();
    $response = $http->post('http://127.0.0.1:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 3,
            'client_secret' => 'CtnTBrtM8388T0TpRhFaAAYEtERYuxsTmIdvlZPl',
            'redirect_uri' => 'http://127.0.0.1:9000/callback',
            'code' => $request->code,
        ],
    ]);

//    return json_decode((string)$response->getBody(), true);
    return view('home')->with('access', json_decode((string)$response->getBody(), true));
});
