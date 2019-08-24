<?php


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


Route::middleware('auth:api')->group(function () {

    Route::post('like', 'Api\LikeController');
    Route::post('upload', 'Api\UploaderController');

    Route::post('follow', 'Api\FollowController@store');
    Route::delete('follow/{user_id}', 'Api\FollowController@destroy');


    Route::get('profile/ink', 'UserController@profileInk');

    Route::apiResource('chat', 'Message\ChatController')->except('destroy');

    Route::apiResource('share', 'Api\ShareController');
    Route::apiResource('comment', 'Api\CommentController');
    Route::apiResource('ink', 'Api\InkController');
    Route::get('main', 'Api\MainPageController');


    Route::get('notifications', 'Notification\NotificationController@notifications');
    Route::get('notifications/mark-as-read/{uuid}', 'Notification\NotificationController@setNotificationAsRead');
    Route::get('notifications/unread', 'Notification\NotificationController@getUnreadNotification');
    Route::delete('notifications/delete-read', 'Notification\NotificationController@deleteReadNotification');
    Route::get('notifications/mark-all-as-read', 'Notification\NotificationController@notifications');

});

Route::apiResource('admin', 'Admin\AdminController');