<?php

namespace App\Http\Controllers;

use App\Models\Periodo_escolar;
use Illuminate\Http\Request;

class Periodo_EscolarController extends Controller
{
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
    $cons = Periodo_escolar::select('id', 'anio_ini', 'anio_fin')->where('status', '1');

    $count = $cons->count();
    // paginación
    $cons = $cons
      ->skip($skip)
      ->limit($limit)
      ->orderBy('anio_ini', 'desc');
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
    $res = Periodo_escolar::select('id', 'anio_ini', 'anio_fin')->where([
      ['status', '1'],
      ['anio_ini', 'like', '%'.$busqueda.'%']
    ])->orderBy('anio_ini', 'DESC');
    $res = $res->get();
    //$num = $cons->count();
    return response()->json($res, 200);
  }

  /**
   * Show the profile for the given user.
   *
   * @param  int  $id
   * @return Municipality
   */
  public function show($id)
  {
    $estudiante = Periodo_escolar::select('id', 'anio_ini', 'anio_fin')->where([
      ['status', '1'],
      ['id', '=', $id]
    ])->get();
    if (Periodo_escolar::find($id)) {
      return response()->json($estudiante, 200);
    } else {
      return response()->json([
        "error" => "No se encontro el El Periodo Escolar",
        "code" => 404
      ], 404);
    }
    //return new StateResource(State::find($id));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
    $res = Periodo_escolar::create($request->all());
    return response()->json($res, 202);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
    $periodoEscolar = Periodo_escolar::find($id);

    $periodoEscolar->anio_ini = $request->anio_ini;
    $periodoEscolar->anio_fin = $request->anio_fin;

    $periodoEscolar->save();

    return response()->json($periodoEscolar, 200);
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
    $periodoEscolar = Periodo_escolar::find($id);
    $periodoEscolar->status = 0;
    $periodoEscolar->save();

    return response()->noContent(204);
  }
}
