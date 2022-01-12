<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Http\Request;
use App\Http\Requests\Grado as Validation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GradoController extends Controller
{
    /**
     * Create a new AuthController
     *
     * @return void
     * */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @param number page
     * @param number limit
     * @return \Illuminate\Http\Response
     */
    public function index($page, $limit)
    {
        //
        $page = intval($page);
        $skip = ($page != 1) ? ($page - 1) * $limit : 0;

        $cons = Grado::where('status', '1')->orderBy('id', 'desc');
        $count = $cons->count();

        //$num = $cons->count();
        //return response()->json($cons2, 200);
        // paginación
        $cons = $cons
            ->skip($skip)
            ->limit($limit)
            ->orderBy('id', 'desc');
        $cons2 = $cons->get();
        //$num = $cons->count();
        //
        $res = [
            'data' => $cons2,
            'meta' => [
                'all' => $count,
                'next' => ($limit != count($cons2)) ? $page : $page + 1,
                'prev' => ($page != 1) ? $page - 1 : $page,
                'first' => 1,
                'last' => ceil($count / $limit),
                'allData' => count($cons2),
                'skip' => $skip
            ],
        ];

        //$num = $cons->count();
        return response()->json($res, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string busqueda
     * @return \Illuminate\Http\Response
     */
    public function search($busqueda)
    {
        //
        $res = Grado::where(
            [
                ['status', '=', '1'],
                ['grados', 'like', '%' . $busqueda . '%'],
                //['grados', 'like', '%' . strtoupper($busqueda) . '%'],
                //['grados', 'like', '%' . strtolower($busqueda) . '%'],
            ]
        )->orderBy('id', 'desc');
        $res = $res->get();
        //$num = $cons->count();
        return response()->json($res, 200);
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return StateCollection
     */
    public function show($id)
    {
        try {
            $res = Grado::findOrFail($id);
            $code = 200;
        } catch (ModelNotFoundException $e) {
            $res = [
                "error" => $e::class,
                "message" => "no se encontro la seccion"
            ];
            $code = 404;
        }
        return response()->json($res, $code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Validation $request)
    {
        $res = Grado::updateOrCreate(['grados' => $request->grado]);
        return response()->json($res, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Validation $request, $id)
    {
        $res = Grado::find($id);
        $res->grados = $request->grado;
        $res->save();
        return response()->json($res, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Grado::find($id);
        $res->status = 0;
        $res->save();

        return response()->json($res, 202);
    }
}
