<?php

namespace App\Http\Controllers\Message;

use App\Chat;
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
        $chat1 = Chat::where('first_user', 1);
        $chat2 = Chat::where('second_user', 1);
        $chat = array_merge($chat1->get(), $chat2->get());
        return response()->json($chat);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chat = new Chat();
        $chat->first_user = Auth::id();
        $chat->second_user = $request->user_id;
        $chat->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat $message
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Chat $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $message)
    {
        //
    }
}
