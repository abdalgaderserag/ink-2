<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('user_id', Auth::id())->where('ink_id', $_GET['ink'])->with('media', 'user');
        return response()->json($comments->get(), 200);
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
            $comment->media = $this->mediaType($request);
        } else {
            $comment->comment_id = $request->comment_id;
            $comment->media = $this->mediaType($request, false);
        }
        return response()->json($comment, 200);
    }


    /**
     * Bind the media to comment
     *
     *
     * @param Request $request
     * @param $type = true
     * @return Media $media
     **/
    private function mediaType(Request $request, $type = true)
    {
        $media = new Media();
        $media->text = $request->text;

        if ($type)
            $media->ink_id = $request->ink_id;
        else
            $media->comment_id = $request->comment_id;

        foreach ($request->media as $media) {
            $media->media = $media->media . $media . ',';
        }

        return $media->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $data = $comment->replies;
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
        $media = $comment->media();
        $media->text = $request->text;
        foreach ($request->media as $med) {
            $media->media = $media->media . $med . ',';
        }
        $media->save();
        $comment->media = $media;
        return response()->json($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json($comment, 200);
    }
}
