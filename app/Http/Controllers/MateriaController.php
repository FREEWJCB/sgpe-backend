<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use App\Http\Requests\Materia as Validate;

class MateriaController extends Controller
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
   * @param string page
   * @param string limit
   * @return \Illuminate\Http\Response
   */
  public function index($page, $limit)
  {
    //
    $skip = ($page != 1) ? ($page - 1) * $limit : 0;
    //
    $cons = Materia::where('status', '1');
    $count = $cons->count();
    // paginación
    $cons = $cons
      ->skip($skip)
      ->limit($limit)
      ->orderBy('materia.id', 'desc');
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
    $res = Materia::where([
      ['status', '=', '1'],
      ['nombre', 'like', '%'.$busqueda.'%']
    ])
      ->orderBy('nombre', 'asc');
    $res = $res->get();
    //$num = $cons->count();
    return response()->json($res, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  App\Http\Request\Materia  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Validate $request)
  {
    //
    $res = Materia::updateOrCreate(['nombre' => $request->materia]);
    return response()->json($res, 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
    return response()->json(Materia::findOrFail($id), 202);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  App\Http\Request\Materia  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Validate $request, $id)
  {
    //
    $res = Materia::find($id);
    $res->nombre = $request->materia;
    $res->save();

    return response()->json($res, 202);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
    $res = Materia::find($id);
    $res->status = 0;
    $res->save();

    return response()->json($res, 202);
  }
}
