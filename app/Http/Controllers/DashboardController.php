<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function anio($anio, Request $request)
    {
        //
        //
        //
        return response()->json($this->dataAsistencia("mes del año"));
        //return response()->json([$anio, $request->anio[0]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mes(Request $request)
    {
        //
        return response()->json($this->dataAsistencia("dias del mes"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dia(Request $request)
    {
        //
        return response()->json($this->dataAsistencia("dias de la semana"));
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
