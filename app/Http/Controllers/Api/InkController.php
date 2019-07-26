<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Inks\InteractCountCollection;
use App\Ink;
use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InkController extends Controller
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
        $inks = Ink::where('user_id', Auth::id());
        $data[1] = new InteractCountCollection($inks->with('like', 'comment')->get());
        $data[0] = $inks->with('user', 'media')->get();
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
        $ink = new Ink();
        $ink->user_id = Auth::id();

        $media = new Media();
        $media->text = $request->text;
        if (isset($request->media)) {
            foreach ($request->media as $media) {
                $media->media = $media->media . $media . ',';
            }
        }

        $ink->save();
        $media->save();
        $data[0] = $ink;
        $data[1] = $media;
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ink $ink
     * @return \Illuminate\Http\Response
     */
    public function show(Ink $ink)
    {
        $data = $ink->comment->with('replies.media', 'replies.user')->get();
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Ink $ink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ink $ink)
    {
        $media = $ink->media;
        $media->text = $request->text;
        if (isset($request->media))
            foreach ($request->media as $med) {
                $media->media = $media->media . $med . ',';
            }
        $media->save();
        return response()->json($media, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws 403
     * @param  \App\Ink $ink
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ink $ink)
    {
        $ink->delete();
        return response()->json($ink, 200);
    }
}
