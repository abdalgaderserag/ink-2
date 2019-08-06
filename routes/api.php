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

Route::post('follow', 'Api\FollowController@store')->middleware('test');
Route::delete('follow/{user_id}', 'Api\FollowController@destroy')->middleware('test');


//});

Route::apiResource('ink', 'Api\InkController')->middleware('test');
Route::get('main','Api\MainPageController');
Route::get('profile/ink', 'UserController@profileInk');

Route::apiResource('comment', 'Api\CommentController')->middleware('test');

Route::get('notifications','Notification\NotificationController@notifications');
Route::post('notifications/mark-as-read/{uuid}','Notification\NotificationController@setNotificationAsRead');
Route::get('notifications/unread','Notification\NotificationController@getUnreadNotification');
Route::delete('notifications/delete-read','Notification\NotificationController@deleteReadNotification');
Route::put('notifications/mark-all-as-read','Notification\NotificationController@notifications');