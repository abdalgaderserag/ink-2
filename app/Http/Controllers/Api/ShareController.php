<?php

namespace App\Http\Controllers\Api;

use App\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shares = Share::where('user_id', Auth::id())->orderBy('created_at', 'desc');
        $data[0] = $shares->with('user', 'media', 'ink.user', 'ink.media')->get();
        $i = 0;
        foreach ($data[0] as $share) {

            $data[1][$i]['like'] = DB::table('likes')
                ->where('ink_id', $share->id)->count();

            $data[1][$i]['isLiked'] = DB::table('likes')
                ->where('user_id', Auth::id())
                ->where('ink_id', $share->id)->count();

            $data[1][$i]['comment'] = DB::table('comments')
                ->where('ink_id', $share->id)->count();

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
        $share = new Share();
        $share->user_id = Auth::id();
        if (isset($request->ink_id))
            $share->ink_id = $request->ink_id;
        else if (isset($request->comment_id))
            $share->comment_id = $request->comment_id;
        $share->save();

        return response()->json('', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Share $share
     * @return \Illuminate\Http\Response
     */
    public function show(Share $share)
    {
        $ink = $share->ink;
        return response()->json($ink, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Share $share
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Share $share)
    {
        $media = $share->media;
        return response()->json($media->updateMedia($request), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws 404
     * @param  \App\Share $share
     * @return \Illuminate\Http\Response
     */
    public function destroy(Share $share)
    {
        $share->delete();
        return response()->json($share, 200);
    }
}
