<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Admin;
use App\Ink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');

        if (isset($_GET['resource']))
            $class = $_GET['resource'];
        else
            return response()->json('the resource you looking for is not found', 200);

        Admin::setClass($class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data[0] = Admin::all();
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
        $model = new Admin($request->all());
        return response()->json($model, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Admin::all()->find($id);
        return response()->json($model, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = new Admin($request->all());
        return response()->json($model, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Admin::all()->find($id);
        $model->delete();
        return response()->json($model, 200);
    }
}
