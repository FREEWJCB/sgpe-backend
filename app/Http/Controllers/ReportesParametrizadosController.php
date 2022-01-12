<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Notas;
use App\Models\Periodo_escolar;
use App\Models\Representante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class ReportesParametrizadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param number periodoescolar
     * @param number cedula
     * @param number grado
     * @param number seccion
     * @return \Illuminate\Http\Response
     */
    public function inscripcion($periodoescolar, $cedula, $grado, $seccion)
    {
        $consdiciones = [];

        if ($periodoescolar != 0) {
            $consdiciones[] = ['periodo_escolar.id', '=', $periodoescolar];
        }

        if ($cedula != 0) {
            $consdiciones[] = ['persona.cedula', '=', $cedula];
        }

        if ($grado != 0) {
            $consdiciones[] = ['grado.id', '=', $grado];
        }

        if ($seccion != 0) {
            $consdiciones[] = ['seccion.id', '=', $seccion];
        }


        $res = Inscripcion::select('grupo.id', 'grupo.created_at', 'estudiante.id as estudiante_id', 'grado.grados as grado', 'seccion.secciones as seccion', 'periodo_escolar.id as periodoEscolar')
            ->join('seccion', 'grupo.seccion', '=', 'seccion.id')
            ->join('grado', 'seccion.grado', '=', 'grado.id')
            ->join('periodo_escolar', 'grupo.periodo_escolar', '=', 'periodo_escolar.id')
            ->join('grupo_estudiante', 'grupo_estudiante.grupo_id', '=', 'grupo.id')
            ->join('estudiante', 'grupo_estudiante.estudiante_id', '=', 'estudiante.id')
            ->join('persona', 'estudiante.persona', '=', 'persona.id')
            ->where($consdiciones)
            ->get();

        foreach ($res as $key => $inscripcion) {

            $estudiante = DB::table('grupo_estudiante')->where('estudiante_id', '=', $res[$key]->estudiante_id)->value('estudiante_id');

            $res[$key]->estudiante = Estudiante::select('estudiante.*', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono', 'persona.direccion', 'municipality.municipalitys as municipality', 'state.states')
                ->join('persona', 'estudiante.persona', '=', 'persona.id')
                ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                ->join('state', 'municipality.state', '=', 'state.id')
                ->where([
                    ['estudiante.status', '=', '1'],
                    ['estudiante.id', '=', $estudiante]
                ])->first();

            $res[$key]->estudiante_cedula = $res[$key]->estudiante->cedula;

            $representante = DB::table('estudiante_representante')
                ->select('representante', 'parentesco')
                ->where('estudiante', '=', $estudiante)
                ->first();

            $parentesco = DB::table('estudiante_representante')->where('estudiante', '=', $estudiante)->value('parentesco');

            $res[$key]->representante = Representante::select(
                'representante.*',
                'ocupacion_laboral.labor as ocupacion_laboral',
                'state.states',
                'municipality.municipalitys as municipality',
                'persona.cedula',
                'persona.nombre',
                'persona.apellido',
                'persona.sex',
                'persona.telefono',
                'persona.direccion'
            )
                ->join('ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id')
                ->join('persona', 'representante.persona', '=', 'persona.id')
                ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                ->join('state', 'municipality.state', '=', 'state.id')
                ->where([
                    ['representante.status', '1'],
                    ['representante.id', '=', $representante->representante]
                ])->first();

            $res[$key]->representante_cedula = $res[$key]->representante->cedula;

            $res[$key]->parentesco = $parentesco;

            $empleado = DB::table('empleado_grupo')->where('grupo', $res[$key]->id)->value('empleado');

            $res[$key]->empleado = Empleado::select('empleado.id', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'cargo.cargos as cargo')
                ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
                ->join('persona', 'empleado.persona', '=', 'persona.id')
                ->where([
                    ['empleado.status', 1],
                    ['empleado.id', '=', $empleado]
                ])->first();

            $res[$key]->empleado_id = $res[$key]->empleado->id;

            $res[$key]->periodoescolar = Periodo_escolar::find($res[$key]->periodoEscolar);
        }

        $inscripciones = $res;

        return PDF::loadView('reports.inscripcion', compact('inscripciones'))
            //->setPaper('a4', 'landscape') // letter, landscape
            ->download('inscripcion-' . now()->format('d-m-Y') . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param number periodoescolar
     * @param number cedula
     * @param number grado
     * @param number seccion
     * @param number materia
     * @return \Illuminate\Http\Response
     */
    public function notas($periodoescolar, $cedula, $grado, $seccion, $materia)
    {
        $res = DB::table('grupo')
            ->select('persona.nombre', 'persona.apellido', 'estudiante.id', 'materia.id as materia')
            ->join('materia_grupo', 'materia_grupo.grupo', '=', 'grupo.id')
            //->join('materia', 'materia_grupo.grupo', '=', 'grupo.id')
            ->join('materia', 'materia_grupo.materia', '=', 'materia.id')
            ->join('grupo_estudiante', 'grupo_estudiante.grupo_id', '=', 'grupo.id')
            ->join('estudiante', 'grupo_estudiante.estudiante_id', '=', 'estudiante.id')
            ->join('persona', 'estudiante.persona', '=', 'persona.id')
            ->where('materia_grupo.id', $id)
            ->where('materia_grupo.materia', $materia);

        $count = $res->count();

        $res = $res->get();

        $res2 = DB::table('grupo')
            ->selectRaw("seccion.secciones as seccion, grado.grados as grado, concat(periodo_escolar.anio_ini, '-', periodo_escolar.anio_fin) as periodo_escolar, materia.nombre as materia, (select concat(persona.nombre, ' ', persona.apellido) from persona where persona.id = empleado.id) as empleado")
            ->join('materia_grupo', 'materia_grupo.grupo', '=', 'grupo.id')
            ->join('materia', 'materia_grupo.materia', '=', 'materia.id')
            ->join('seccion', 'grupo.seccion', '=', 'seccion.id')
            ->join('periodo_escolar', 'grupo.periodo_escolar', '=', 'periodo_escolar.id')
            ->join('grado', 'seccion.grado', '=', 'grado.id')
            ->join('materia_empleado', 'materia_empleado.materia', '=', 'materia.id')
            ->join('empleado', 'empleado.id', '=', 'materia_empleado.empleado')
            ->where('materia_grupo.materia', $materia)
            ->where('materia_grupo.id', $id)->first();

        for ($i = 0; $i < $count; $i++) {
            $ids = $res[$i]->id;
            $primerLapso = Notas::select('notas.valor')
                ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
                ->join('materia_notas', 'notas.id', '=', 'materia_notas.notas')
                ->where([
                    ['notas.lapso', '=', 1],
                    ['notas_estudiante.estudiante', '=', $res[$i]->id],
                    ['materia_notas.materia', '=', $res[$i]->materia],
                    ['notas.status', '=', 1]
                ])->value('notas.valor');

            $res[$i]->primerLapso = $primerLapso;

            $segundoLapso = Notas::select('notas.valor')
                ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
                ->join('materia_notas', 'notas.id', '=', 'materia_notas.notas')
                ->where([
                    ['notas.lapso', '=', 2],
                    ['notas_estudiante.estudiante', '=', ($ids + 0)],
                    ['materia_notas.materia', '=', $res[$i]->materia],
                    ['notas.status', '=', 1]
                ])->value('notas.valor');

            $res[$i]->segundoLapso = $segundoLapso;

            $tercerLapso = Notas::select('notas.valor')
                ->join('notas_estudiante', 'notas.id', '=', 'notas_estudiante.notas')
                ->join('materia_notas', 'notas.id', '=', 'materia_notas.notas')
                ->where([
                    ['notas.lapso', '=', 3],
                    ['notas_estudiante.estudiante', '=', $res[$i]->id],
                    ['materia_notas.materia', '=', $res[$i]->materia],
                    ['notas.status', '=', 1]
                ])->value('notas.valor');

            $res[$i]->tercerLapso = $tercerLapso;
        }

        return response()->json([
            "grupo" => $res2,
            "estudiantes" => $res
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param number periodoescolar
     * @param number empleado
     * @param date ini
     * @param date fin
     * @return \Illuminate\Http\Response
     */
    public function asistencia(Request $request, $periodoescolar, $empleado, $ini, $fin)
    {
        //        $idEmpleado = $id;
        $label = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
            'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $data = array();

        $dataAsistencia = [];
        $dataInasistencia = [];

        if ($id != 0) {
            for ($i = 0; $i <= 11; $i++) {
                $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', true]
                    ])
                    ->whereRaw("asistencia.fecha >= '" . $request->anio[$i]['ini'] . "' AND asistencia.fecha <= '" . $request->anio[$i]['fin'] . "'");
                $asistio = $asistio->where('asistencia_empleado.empleado', '=', $id);
                $asistio = $asistio->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', false]
                    ])
                    ->whereRaw("asistencia.fecha >= '" . $request->anio[$i]['ini'] . "' AND asistencia.fecha <= '" . $request->anio[$i]['fin'] . "'");
                $noAsistio = $noAsistio->where('asistencia_empleado.empleado', '=', $id);
                $noAsistio = $noAsistio->first();
                array_push($dataAsistencia, $asistio->count);
                array_push($dataInasistencia, $noAsistio->count);
            }
        } else {
            for ($i = 0; $i <= 11; $i++) {
                $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', true]
                    ])
                    ->whereRaw("fecha >= '" . $request->anio[$i]['ini'] . "' AND fecha <= '" . $request->anio[$i]['fin'] . "'")
                    ->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', false]
                    ])
                    ->whereRaw("fecha >= '" . $request->anio[$i]['ini'] . "' AND fecha <= '" . $request->anio[$i]['fin'] . "'")
                    ->first();
                array_push($dataAsistencia, $asistio->count);
                array_push($dataInasistencia, $noAsistio->count);
            }
        }
        //
        return response()->json(
            $this->dataAsistencia($label, "# de Asistencia", $dataAsistencia, "# de Inasistencia", $dataInasistencia)
        );
    }
}
