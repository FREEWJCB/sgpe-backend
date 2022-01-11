<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $anio
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function anio(Request $request, $anio, $id)
    {
        //
        $idEmpleado = $id;
        $label = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
            'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $data = array();
        $dataAsistencia = [];
        $dataInasistencia = [];

        if($id != 0){
            for($i = 0; $i <= 11; $i++){
                $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', true]
                    ])
                    ->whereRaw("asistencia.fecha >= '".$request->anio[$i]['ini']."' AND asistencia.fecha <= '".$request->anio[$i]['fin']."'");
                $asistio = $asistio->where('asistencia_empleado.empleado','=', $id);
                $asistio = $asistio->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', false]
                    ])
                    ->whereRaw("asistencia.fecha >= '".$request->anio[$i]['ini']."' AND asistencia.fecha <= '".$request->anio[$i]['fin']."'");
                $noAsistio = $noAsistio->where('asistencia_empleado.empleado','=', $id);
                $noAsistio = $noAsistio->first();
                array_push($dataAsistencia, $asistio->count );
                array_push($dataInasistencia, $noAsistio->count );
            }
        } else {
            for($i = 0; $i <= 11; $i++){
                $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', true]
                    ])
                    ->whereRaw("fecha >= '".$request->anio[$i]['ini']."' AND fecha <= '".$request->anio[$i]['fin']."'")
                    ->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', false]
                    ])
                    ->whereRaw("fecha >= '".$request->anio[$i]['ini']."' AND fecha <= '".$request->anio[$i]['fin']."'")
                    ->first();
                array_push($dataAsistencia, $asistio->count );
                array_push($dataInasistencia, $noAsistio->count );
            }
        }
        //
        return response()->json(
            $this->dataAsistencia($label, "# de Asistencia", $dataAsistencia, "# de Inasistencia", $dataInasistencia)
        );
        //return response()->json([$anio, $request->anio[0]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $ini
     * @param  int  $end
     * @param  int  $mes
     * @param  int  $anio
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function mes($ini, $end, $mes, $anio, $id, Request $request)
    {
        //

        $idEmpleado = $id;
        $label = [];
        $data = array();
        $dataAsistencia = [];
        $dataInasistencia = [];

        for ($j = 1; $j <= $end; $j++)
        {
            array_push($label, $j);
        }

        if($id != 0){
            for($i = 1; $i <= $end;$i++){
                $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', true],
                        ['asistencia.fecha', '=', $i.'-'.$mes.'-'.$anio],
                    ]);
                $asistio = $asistio->where('asistencia_empleado.empleado','=', $id);
                $asistio = $asistio->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', false],
                        ['asistencia.fecha', '=', $i.'-'.$mes.'-'.$anio],
                    ]);
                $noAsistio = $noAsistio->where('asistencia_empleado.empleado','=', $id);
                $noAsistio = $noAsistio->first();
                array_push($dataAsistencia, $asistio->count );
                array_push($dataInasistencia, $noAsistio->count );
            }
        } else {
            for($i = 1; $i <= $end; $i++){
                $dia = ($ini <= 9) ? '0'.$i : $
                    $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', true],
                        ['asistencia.fecha', '=', $i.'-'.$mes.'-'.$anio],
                    ])
                    ->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', false],
                        ['asistencia.fecha', '=', $i.'-'.$mes.'-'.$anio],
                    ])
                    ->first();
                array_push($dataAsistencia, $asistio->count );
                array_push($dataInasistencia, $noAsistio->count );
            }
        }
        //
        return response()->json(
            $this->dataAsistencia($label, "# de Asistencia", $dataAsistencia, "# de Inasistencia", $dataInasistencia)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  int  $end
     * @param  int  $mes
     * @param  int  $anio
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function semana($ini, $end, $mes, $anio, $id, Request $request)
    {
        //
        $idEmpleado = $id;
        $label = [];
        $data = array();
        $dataAsistencia = [];
        $dataInasistencia = [];

        for ($j = $ini; $j <= $end; $j++)
        {
            array_push($label, $j);
        }

        if($id != 0){
            for($i = $ini; $i <= $end;$i++){
                $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', true],
                        ['asistencia.fecha', '=', $i.'-'.$mes.'-'.$anio],
                    ]);
                $asistio = $asistio->where('asistencia_empleado.empleado','=', $id);
                $asistio = $asistio->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->join('asistencia_empleado', 'asistencia_empleado.asistencia', 'asistencia.id')
                    ->where([
                        ['asistencia.status', '=', 1],
                        ['asistencia.asistio', '=', false],
                        ['asistencia.fecha', '=', $i.'-'.$mes.'-'.$anio],
                    ]);
                $noAsistio = $noAsistio->where('asistencia_empleado.empleado','=', $id);
                $noAsistio = $noAsistio->first();
                array_push($dataAsistencia, $asistio->count );
                array_push($dataInasistencia, $noAsistio->count );
            }
        } else {
            for($i = $ini; $i <= $end; $i++){
                $asistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', true],
                        ['asistencia.fecha', '=', $i.'-'.$mes.'-'.$anio],
                    ])
                    ->first();
                //
                $noAsistio = Asistencia::select(DB::raw('count(*)'))
                    ->where([
                        ['status', '=', 1],
                        ['asistio', '=', false],
                        ['asistencia.fecha', '=', $i.'-'.$mes.'-'.$anio],
                    ])
                    ->first();
                array_push($dataAsistencia, $asistio->count );
                array_push($dataInasistencia, $noAsistio->count );
            }
        }
        //
        return response()->json(
            $this->dataAsistencia($label, "# de Asistencia", $dataAsistencia, "# de Inasistencia", $dataInasistencia)
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function data()
    {
        //
        $res = [];
        $anio = now()->format('Y');
        $ini = sprintf('01-01-%s', $anio);
        $end = sprintf('31-12-%s', $anio);

        $usuarios = User::where('status', '=', 1)
            ->count();

        $inscripciones = DB::table('grupo_estudiante')->selectRaw('count(*)')
            ->whereRaw(sprintf("created_at >= '%s' AND created_at <= '%s'", $ini, $end))
            ->where('status', '=', 1)
            ->value('count');

        $asistencia = DB::table('asistencia')
            ->whereRaw(sprintf("fecha >= '%s' AND fecha <= '%s'", $ini, $end))
            ->where('status', '=', 1)
            ->where('asistio', '=', 1)
            ->count();

        $inasistencia = DB::table('asistencia')
            ->whereRaw(sprintf("fecha >= '%s' AND fecha <= '%s'", $ini, $end))
            ->where('status', '=', 1)
            ->where('asistio', '=', 0)
            ->count();

        $res = [
            "usuarios" => $usuarios,
            "inscripciones" => $inscripciones,
            "asistencia" => $asistencia,
            "inasistencia" => $inasistencia
        ];

        return response()->json($res);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit()
    {
        //
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
    }

    /**
     * Return the specified resource from Asistencia.
     *
     * @param  int  $labels
     * @param  int  $asistenciaLabel
     * @param  int  $asistenciaData
     * @param  int  $inasistenciaLabel
     * @param  int  $inasistenciaData
     * @return \Illuminate\Http\Response
    */
    public function dataAsistencia($labels, $asistenciaLabel, $asistenciaData, $inasistenciaLabel, $inasistenciaData)
    {
        //
        $data = [
            "labels" => $labels,
            "datasets" => [
                [
                    "label" => $asistenciaLabel,
                    "data" => $asistenciaData,
                    "backgroundColor" => "blue",
                    "borderColor" => "blue",
                    "borderWidth" => 1
                ],
                [
                    "label" => $inasistenciaLabel,
                    "data" => $inasistenciaData,
                    "backgroundColor" => "red",
                    "borderColor" => "red",
                    "borderWidth" => 1
                ],
            ]
        ];
        //
        return $data;
    }

    /**
     * Return the specified resource from Inscripciones.
     *
     * @param  int  $labels
     * @param  int  $count
     * @param  int  $label
     * @param  int  $datas
     * @param  int  $colors
     * @return \Illuminate\Http\Response
    */
    public function dataInscripciones($labels, $count, $label, $datas, $colors)
    {
        //
        $data = [];
        //
        for ($i = 0; $I <= $count; $i++)
        array_push($data, [
            "label" => $label[$i],
            "data" => $datas[$i],
            "backgroundColor" => $label[$i],
            "borderColor" => $label[$i],
            "borderWidth" => 1,
        ]);
        //
        return $data;
    }
}
