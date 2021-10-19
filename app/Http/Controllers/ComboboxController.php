<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\State;
use App\Models\Grado;
use App\Models\Seccion;
use App\Models\Municipality;
use App\Models\Ocupacion_laboral;
use App\Models\Empleado;
use App\Models\Materia;
use App\Models\Periodo_escolar;
use Illuminate\Support\Facades\DB;

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
  
  //
  public function grado()
  {
    $res = Grado::select('id', 'grados')->where('status', 1);
    $count = $res->count();

    if($count >= 1){
      $res = $res->get();
        $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay grados registrados"
      ];
        $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }
  
  //
  public function empleado()
  {
    $res = Empleado::select('empleado.id', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'cargo.cargos as cargo')
      ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->whereNotExists(function ($query) {
          $query->select(DB::raw(1))
            ->from('users')
            ->whereRaw('users.empleado = empleado.id');
        })
      ->where('empleado.status', 1);
    $count = $res->count();

    if($count >= 1){
      $res = $res->get();
        $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay empleados registrados"
      ];
        $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }

  //
  public function seccion($id)
  {
    $res = Seccion::select('id', 'secciones')
      ->where('status', 1)
      ->where('grado', $id);

    $count = $res->count();
    if ($count >= 1) {
          $res = $res->get();
          $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay secciones registrados"
      ];
      $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }

  //
  public function periodoescolar()
  {
    $res = Periodo_escolar::select('id', 'anio_ini', 'anio_fin')
      ->where('status', 1);

    $count = $res->count();
    if ($count >= 1) {
          $res = $res->get();
          $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay periodo escolares registrados"
      ];
      $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }

  //
  public function parentescos()
  {
    $res = DB::table('parentesco')->select('id', 'parentescos')
      ->where('status', 1);

    $count = $res->count();
    if ($count >= 1) {
          $res = $res->get();
          $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay periodo escolares registrados"
      ];
      $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }

  //
  public function materia()
  {
    $res = Materia::select('id', 'nombre')
      ->where('status', 1);

    $count = $res->count();
    if ($count >= 1) {
          $res = $res->get();
          $statusCode = 200;
    } else {
      $res = [
        "message" => "no hay materias registradas"
      ];
      $statusCode = 404;
    }

    return response()->json($res, $statusCode);
  }
}
