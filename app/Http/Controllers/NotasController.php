<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Notas;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotasController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $res = DB::table('materia_grupo')
      ->select('materia.nombre as materia', 'seccion.secciones', 'grado.grados', 'periodo_escolar.anio_ini', 'periodo_escolar.anio_fin', 'materia_grupo.id')
      ->join('materia', 'materia_grupo.materia', '=', 'materia.id')
      ->join('grupo', 'grupo.id', '=', 'materia_grupo.grupo')
      ->join('seccion', 'grupo.seccion', '=', 'seccion.id')
      ->join('periodo_escolar', 'grupo.periodo_escolar', '=', 'periodo_escolar.id')
      ->join('grado', 'seccion.grado', '=', 'grado.id')
      ->where([
        ['materia_grupo.status', '=', 1]
      ])
    ->orderBy('materia_grupo', 'desc');

    $count = $res->count();

    if ($count >= 1) {
      $res = $res->get();
      $code = 200;
    } else {
      $res = [
        "error" => "No hay ninguna nota registrada"
      ];
      $code = 404;
    }
    return response()->json($res, $code);
  }

  /**
   * Display a listing of the resource.
   *
   * @param  int  $periodo
   * @param  int  $seccion
   * @return \Illuminate\Http\Response
   */
  public function search($periodo, $seccion)
  {
    //
    $res = DB::table('materia_grupo')
      ->select('materia.nombre as materia', 'seccion.secciones', 'grado.grados', 'periodo_escolar.anio_ini', 'periodo_escolar.anio_fin', 'materia_grupo.id')
      ->join('materia', 'materia_grupo.materia', '=', 'materia.id')
      ->join('grupo', 'grupo.id', '=', 'materia_grupo.grupo')
      ->join('seccion', 'grupo.seccion', '=', 'seccion.id')
      ->join('periodo_escolar', 'grupo.periodo_escolar', '=', 'periodo_escolar.id')
      ->join('grado', 'seccion.grado', '=', 'grado.id')
      ->where([
        ['materia_grupo.status', '=', 1],
        ['grupo.seccion', '=', $seccion],
        ['grupo.periodo_escolar', '=', $periodo]
      ])
    ->orderBy('materia_grupo', 'desc');

    $count = $res->count();

    if ($count >= 1) {
      $res = $res->get();
      $code = 200;
    } else {
      $res = [
        "error" => "No hay ninguna nota registrada"
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
  public function store(Request $request)
  {
    //
    $grupoId = Inscripcion::where([
      ["seccion", '=', $request->seccion],
      ["periodo_escolar", '=', $request->periodo_escolar]
    ])->value('id');

    //
    $materiaGrupo = DB::table('materia_grupo')
      ->insert([
        "materia" => $request->materia,
        "grupo" => $grupoId
      ]);

    //
    $materiaEmpleado = DB::table('materia_empleado')
      ->insert([
        "materia" => $request->materia,
        "empleado" => $request->empleado_id
      ]);

    //
    $empleadoGrupo = DB::table('empleado_grupo')
      ->insert([
        "empleado" => $request->empleado_id,
        "grupo" => $grupoId
      ]);

    //
    return response()->json([
      "grupo" => $grupoId,
      "materia_grupo" => $materiaGrupo,
      "materia_empleado" => $materiaEmpleado,
      "empleado_grupo" => $empleadoGrupo
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function valor(Request $request)
  {
    //
    foreach ($request->notas as $nota) {
      $result = Notas::firstOrCreate([
        "valor" => $nota['valor'],
        "lapso" => $nota['lapso']
      ]);

      DB::table('notas_estudiante')
        ->insert(
          ["notas" => $result->id, "estudiante" => $nota['estudiante_id']]
        );
    }

    $res = [
      "message" => "Fueron creados las notas"
    ];

    return response()->json($res);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $grado
   * @return \Illuminate\Http\Response
   */
  public function seccion($grado)
  {
    //
    $res = Seccion::select('id', 'secciones')
      ->where([
        ['status', '=', 1],
        ['grado', '=', $grado]
      ])
      ->whereExists(function ($query) {
        $query->select(DB::raw(1))
          ->from('grupo')
          ->whereRaw('grupo.seccion = seccion.id');
      });

    $count = $res->count();

    if ($count >= 1) {
      $res = $res->get();
      $code = 200;
    } else {
      $res = [
        "error" => "no hay secciones registradas en alguna inscripción"
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
    $res = DB::table('materia_grupo')
      ->select('materia.id as materia', 'seccion.id as seccion', 'grado.id as grado', 'periodo_escolar.id as periodo_escolar', 'materia_grupo.id', 'materia_empleado as empleado_id')
      ->join('grupo', 'grupo.id', '=', 'materia_grupo.grupo')
      ->join('materia', 'materia_grupo.materia', '=', 'materia.id')
      ->join('seccion', 'grupo.seccion', '=', 'seccion.id')
      ->join('periodo_escolar', 'grupo.periodo_escolar', '=', 'periodo_escolar.id')
      ->join('grado', 'seccion.grado', '=', 'grado.id')
      ->join('materia_empleado', 'materia_empleado.materia', '=', 'materia.id')
      ->where([
        'materia_grupo.id', '=', $id
      ])->first();

    return response()->json($res);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function notas($id)
  {
    //
    $res = DB::table('grupo')
      ->select('persona.nombre', 'persona.apellido', 'estudiante.id')
      ->join('materia_grupo', 'materia_grupo.grupo', '=', 'grupo.id')
      ->join('materia', 'materia_grupo.grupo', '=', 'grupo.id')
      ->join('grupo_estudiante', 'grupo_estudiante.grupo_id', '=', 'grupo.id')
      ->join('estudiante', 'grupo_estudiante.estudiante_id', '=', 'estudiante.id')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->where('materia_grupo.id', $id);

    $count = $res->count();

    $res = $res->get();

    for($i = 0; $i < $count; $i++) {
      $ids = $res[$i]->id;
      $primerLapso = Notas::select('notas.valor')
        ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
        ->where([
          ['notas.lapso', '=', 1],
          ['notas_estudiante.estudiante', '=', $res[$i]->id],
          ['notas.status', '=', 1]
        ])->value('notas.valor');

      $res[$i]->primerLapso = $primerLapso;

      $segundoLapso = Notas::select('notas.valor')
        ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
        ->where([
          ['notas.lapso', '=', 2],
          ['notas_estudiante.estudiante', '=', ($ids + 0)],
          ['notas.status', '=', 1]
        ])->value('notas.valor');

      $res[$i]->segundoLapso = $segundoLapso;

      $tercerLapso = Notas::select('notas.valor')
        ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
        ->where([
          ['notas.lapso', '=', 3],
          ['notas_estudiante.estudiante', '=', $res[$i]->id],
          ['notas.status', '=', 1]
        ])->value('notas.valor');

      $res[$i]->tercerLapso = $tercerLapso;
    }

    return response()->json($res);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function estudiante($id)
  {
    //
    $res = Estudiante::select('persona.nombre', 'persona.apellido')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->where('estudiante.id', $id)
      ->first();

    $count = DB::table('notas_estudiante')->where('notas_estudiante.estudiante', $id)->count();

    if ($count !== 0) {

      $primerLapso = DB::table('notas')->select('notas.id', 'notas.valor', 'notas.lapso')
        ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
        ->where('notas_estudiante.estudiante', $id)
        ->where('notas.lapso', 1)
        ->first();
      $primerLapso->estudiante_id = $id;

      $segundoLapso = DB::table('notas')->select('notas.id', 'notas.valor', 'notas.lapso')
        ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
        ->where('notas_estudiante.estudiante', $id)
        ->where('notas.lapso', 2)
        ->first();
      $segundoLapso->estudiante_id = $id;

      $tercerLapso = DB::table('notas')->select('notas.id', 'notas.valor', 'notas.lapso')
        ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
        ->where('notas_estudiante.estudiante', $id)
        ->where('notas.lapso', 3)
        ->first();
      $tercerLapso->estudiante_id = $id;

      $res->notas = [
        $primerLapso, $segundoLapso, $tercerLapso
      ];
    } else {
      $res->notas = [
        ["id" => 0, "estudiante_id" => $id, "valor" => 0, "lapso " => 1],
        ["id" => 0, "estudiante_id" => $id, "valor" => 0, "lapso " => 2],
        ["id" => 0, "estudiante_id" => $id, "valor" => 0, "lapso " => 3]
      ];
    }

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
    $ids = Inscripcion::select('grupo.id as grupoId', 'materia_empleado.id as materiaEmpleadoId', 'empleado_grupo.id empleadoGrupoId')
      ->join('materia_grupo', 'materia_grupo.grupo', '=', 'grupo.id')
      ->join('materia_empleado', 'materia_empleado.materia', '=', 'materia_grupo.materia')
      ->join('empleado_grupo', 'empleado_grupo.grupo', '=', 'materia_grupo.grupo')
      ->where([
        ["materia_grupo.id" => $id]
      ])->first();

    //
    $materiaGrupo = DB::table('materia_grupo')
      ->where('materia_grupo.id', $id)
      ->update([
        "materia" => $request->materia,
      ]);

    //
    $materiaEmpleado = DB::table('materia_empleado')
      ->where('id', $ids->materiaEmpleadoId)
      ->update([
        "materia" => $request->materia,
        "empleado" => $request->empleado_id
      ]);

    //
    $empleadoGrupo = DB::table('empleado_grupo')
      ->where('empleado_grupo.grupo', $ids->grupoId)
      ->update([
        "empleado" => $request->empleado_id,
      ]);

    //
    return response()->json([
      "grupo" => $ids->grupoId,
      "materia_grupo" => $materiaGrupo,
      "materia_empleado" => $materiaEmpleado,
      "empleado_grupo" => $empleadoGrupo
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updateNotasEstudiante(Request $request, $id)
  {
    //
    foreach ($request->notas as $nota) {
     $notas = Notas::find($nota['id']);
     $notas->valor = $nota['valor'];
     $notas->lapso = $nota['lapso'];
     $notas->save();

      //DB::table('notas_estudiante')
        //->where([
          //["notas", '=', $nota['id']],
          //["estudiane", '=', $nota['estudiante_id']]
        //])
        //->update(
          //["notas" => $nota['id'], "estudiante" => $nota['estudiante_id']]
        //);
    }

    $res = [
      "message" => "Fueron modificadas las notas",
      "id" => $id
    ];

    return response()->json($res);
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
    $result = DB::table('materia_grupo')
      ->where('id', $id)
      ->groupBy('grupo')
      ->first();
    //
    DB::table('materia_grupo')
      ->where('id', $id)
      ->update([
        "status" => 0
      ]);

    //
    DB::table('materia_empleado')
      ->where('materia', $result->materia)
      ->update(["status" => 0]);

    //
    DB::table('empleado_grupo')
      ->where('grupo', $result->grupo)
      ->update(["status" => 0]);

    return response()->noContent();
  }
}
