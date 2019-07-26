<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __construct()
    {
//        Auth::logout();
        Auth::loginUsingId(1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('user_id', Auth::id())->where('ink_id', $_GET['ink'])->with('media', 'user')->get();
//        $comments = Comment::where('user_id', Auth::id())->where('ink_id', 1)->with('media', 'user')->get();
        return response()->json($comments, 200);
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
        if (isset($request->ink_id)) {
            $comment->ink_id = $request->ink_id;
        } else {
            $comment->comment_id = $request->comment_id;
        }
        $comment->save();
        $media = new Media();
        $media->text = $request->text;
        if (isset($request->media))
            foreach ($request->media as $media) {
                $media->media = $media->media . $media . ',';
            }

        $media->comment_id = $comment->id;
        $media->save();

        $data[0] = $comment;
        $data[1] = $media;

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
        $m = $comment->media;
        $m->text = $request->text;
        if (isset($request->media))
            foreach ($request->media as $med) {
                $m->media = $m->media . $med . ',';
            }
        $m->save();
        $comment->media = $m;
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
