<?php

namespace App\Http\Controllers\Api;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function __construct()
    {
        Auth::loginUsingId(1);
    }


    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $like = Like::where('user_id', Auth::id())->where('ink_id', $request->ink_id)->first();
        if (empty($like->id))
            $like = Like::where('user_id', Auth::id())->where('ink_id', $request->ink_id)->first();
        if (!empty($like->id))
            return response()->json(''.!$like->delete(), 200);
        $like = new Like();

        $like->user_id = Auth::id();
        if (isset($request->ink_id)) {
            $like->ink_id = $request->ink_id;
        } elseif (isset($request->comment_id)) {
            $like->comment_id = $request->comment_id;
        }
        $like->save();
        return response('' . true, 200);
    }
}
