<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
//use Carbon\Carbon; // Para las fechas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
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
   * @param  int  $start
   * @param  int  $end
   * @param  int  $month
   * @param  int  $year
   * @return \Illuminate\Http\Response
   */
  public function index($start, $end, $month, $year)
  {
    //
    $res = [];
    //
    //$startDate = Asistencia::where('id', 1)->value('fecha');
    for ($i = ( $start + 0 ); $i <= ( $end + 0 ); $i++) {
      $asistio = Asistencia::select(DB::raw('count(*) as asistio'))
        ->where([
          ['status', '=', 1],
          ['fecha', '=', $year . '-' . $month . '-' . $i],
          ['asistio', '=', true]
        ])
        ->first();

      $noAsistio = DB::table('asistencia')
        ->select(DB::raw('count(*) as no_asistio'))
        ->where([
          ['status', '=', 1],
          ['fecha', '=', $year . '-' . $month . '-' . $i],
          ['asistio', '=', false]
        ])
        ->first();

      $day = ($i <= 9) ? '0'.$i : $i;

      if( $asistio->asistio != 0 ){
        array_push($res, [
          "title" => $asistio->asistio . ' aistieron',
          "date" => $year . '-' . $month . '-' . $day,
          "color" => "blue"
        ]);
      }

      if($noAsistio->no_asistio != 0) {
        array_push($res, [
          "title" => $noAsistio->no_asistio . ' no aistieron',
          "date" => $year . '-' . $month . '-' . $day,
          "color" => "red"
        ]);
      }
    }

    return response()->json($res);
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
    $asistencia = Asistencia::create([
      'fecha' => $request->fecha,
      'asistio' => $request->asistio,
      'motivo' => $request->motivo
    ]);

    $asistenciaEmpleado = DB::table('asistencia_empleado')->insert([
      'asistencia' => $asistencia->id,
      'empleado' => $request->empleado_id
    ]);

    return response()->json([
      "asistencia" => $asistencia,
      "asistencia_empleado" => $asistenciaEmpleado
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $edit
   * @return \Illuminate\Http\Response
   */
  public function empleado($edit)
  {
    //
    if ($edit === "0") {
      $res = Empleado::select('empleado.id', 'persona.nombre', 'persona.apellido', 'cargo.cargos as cargo')
        ->join('persona', 'persona.id', '=', 'empleado.persona')
        ->join('cargo', 'cargo.id', '=', 'empleado.cargo')
        ->whereNotExists(function ($query) {
          $query->select(DB::raw(1))
            ->from('asistencia_empleado')
            ->join('asistencia', 'asistencia.id', '=', 'asistencia_empleado.asistencia')
            ->where('asistencia.fecha', '=', now()->subDays(1)->format('Y-m-d'))
            ->where('asistencia_empleado.status', 1)
            ->whereRaw('asistencia_empleado.empleado = empleado.id');
        })->where([
          ['empleado.status', '=', 1]
        ])->get();
    } else {
      $res = Empleado::select('empleado.id', 'persona.nombre', 'persona.apellido', 'cargo.cargos as cargo')
        ->join('persona', 'persona.id', '=', 'empleado.persona')
        ->join('cargo', 'cargo.id', '=', 'empleado.cargo')
        ->get();
    }

    //return response()->json([$res, $edit, now()->subDays(1)->format('Y-m-d')]);
    return response()->json($res);
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
    $res = Asistencia::select('asistencia.fecha', 'asistencia.motivo', 'asistencia.asistio', 'empleado.id as empleado_id')
      ->join('asistencia_empleado', 'asistencia_empleado.asistencia', '=', 'asistencia.id')
      ->join('empleado', 'empleado.id', '=', 'asistencia_empleado.empleado')
      ->join('persona', 'persona.id', '=', 'empleado.persona')
      ->where([
        ['asistencia.status', '=', 1],
        ['asistencia.id', '=', $id]
      ])->first();

    //if ($res) {
    $res->empleado = Empleado::select('empleado.id', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'empleado.cargo')
      ->join('persona', 'persona.id', '=', 'empleado.persona')
      ->join('asistencia_empleado', 'asistencia_empleado.empleado', '=', 'empleado.id')
      ->where([
        ['empleado.status', '=', 1],
        ['asistencia_empleado.asistencia', '=', $id]
      ])->first();
    //} else {
    //$res = [
    //"error" => "no se an registrados la asistencia"
    //];
    //}

    return response()->json($res);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $fecha
   * @return \Illuminate\Http\Response
   */
  public function showAllDay($fecha)
  {
    //
    $res = Asistencia::select('asistencia.id', 'asistencia.fecha', 'asistencia.asistio', 'asistencia.motivo', 'persona.nombre', 'persona.apellido', 'empleado.cargo', 'empleado.id as empleado_id')
      ->join('asistencia_empleado', 'asistencia_empleado.asistencia', '=', 'asistencia.id')
      ->join('empleado', 'empleado.id', '=', 'asistencia_empleado.empleado')
      ->join('persona', 'persona.id', '=', 'empleado.persona')
      ->where([
        ['asistencia.status', '=', 1],
        ['asistencia.fecha', '=', $fecha]
      ])->orderBy('asistencia.asistio', 'desc')
      ->get();

    return response()->json($res);
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
    $asistencia = Asistencia::where('id', $id)->update(
      ["fecha" => $request->fecha, "asistio" => $request->asistio, "motivo" => $request->motivo]
    );

    $asistenciaEmpleado = DB::table('asistencia_empleado')->where('asistencia', $id)
      ->update(['asistencia' => $id, 'empleado' => $request->empleado_id]);

    return response()->json([
      "asistencia" => $asistencia,
      "asistencia_empleado" => $asistenciaEmpleado
    ]);
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
    Asistencia::where('id', $id)->update(['status' => 0]);

    DB::table('asistencia_empleado')
      ->where('asistencia', '=', $id)
      ->update(['status' => 0]);

    return response()->noContent();
  }
}
