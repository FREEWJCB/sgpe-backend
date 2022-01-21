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
            ->download('inscripcion-' . now()->format('d-m-Y') . '.pdf');
        //->setPaper('a4', 'landscape') // letter, landscape
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param number periodoescolar
     * @param number grado
     * @param number seccion
     * @param number materia
     * @return \Illuminate\Http\Response
     */
    public function notas($periodoescolar, $grado, $seccion, $materia)
    {
        $consdiciones = [];
        $consdicionesSegunda = [];

        if ($periodoescolar != 0) {
            $consdicionesSegunda[] = ['periodo_escolar.id', '=', $periodoescolar];
        }

        if ($grado != 0) {
            $consdicionesSegunda[] = ['grado.id', '=', $grado];
        }

        if ($seccion != 0) {
            $consdiciones[] = ['grupo.seccion', '=', $materia];
            $consdicionesSegunda[] = ['seccion.id', '=', $seccion];
        }

        if ($materia != 0) {
            $consdiciones[] = ['materia.id', '=', $materia];
            $consdicionesSegunda[] = ['materia.id', '=', $materia];
        } else {
            $consdiciones[] = ['materia.id', '!=', $materia];
            $consdicionesSegunda[] = ['materia.id', '!=', $materia];
        }

        $res = DB::table('grupo')
            ->select('persona.nombre', 'persona.apellido', 'estudiante.id', 'materia.id as materia')
            ->join('materia_grupo', 'materia_grupo.grupo', '=', 'grupo.id')
            //->join('materia', 'materia_grupo.grupo', '=', 'grupo.id')
            ->join('materia', 'materia_grupo.materia', '=', 'materia.id')
            ->join('grupo_estudiante', 'grupo_estudiante.grupo_id', '=', 'grupo.id')
            ->join('estudiante', 'grupo_estudiante.estudiante_id', '=', 'estudiante.id')
            ->join('persona', 'estudiante.persona', '=', 'persona.id')
            ->where($consdiciones);

        $count = $res->count();

        $res = $res->get();

        $res2 = DB::table('grupo')
            ->selectRaw(
                "seccion.secciones as seccion, grado.grados as grado, concat(periodo_escolar.anio_ini, '-', periodo_escolar.anio_fin) as periodo_escolar, materia.nombre as materia, (select concat(persona.nombre, ' ', persona.apellido) from persona where persona.id = empleado.id) as empleado"
            )
            ->join('materia_grupo', 'materia_grupo.grupo', '=', 'grupo.id')
            ->join('materia', 'materia_grupo.materia', '=', 'materia.id')
            ->join('seccion', 'grupo.seccion', '=', 'seccion.id')
            ->join('periodo_escolar', 'grupo.periodo_escolar', '=', 'periodo_escolar.id')
            ->join('grado', 'seccion.grado', '=', 'grado.id')
            ->join('materia_empleado', 'materia_empleado.materia', '=', 'materia.id')
            ->join('empleado', 'empleado.id', '=', 'materia_empleado.empleado')
            ->where($consdicionesSegunda)->get();

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

        $grupos = $res2;

        $estudiantes = $res;

        return PDF::loadView('reports.notas', compact('grupos', 'estudiantes'))
            ->download('notas-' . now()->format('d-m-Y') . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param number empleado
     * @return \Illuminate\Http\Response
     */
    public function asistencia($anio, $empleado)
    {
        //        $idEmpleado = $id;
        $label = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
            'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $data = array();

        $getAnio = [
            ['ini' => '01-01-' . $anio, 'fin' => '31-01-' . $anio],
            ['ini' => '01-02-' . $anio, 'fin' => '28-02-' . $anio],
            ['ini' => '01-03-' . $anio, 'fin' => '31-03-' . $anio],
            ['ini' => '01-04-' . $anio, 'fin' => '30-04-' . $anio],
            ['ini' => '01-05-' . $anio, 'fin' => '31-05-' . $anio],
            ['ini' => '01-06-' . $anio, 'fin' => '30-06-' . $anio],
            ['ini' => '01-07-' . $anio, 'fin' => '31-07-' . $anio],
            ['ini' => '01-08-' . $anio, 'fin' => '31-08-' . $anio],
            ['ini' => '01-09-' . $anio, 'fin' => '30-09-' . $anio],
            ['ini' => '01-10-' . $anio, 'fin' => '31-10-' . $anio],
            ['ini' => '01-11-' . $anio, 'fin' => '30-11-' . $anio],
            ['ini' => '01-12-' . $anio, 'fin' => '31-12-' . $anio]
        ];

        $dataAsistencia = [];
        $dataInasistencia = [];

        $id = $empleado;

        if ($id != 0) {
            for ($i = 0; $i <= 11; $i++) {
                $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', true]
                    ])
                    ->whereRaw("asistencia.fecha >= '" . $getAnio[$i]['ini'] . "' AND asistencia.fecha <= '" . $getAnio[$i]['fin'] . "'");
                $asistio = $asistio->where('asistencia_empleado.empleado', '=', $id);
                $asistio = $asistio->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', false]
                    ])
                    ->whereRaw("asistencia.fecha >= '" . $getAnio[$i]['ini'] . "' AND asistencia.fecha <= '" . $getAnio[$i]['fin'] . "'");
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
                    ->whereRaw("fecha >= '" . $getAnio[$i]['ini'] . "' AND fecha <= '" . $getAnio[$i]['fin'] . "'")
                    ->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', false]
                    ])
                    ->whereRaw("fecha >= '" . $getAnio[$i]['ini'] . "' AND fecha <= '" . $getAnio[$i]['fin'] . "'")
                    ->first();
                array_push($dataAsistencia, $asistio->count);
                array_push($dataInasistencia, $noAsistio->count);
            }
        }
        //
        return PDF::loadView('reports.asistencia', compact('label', 'dataAsistencia', 'dataInasistencia'))
            ->setPaper('a4', 'landscape')
            ->download('asistencia-' . now()->format('d-m-Y') . '.pdf');
    }
}
