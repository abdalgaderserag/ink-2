<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Requests\MediaRequest;
use App\Media;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (isset($_GET['comment']))
            $data[0] = Comment::where('comment_id', $_GET['comment'])->with('media', 'user')->orderBy('created_at', 'desc')->get();
        else if (isset($_GET['ink']))
            $data[0] = Comment::where('ink_id', $_GET['ink'])->with('media', 'user')->orderBy('created_at', 'desc')->get();
        else
            return response()->json('no data found :(', 204);
        $i = 0;
        foreach ($data[0] as $comment) {

            $data[1][$i]['like'] = DB::table('likes')
                ->where('comment_id', $comment->id)->count();

            $data[1][$i]['isLiked'] = DB::table('likes')
                ->where('user_id', Auth::id())
                ->where('comment_id', $comment->id)->count();

            if (isset($_GET['ink']))
                $data[1][$i]['comment'] = DB::table('comments')
                    ->where('comment_id', $comment->id)->count();

            $i++;
        }
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $comment = new Comment();
        $comment->user_id = Auth::id();
        if (!empty($request->ink_id)) {
            $comment->ink_id = $request->ink_id;
        } else {
            $comment->comment_id = $request->comment_id;
        }
        $comment->save();

        $media = Media::setMedia($request);
        $media->validate($request);
        $media->comment_id = $comment->id;
        $media->save();


        $data[0] = $comment;
        $data[1] = $media;
        $data[2]['isLiked'] = 0;
        $data[2]['like'] = 0;
        $data[2]['comment'] = 0;

        return response()->json($data, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $data = $comment->replies();
        $data->with('media', 'user', 'like');
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $media = $comment->media;
        $media->validate($request);
        $comment->media = $media->updateMedia($request);
        return response()->json($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws 403
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json($comment, 200);
    }
}
