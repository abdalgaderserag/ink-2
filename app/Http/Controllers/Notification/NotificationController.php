<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function __construct()
    {
//        Auth::loginUsingId(1);
    }

    /**
     *  return all the notification for the auth user
     *
     * @return \Illuminate\Http\Response
     **/
    public function notifications()
    {
        $data = Auth::user()->notifications;
        return response()->json($data, 200);
    }

    /**
     *  return set single notification as read
     *
     * @param $uuid
     * @return \Illuminate\Http\Response
     **/
    public function setNotificationAsRead($uuid)
    {
        foreach (Auth::user()->notifications as $notification) {
            if ($notification->uuid == $uuid)
                $notification->delete();
        }
        return response()->json('', 200);
    }

    /**
     *  return all unread notifications
     *
     * @return \Illuminate\Http\Response
     **/
    public function getUnreadNotification()
    {
        return response()->json(Auth::user()->unreadNotifications, 200);
    }

    /**
     *  return all the notification for the auth user
     *
     * @return \Illuminate\Http\Response
     **/
    public function deleteReadNotification()
    {
        foreach (Auth::user()->readNotifications as $notification)
            $notification->delete();
        return response()->json('', 200);
    }

    /**
     *  return all the notification for the auth user
     *
     *
     * @return \Illuminate\Http\Response
     **/
    public function markAllAsRead()
    {
        foreach (Auth::user()->unreadNotifications as $notification)
            $notification->read();
    }

}
