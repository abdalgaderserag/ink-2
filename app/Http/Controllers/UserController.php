<?php

namespace App\Http\Controllers;

use App\Ink;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    public function __construct()
    {
        Auth::loginUsingId(1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['user'] = Auth::user();
        $data['following'] = DB::table('follows')->where('user_id', Auth::id())->count();
        $data['followers'] = DB::table('follows')->where('follow_id', Auth::id())->count();
        return view('user.profile')->with($data);
    }


    public function profileInk()
    {
        if (isset($_GET['slug']))
            $user = User::where('slug', $_GET['slug'])->first();
        else
            $user = Auth::user();

        if (empty($user))
            return response()->json('', 404);

        $inks = Ink::where('user_id', $user->id)->orderBy('created_at', 'desc');
        $data[0] = $inks->with('user', 'media')->get();
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.log');
    }

    /**
     * Log user in.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
//        TODO : redirect to Auth login
    }


    /**
     * Register User.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
//        TODO : redirect to Register Controller
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data['user'] = User::where('slug', $slug)->first();

        if (empty($data['user']))
            return response('404');

        $data['following'] = DB::table('follows')->where('user_id', $data['user']['id'])->count();
        $data['followers'] = DB::table('follows')->where('follow_id', $data['user']['id'])->count();
        $data['follow'] = DB::table('follows')->where('user_id', Auth::id())->where('follow_id', $data['user']['id'])->count();

        return view('user.profile')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit')->with(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->slug = str_slug($request->name);
        $user->details = $request->details;
        $user->save();
        return redirect()->route('user.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Auth::user()->delete();
        Auth::logout();
        return redirect('/');
    }
}
