<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Municipality;

class ReportesController extends Controller
{
    /**
     * Create a new AuthController
     *
     * @return void
     * */
    //public function __construct()
    //{
    //$this->middleware('auth:api');
    //}

    /**
     * Creating a new PDF of Estado.
     *
     * @return \Illuminate\Http\Response
     */
    public function estado()
    {
        //
        $data = State::where('status', '=', 1)->get();

        return $this->createPDF(
            'ReporteEstado',
            'reports.maestros',
            'Reporte de los Estados',
            ['#', 'Estados', 'Creado', 'Modificado'],
            ['id', 'states', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Municipio.
     *
     * @return \Illuminate\Http\Response
     */
    public function municipio()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Grado.
     *
     * @return \Illuminate\Http\Response
     */
    public function grado()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Sección.
     *
     * @return \Illuminate\Http\Response
     */
    public function seccion()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Periodo Escolar.
     *
     * @return \Illuminate\Http\Response
     */
    public function periodoescolar()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Materia.
     *
     * @return \Illuminate\Http\Response
     */
    public function materia()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Estudiante.
     *
     * @return \Illuminate\Http\Response
     */
    public function rstudiante()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Personal.
     *
     * @return \Illuminate\Http\Response
     */
    public function personal()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Ocupación Laboral.
     *
     * @return \Illuminate\Http\Response
     */
    public function ocupacionlaboral()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Representante.
     *
     * @return \Illuminate\Http\Response
     */
    public function representante()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Cargo.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargo()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function usuario()
    {
        //
        $data = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
            ->join('state', 'municipality.state', '=', 'state.id')
            ->where('municipality.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMunicipio',
            'reports.maestros',
            'Reporte de los Municipios',
            ['#', 'Estados', 'Municipio', 'Creado', 'Modificado'],
            ['id', 'states', 'municipalitys', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $tituloReporte
     * @param  string  $vista
     * @param  string  $titulo
     * @param  array   $headers
     * @param  array   $field
     * @param  array   $data
     * @return \Illuminate\Http\Response
     */
    public function createPDF($tituloReporte, $vista, $titulo, $headers, $field, $data)
    {
        //return PDF::loadView('reports.alergia', compact('data'))->setPaper('a4', 'letter')->stream('reportealergia.pdf');
        $date = now()->format('Y-m-d_H-i-s');
        return PDF::loadView($vista, compact('data', 'headers', 'titulo', 'field'))
            ->setPaper('a4', 'landscape') // letter, landscape
            ->download($tituloReporte . '-' . $date);
        //->stream('reportealergia.pdf');
        //->setPaper('dda4', 'landscape') // para tipo de hoja
    }
}
