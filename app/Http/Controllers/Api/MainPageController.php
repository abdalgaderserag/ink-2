<?php

namespace App\Http\Controllers\Api;

use App\Follow;
use App\Http\Controllers\Controller;
use App\Ink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainPageController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $inks = Ink::orderBy('created_at', 'desc')->get();
//        $inks = Ink::all();
        $data[0] = $inks;
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
}
