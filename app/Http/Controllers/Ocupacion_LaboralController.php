<?php

namespace App\Http\Controllers;

use App\Http\Requests\OcupacionLaboral as Validation;
use App\Models\Ocupacion_laboral;

class Ocupacion_LaboralController extends Controller
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
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $cons = Ocupacion_laboral::where('status', '1')->orderBy('labor', 'asc');
    $cons2 = $cons->get();
    //$num = $cons->count();
    return response()->json($cons2, 200);
  }

  /**
   * Show the profile for the given user.
   *
   * @param  int  $id
   * @return Municipality
   */
  public function show($id)
  {
    $ol = Ocupacion_laboral::find($id);
    if (Ocupacion_laboral::find($id)) {
      return response()->json($ol, 200);
    } else {
      return response()->json([
        "error" => "No se encontro La ocupacion laboral",
        "code" => 404
      ], 404);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Validation $request)
  {
    //
    $ol = Ocupacion_laboral::updateOrCreate(['labor' => $request->labor]);
    return response()->json($ol, 200);
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
    $ol = Ocupacion_laboral::find($id);
    $ol->labor = $request->labor;

    return response()->json($ol, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $ol = Ocupacion_laboral::find($id);
    $ol->status = 0;
    $ol->save();

    return response()->noContent(204);
  }
}
