<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cargo as Validation;
use App\Models\Cargo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// use Illuminate\Support\Facades\DB;

class CargoController extends Controller
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
    $cons = Cargo::where('status', '1');
    $count = $cons->count();
    // paginación
    $cons = $cons
      ->skip($skip)
      ->limit($limit)
      ->orderBy('cargo.id', 'desc');
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
    $res = Cargo::where([
      ['status', '=', '1'],
      ['cargos', 'like', '%' . strtoupper($busqueda) . '%'],
      ['cargos', 'like', '%' . strtolower($busqueda) . '%'],
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
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $res = Cargo::findOrFail($id);
      $code = 200;
    } catch (ModelNotFoundException $e) {
      $res = [
        "error" => "no se encontro el cargo",
        "value" => $e->getIds()
      ];
      $code = 404;
    }
    return response()->json($res,$code);
    //return response()->json(Cargo::findOrFail($id), 202);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  App\Http\Requests\Cargo as Validation
   * @return \Illuminate\Http\Response
   */
  public function store(Validation $request)
  {
    //
    $res = Cargo::updateOrCreate(['cargos' => $request->cargo]);
    return response()->json($res, 201);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  App\Http\Requests\Cargo as Validation
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Validation $request, $id)
  {
    //
    $res = Cargo::find($id);
    $res->cargos = $request->cargo;
    $res->save();
    return response()->json($res,200);
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
    // DB::table('cargo')->where('id', $Cargo->id)->update(['status' => 0]);
    $res = Cargo::find($id);
    $res->status = 0;
    $res->save();
    return response()->json($res, 202);
  }

}
