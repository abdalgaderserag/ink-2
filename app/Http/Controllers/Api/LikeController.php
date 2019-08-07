<?php

namespace App\Http\Controllers\Api;

use App\Like;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{


    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
//        Auth::loginUsingId(1);
//        check if like already added and then delete him.
        if (isset($request->ink_id))
            $like = Like::where('user_id', Auth::id())->where('ink_id', $request->ink_id)->first();
        else if (isset($request->comment_id))
            $like = Like::where('user_id', Auth::id())->where('comment_id', $request->comment_id)->first();
        if (!empty($like->id)) {

            try {
                $this->authorize('likes.delete', $like);
            } catch (AuthorizationException $error) {
                return response()->json('you are not allowed to delete this content', 401);
            }

            return response()->json('' . !$like->delete(), 200);
        }

        try {
            $this->authorize('likes.create');
        } catch (AuthorizationException $error) {
            return response()->json('you are not allowed to create this content', 401);
        }

//       if there are no like create new one.
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
