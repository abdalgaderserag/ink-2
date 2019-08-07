<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MainPageController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
//        Auth::loginUsingId(1);
        $data = Follow::where('user_id', Auth::id())->with('inks.user', 'inks.media', 'inks.like')->get();
        return response()->json($data, 200);
    }
}
