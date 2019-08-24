<?php

namespace App\Http\Controllers\Message;

use App\Chat;
use App\Notifications\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = [];
        $i = 0;
        foreach (Chat::all() as $chat) {
            if ($chat->first_user == Auth::id() || $chat->second_user == Auth::id())
                $chats[$i] = $chat;
            $i++;
        }
        return response()->json($chats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chat = Chat::where('first_user', Auth::id())->where('second_user', $request->user_id);
        if ($chat->exists)
            return response()->json('');
        $chat = new Chat();
        $chat->first_user = Auth::id();
        $chat->second_user = $request->user_id;
        $chat->save();
        $chat->notify(new Message($request));
        return response()->json('');
    }


    /**
     * Display the specified resource.
     *
     * @param  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($chat)
    {
        $chat = Chat::where('id', $chat)->first();
        if ($chat->exists)
            return response()->json($chat->notifications);
        return response()->json('');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Chat $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        $chat->notify(new Message($request));
    }
}
