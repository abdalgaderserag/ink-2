<?php

namespace App\Http\Controllers\Api;

use App\Ink;
use App\Media;
use App\Traits\EditControllerTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InkController extends Controller
{

    use EditControllerTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inks = Ink::where('user_id', Auth::id())->orderBy('created_at', 'desc');
        $data[0] = $inks->get();
        $i = 0;
        foreach ($data[0] as $ink) {

            $data[1][$i]['like'] = DB::table('likes')
                ->where('ink_id', $ink->id)->count();

            $data[1][$i]['isLiked'] = DB::table('likes')
                ->where('user_id', Auth::id())
                ->where('ink_id', $ink->id)->count();

            $data[1][$i]['comment'] = DB::table('comments')
                ->where('ink_id', $ink->id)->count();

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
        try {
            $this->authorize('inks.create');
        } catch (AuthorizationException $error) {
            return response()->json('you are not allowed to create this content', 401);
        }

        $ink = new Ink();
        $ink->user_id = Auth::id();

        /*$media = new Media();
        $media->text = $request->text;
        if (isset($request->media)) {
            foreach ($request->media as $media) {
                $media->media = $media->media . $media . ',';
            }
        }*/

        $ink->save();
//        $media->save();
        $media = Media::setMedia($request);
        $media->ink_id = $ink->id;
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
        try {
            $this->authorize('inks.view', $ink);
        } catch (AuthorizationException $error) {
            return response()->json('you are not allowed to see this content', 401);
        }

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

//        try {
//            $this->authorize('inks.update');
//        } catch (AuthorizationException $error) {
//            return response()->json('you are not allowed to update this content', 401);
//        }

        $media = $ink->media;
        return response()->json($media->updateMedia($request), 200);
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

        try {
            $this->authorize('inks.delete', $ink);
        } catch (AuthorizationException $error) {
            return response()->json('you are not allowed to delete this content', 401);
        }

        $ink->delete();
        return response()->json($ink, 200);
    }
}
