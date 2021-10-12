<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Empleado;
use App\Models\Representante;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
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
    $res = Inscripcion::select('grupo_estudiante.id', 'persona.nombre', 'persona.cedula', 'grado.grados as grado', 'seccion.secciones as seccion', 'periodo_escolar.anio_ini', 'periodo_escolar.anio_fin')
      ->join('seccion', 'grupo.seccion', '=', 'seccion.id')
      ->join('grado', 'seccion.grado', '=', 'grado.id')
      ->join('periodo_escolar', 'grupo.periodo_escolar', '=', 'periodo_escolar.id')
      ->join('grupo_estudiante', 'grupo_estudiante.grupo_id', '=', 'grupo.id')
      ->join('estudiante', 'grupo_estudiante.estudiante_id', '=', 'estudiante.id')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->where('grupo_estudiante.status', '=', '1')
      ->orderBy('grupo_estudiante.id', 'desc');

    return response()->json($res->get(), 200);
  }

  /**
   * Display a listing of the resource.
   *
   * @param string cedula
   * @return \Illuminate\Http\Response
   */
  public function estudiante($cedula)
  {
    //
    $res = Estudiante::select('estudiante.*', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.direccion', 'municipality.municipalitys as municipality', 'state.states')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
          ->from('grupo_estudiante')
          ->whereRaw('grupo_estudiante.estudiante_id = estudiante.id');
      })
      ->where([
        ['estudiante.status', '=', '1'],
        ['persona.cedula', '=', $cedula]
      ]);
    $res = $res->first();
    //$num = $cons->count();
    return response()->json($res, 200);
  }

  /**
   * Display a listing of the resource.
   *
   * @param string cedula
   * @return \Illuminate\Http\Response
   */
  public function representante($cedula)
  {
    //
    $res = Representante::select('representante.*', 'ocupacion_laboral.id as ocupacion_laboral', 'state.states', 'persona.direccion', 'municipality.municipalitys as municipality', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
      ->join('ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id')
      ->join('persona', 'representante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where([
        ['representante.status', '1'],
        ['persona.cedula', '=', $cedula]
      ]);
    $res = $res->first();
    //$num = $cons->count();
    return response()->json($res, 200);
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
    $inscripcion = Inscripcion::updateOrCreate([
      'seccion' => $request->seccion,
      'periodo_escolar' => $request->periodoEscolar
    ]);

    $InscripcionEstudiante = DB::table('grupo_estudiante')
      ->updateOrInsert([
        'estudiante_id' => $request->estudiante_id,
        'grupo_id' => $inscripcion->id
      ]);

    $representante = DB::table('estudiante_representante')->insert([
      'parentesco' => $request->parentesco,
      'estudiante' => $request->estudiante_id,
      'representante' => $request->representante_id
    ]);

    $empleado = DB::table('empleado_grupo')->insert([
      'grupo' => $inscripcion->id,
      'empleado' => $request->empleado_id
    ]);

    if ($InscripcionEstudiante) {
      $res = [
        'seccion' => $inscripcion->seccion,
        'periodo_escolar' => $inscripcion->periodoEscolar,
        'estudiante_id' => $request->estudiante_id,
        'grupo_id' => $inscripcion->id,
        'representante' => $representante,
        'empleado' => $empleado
      ];
      $code = 200;
    } else {
      $res = [
        'error' => 'No se pudo Inscribir el usuario'
      ];
      $code = 404;
    }

    return response()->json($res, $code);
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
    $res = Inscripcion::select('grupo.id',  'estudiante.id as estudiante_id', 'grado.grados as grado', 'seccion.id as seccion', 'periodo_escolar.id as periodoEscolar')
      ->join('seccion', 'grupo.seccion', '=', 'seccion.id')
      ->join('grado', 'seccion.grado', '=', 'grado.id')
      ->join('periodo_escolar', 'grupo.periodo_escolar', '=', 'periodo_escolar.id')
      ->join('grupo_estudiante', 'grupo_estudiante.grupo_id', '=', 'grupo.id')
      ->join('estudiante', 'grupo_estudiante.estudiante_id', '=', 'estudiante.id')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->where(
        'grupo_estudiante.id',
        $id
      )
      ->first();

    $estudiante = DB::table('grupo_estudiante')->where('estudiante_id', '=', $res->estudiante_id)->value('estudiante_id');

    $res->estudiante = Estudiante::select('estudiante.*', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono', 'persona.direccion', 'municipality.municipalitys as municipality', 'state.states')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where([
        ['estudiante.status', '=', '1'],
        ['estudiante.id', '=', $estudiante]
      ])->first();

    $res->estudiante_cedula = $res->estudiante->cedula;

    $representante = DB::table('estudiante_representante')->select('representante', 'parentesco')->where('estudiante', '=', $estudiante)->first();

    $parentesco = DB::table('estudiante_representante')->where('estudiante', '=', $estudiante)->value('parentesco');

    $res->representante = Representante::select('representante.*', 'ocupacion_laboral.labor as ocupacion_laboral', 'state.states', 'municipality.municipalitys as municipality', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono', 'persona.direccion')
      ->join('ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id')
      ->join('persona', 'representante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where([
        ['representante.status', '1'],
        ['representante.id', '=', $representante->representante]
      ])->first();

    $res->representante_cedula = $res->representante->cedula;

    $res->parentesco = $parentesco;

    $empleado = DB::table('empleado_grupo')->where('grupo', $res->id)->value('empleado');

    $res->empleado = Empleado::select('empleado.id', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'cargo.cargos as cargo')
      ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->where([
        ['empleado.status', 1],
        ['empleado.id', '=', $empleado]
      ])->first();

    $res->empleado_id = $res->empleado->id;

    return response()->json($res, 200);
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
    $inscripcion = DB::table('grupo_estudiante')->where('id', $id)->first();

    DB::table('grupo_estudiante')->where('id', $id)
      ->update(['estudiante_id' => $request->estudiante_id]);

    DB::table('grupo')->where('id', $inscripcion->grupo_id)
      ->update(["seccion" => $request->seccion, "periodo_escolar" => $request->periodoEscolar]);

    DB::table('estudiante_representante')->where('estudiante_id', $inscripcion->estudiante_id)
      ->update([
        "parentesco" => $request->parentesco,
        "estudiante" => $request->estudiante_id,
        "representante" => $request->representante_id
      ]);

    DB::table('empleado_grupo')->where('grupo_id', $inscripcion->grupo_id)
      ->update(["empleado" => $request->empleado_id]);

    return response()->json([
      "message" => "Todo fue modificado"
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
    $inscripcion = DB::table('grupo_estudiante')->where('id', $id)->first();

    DB::table('grupo_estudiante')->where('id', $id)
      ->update(['status' => 0]);

    DB::table('estudiante_representante')->where('estudiante', $inscripcion->estudiante_id)
      ->update(['status' => 0]);

    $inscripcion = DB::table('empleado_grupo')->where('grupo', $inscripcion->grupo_id)
      ->update(['status' => 0]);

    return response()->noContent(204);
  }
}
