<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
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
        $follow = new Follow();
        $follow->user_slug = Auth::user()->slug;
        $follow->follow_slug = $request->slug;
        $follow->save();
        return response()->json('', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Follow $follow
     * @return \Illuminate\Http\Response
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Follow $follow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Follow $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follow $follow)
    {
        try {
            $follow->delete();
        } catch (\Exception $e) {
            return response()->json('the user you looking for not found', 404);
        }

        return response()->json('', 200);
    }
}
