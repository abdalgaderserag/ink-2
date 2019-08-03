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


//Route::middleware('auth:api')->group(function () {

    Route::post('like', 'Api\LikeController')->middleware('test');
    Route::post('upload', 'Api\UploaderController')->middleware('test');

//});

Route::apiResource('ink', 'Api\InkController')->middleware('test');
Route::apiResource('comment', 'Api\CommentController')->middleware('test');