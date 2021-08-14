<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\State;
use App\Models\Municipality;
use App\Models\Ocupacion_laboral;

class ComboboxController extends Controller
{
  /**
   * Create a new ComboboxController
   *
   * @return void
   * */
  public function __construct()
  {
    $this->middleware('auth:api');
  }

  //
  public function estado()
  {
    $res = State::select('id', 'states')->where('status', 1);
    $count = $res->count();

    if($count >= 1)    {
    $res = $res->get();
    $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay ningun estado"
      ];
      $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }

  //
  public function municipio($id)
  {
    $res = Municipality::select('id', 'municipalitys as municipio')
      ->where('status', 1)
      ->where('state', $id);

    $count = $res->count();
    if ($count >= 1) {
          $res = $res->get();
          $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay municipios registrados"
      ];
      $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }

  //
  public function cargo()
  {
    $res = Cargo::select('id', 'cargos')->where('status', 1);
    $count = $res->count();

    if($count >= 1){
          $res = $res->get();
          $statusCode = 200;
    } else {
        $res = [
          "message" => "no hay cargos registrados"
        ];
        $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }

  //
  public function ocupacionlaboral()
  {
    $res = Ocupacion_laboral::select('id', 'labor')->where('status', 1);
    $count = $res->count();

    if($count >= 1){
      $res = $res->get();
        $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay ocupaciones laborales registradas"
      ];
        $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }
}
