<?php

namespace App\Http\Controllers;

use App\Models\Ocupacion_laboral as OcupacionLaboral;
use App\Models\Cargo;
use App\Models\Empleado;
use App\Models\Estudiante;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\State;
use App\Models\Grado;
use App\Models\Materia;
use App\Models\Seccion;
use App\Models\Periodo_escolar;
use App\Models\Municipality;
use App\Models\Representante;
use App\Models\User;
use Carbon\Carbon;

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
        $data = Municipality::select(
            'municipality.id',
            'municipality.municipalitys',
            'municipality.state as state_id',
            'municipality.status',
            'municipality.created_at',
            'municipality.updated_at',
            'state.states'
        )
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
        $data = Grado::where('status', '1')->orderBy('grados', 'asc')->get();

        return $this->createPDF(
            'ReporteGrado',
            'reports.maestros',
            'Reporte de los Grados',
            ['#', 'Nombre', 'Creado', 'Modificado'],
            ['id', 'grados', 'created_at', 'updated_at'],
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
        $data = Seccion::select('seccion.*', 'grado.grados')
            ->join('grado', 'grado.id', '=', 'seccion.grado')
            ->where('seccion.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteSeccion',
            'reports.maestros',
            'Reporte de los Secciones',
            ['#', 'Grado', 'Sección', 'Creado', 'Modificado'],
            ['id', 'grados', 'secciones', 'created_at', 'updated_at'],
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
        $data = Periodo_escolar::select('id', 'anio_ini', 'anio_fin')->where('status', '1')
            ->get();

        return $this->createPDF(
            'ReportePeriodoEscolar',
            'reports.maestros',
            'Reporte de los PeriodoEscolares',
            ['#', 'Año incial', 'Año final', 'Creado', 'Modificado'],
            ['id', 'anio_ini', 'anio_fin', 'created_at', 'updated_at'],
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
        $data = Materia::where('status', '1')
            ->get();

        return $this->createPDF(
            'ReporteMateria',
            'reports.maestros',
            'Reporte de los Materias',
            ['#', 'Nombre', 'Creado', 'Modificado'],
            ['id', 'nombre', 'created_at', 'updated_at'],
            $data
        );
    }

    /**
     * Creating a new PDF of Estudiante.
     *
     * @return \Illuminate\Http\Response
     */
    public function estudiante()
    {
        //
        $data = Estudiante::select(
            'estudiante.*',
            'persona.cedula',
            'persona.nombre',
            'persona.apellido',
            'persona.sex'
        )
            ->join('persona', 'estudiante.persona', '=', 'persona.id')
            ->where('estudiante.status', '1')
            ->get();

        foreach ($data as $key => $estudiante) {
            $fecha = new Carbon($estudiante->fecha_nacimiento);

            //$data[$key]['fecha_nacimiento'] = $fecha->isoFormat('MMMM Do YYYY');
            //$data[$key]['fecha_nacimiento'] = $fecha->isoFormat('D[/]MM[/]Y');
            $data[$key]['fecha_nacimiento'] = $fecha->format('d/m/Y');
        }

        return $this->createPDF(
            'ReporteEstudiante',
            'reports.maestros',
            'Reporte de los Estudiantes',
            ['#', 'Cedula', 'Nombres', 'Apellidos', 'Fecha de Nacimiento', 'Sexo', 'Creado'],
            ['id', 'cedula', 'nombre', 'apellido', 'fecha_nacimiento', 'sex', 'created_at'],
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
        $data = Empleado::select(
            'empleado.*',
            'cargo.cargos',
            'persona.cedula',
            'persona.nombre',
            'persona.apellido',
            'persona.sex'
        )
            ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
            ->join('persona', 'empleado.persona', '=', 'persona.id')
            ->where('empleado.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteEmpleado',
            'reports.maestros',
            'Reporte de los Empleados',
            ['#', 'Cedula', 'Nombres', 'Apellidos', 'Cargo', 'Sexo', 'Creado'],
            ['id', 'cedula', 'nombre', 'apellido', 'cargos', 'sex', 'created_at'],
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
        $data = OcupacionLaboral::where('status', 1)->get();

        return $this->createPDF(
            'ReporteOcupacion Laboral',
            'reports.maestros',
            'Reporte de la Ocupacion Laboral',
            ['#', 'Ocupación Laboral', 'Creado', 'Modificado'],
            ['id', 'labor', 'created_at', 'updated_at'],
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
        $data  = Representante::select(
            'representante.*',
            'ocupacion_laboral.labor',
            'persona.cedula',
            'persona.nombre',
            'persona.apellido',
            'persona.sex',
            'persona.telefono'
        )
            ->join('ocupacion_laboral', 'representante.ocupacion_laboral', ' = ', 'ocupacion_laboral.id')
            ->join('persona', 'representante.persona', '= ', 'persona.id')
            ->where('representante.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteRepresentante',
            'reports.maestros',
            'Reporte de los Representantes',
            ['#', 'Cedula', 'Nombres', 'Apellidos', 'Labor', 'Sexo', 'Creado'],
            ['id', 'cedula', 'nombre', 'apellido', 'labor', 'sex', 'updated_at'],
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
        $data = Cargo::where('status', '1')
            ->get();

        return $this->createPDF(
            'ReporteCargo',
            'reports.maestros',
            'Reporte de los Cargos',
            ['#', 'Cargo', 'Crado', 'Modificado'],
            ['id', 'cargos', 'created_at', 'updated_at'],
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
        $data = User::select('users.*', 'persona.*', 'empleado.*', 'cargo.cargos')
            ->join('empleado', 'users.empleado', '=', 'empleado.id')
            ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
            ->join('persona', 'empleado.persona', '=', 'persona.id')
            ->where('users.status', '1')
            ->get();

        return $this->createPDF(
            'ReporteUsuario',
            'reports.maestros',
            'Reporte de los Usuarios',
            ['#', 'Correo', 'Nombres', 'Apellidos', 'Cargo', 'Sexo', 'Creado'],
            ['id', 'email', 'nombre', 'apellido', 'cargos', 'sex', 'created_at'],
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
            //->setPaper('a4', 'landscape') // letter, landscape
            ->download($tituloReporte . '-' . $date);
        //$pdf = PDF::loadView($vista, compact('data', 'headers', 'titulo', 'field'))
        //->setPaper('a4', 'landscape') // letter, landscape
        //->download($tituloReporte . '-' . $date)
        //->stream('reportealergia.pdf');
        //->setPaper('dda4', 'landscape') // para tipo de hoja
        //return response()->streamDownload(fn () => print($pdf), $tituloReporte);
    }
}
