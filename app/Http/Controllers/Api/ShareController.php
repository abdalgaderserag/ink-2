<?php

namespace App\Http\Controllers\Api;

use App\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Share $share
     * @return \Illuminate\Http\Response
     */
    public function destroy(Share $share)
    {
        //
    }
}
