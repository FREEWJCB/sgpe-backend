<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storePeriodo_Escolar;
use App\Models\Empleado;
use App\Models\Grado;
use App\Models\Periodo_escolar;
use App\Models\Salon;
use App\Models\Seccion;
use Illuminate\Http\Request;
class Periodo_EscolarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = Periodo_escolar::select('periodo_escolar.*', 'grado.grados', 'seccion.secciones', 'salon.salones', 'persona.cedula', 'persona.nombre', 'persona.apellido')
                    ->join([
                        ['grado', 'periodo_escolar.grado', '=', 'grado.id'],
                        ['seccion', 'periodo_escolar.seccion', '=', 'seccion.id'],
                        ['salon', 'periodo_escolar.salon', '=', 'salon.id'],
                        ['empleado', 'periodo_escolar.empleado', '=', 'empleado.id'],
                        ['persona', 'empleado.persona', '=', 'persona.id']
                    ])->where('periodo_escolar.status', '1')->orderBy('ano','DESC');
        $cons2 = $cons->get();
        $num = $cons->count();

        $grado = Grado::where('status', '1')->orderBy('grados','asc');
        $grado2 = $grado->get();
        $num_grado = $grado->count();

        $seccion = Seccion::where('status', '1')->orderBy('secciones','asc');
        $seccion2 = $seccion->get();
        $num_seccion = $seccion->count();

        $salon = Salon::where('status', '1')->orderBy('salones','asc');
        $salon2 = $salon->get();
        $num_salon = $salon->count();

        return view('view.periodo_escolar',['cons' => $cons2, 'num' => $num, 'grado' => $grado2, 'num_grado' => $num_grado, 'seccion' => $seccion2, 'num_seccion' => $num_seccion, 'salon' => $salon2, 'num_salon' => $num_salon, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storePeriodo_Escolar $request)
    {
        //
        $periodo_escolar = Periodo_escolar::where([
            ['salon', $request->salon],
            ['seccion', $request->seccion],
            ['salon', $request->salon],
            ['ano', $request->ano],
            ['empleado', $request->empleado]
        ]);
        $num = $periodo_escolar->count();
        if ($num > 0) {
            # code...
            $num2 = $periodo_escolar->where('status', 0)->count();
            if ($num2 == 0) {
                # code...
                $periodo_escolar->update(['status' => 1]);
            }else{
                return response()->json(['error' => 'error', 'message' => 'El periodo escolar ya está en uso', 'limpiar' => true]);
            }

        }else{
            Periodo_escolar::create($request->all());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(storePeriodo_Escolar $request, Periodo_escolar $Periodo_Escolar)
    {
        //
        $periodo_escolar = Periodo_Escolar::where([
            ['salon', $request->salon],
            ['seccion', $request->seccion],
            ['salon', $request->salon],
            ['ano', $request->ano],
            ['empleado', $request->empleado]
        ]);
        $num = $periodo_escolar->count();
        $id=0;
        $error="false";
        $message="";
        $limpiar=false;
        if ($num > 0) {
            $num2 = $periodo_escolar->where('status', 0)->count();
            if ($num2 == 0) {
                $periodo_escolar1 = $periodo_escolar->get();
                foreach ($periodo_escolar1 as $periodo_escolar2) {
                    # code...
                    $id = $periodo_escolar2->id;
                }
                $periodo_escolar->update(['status' => 1]);
                $Periodo_Escolar->update(['status' => 0]);
            }else{
                $error = "error";
                $message="El periodo escolar ya está en uso";
                $limpiar=true;
            }
        }else{
            $Periodo_Escolar->update($request->all());
        }

        return response()->json([
            'i' => $num,
            'id' => $id,
            'error' => $error,
            'message' => $message,
            'limpiar' => $limpiar
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periodo_escolar $Periodo_Escolar)
    {
        //
        $Periodo_Escolar->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $grado=$request->bs_grado;
        $seccion=$request->bs_seccion;
        $salon=$request->bs_salon;
        $ano=$request->bs_ano;
        $cedula=$request->bs_cedula;
        $nombre=$request->bs_nombre;
        $apellido=$request->bs_apellido;
        $cons = Periodo_escolar::select('periodo_escolar.*', 'grado.grados', 'seccion.secciones', 'salon.salones', 'persona.cedula', 'persona.nombre', 'persona.apellido')
                    ->join([
                        ['grado', 'periodo_escolar.grado', '=', 'grado.id'],
                        ['seccion', 'periodo_escolar.seccion', '=', 'seccion.id'],
                        ['salon', 'periodo_escolar.salon', '=', 'salon.id'],
                        ['empleado', 'periodo_escolar.empleado', '=', 'empleado.id'],
                        ['persona', 'empleado.persona', '=', 'persona.id']
                    ])->where([
                        ['grado','like', "%$grado%"],
                        ['seccion','like', "%$seccion%"],
                        ['salon','like', "%$salon%"],
                        ['ano','like', "%$ano%"],
                        ['cedula','like', "%$cedula%"],
                        ['nombre','like', "%$nombre%"],
                        ['apellido','like', "%$apellido%"],
                        ['periodo_escolar.status', '1']
                    ])->orderBy('ano','DESC');

        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $grados=$cons2->grados;
                $secciones=$cons2->secciones;
                $salones=$cons2->salones;
                $ano=$cons2->ano;
                $cedula=$cons2->cedula;
                $nombre=$cons2->nombre;
                $apellido=$cons2->apellido;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$cedula</center></td>
                        <td><center>$nombre $apellido</center></td>
                        <td><center>$grados</center></td>
                        <td><center>$secciones</center></td>
                        <td><center>$salones</center></td>
                        <td><center>$ano</center></td>
                        <td>
                            <center data-turbolinks='false' class='navbar navbar-light'>
                                <a onclick = \"return mostrar($id,'Mostrar');\" class='btn btn-info btncolorblanco' href='#' >
                                    <i class='fa fa-list-alt'></i>
                                </a>
                                <a onclick = \"return mostrar($id,'Edicion');\" class='btn btn-success btncolorblanco' href='#' >
                                    <i class='fa fa-edit'></i>
                                </a>
                                <a onclick ='return desactivar($id)' class='btn btn-danger btncolorblanco' href='#' >
                                    <i class='fa fa-trash-alt'></i>
                                </a>
                            </center>
                        </td>
                    </tr>";

            }
        }else{
            $cat="<tr><td colspan='8'>No hay datos registrados</td></tr>";
        }
        return response()->json([
            'catalogo'=>$cat
        ]);

    }

    public function mostrar(Request $request)
    {
        //
        $periodo_escolar= Periodo_escolar::find($request->id)->join([
            ['empleado', 'periodo_escolar.empleado', '=', 'empleado.id'],
            ['persona', 'empleado.persona', '=', 'persona.id']
        ]);

        return response()->json([
            'grado' => $periodo_escolar->grado,
            'seccion' => $periodo_escolar->seccion,
            'salon' => $periodo_escolar->salon,
            'ano' => $periodo_escolar->ano,
            'cedula' => $periodo_escolar->cedula,
            'nombre' => "$periodo_escolar->nombre $periodo_escolar->apellido",
            'empleado' => $periodo_escolar->empleado
        ]);


    }
    public function empleado(Request $request)
    {
        //
        $id="";
        $nombre="";
        $cedula=$request->cedula;
        $cons= Empleado::join([
            ['persona', 'empleado.persona', '=', 'persona.id'],
            ['cargo', 'empleado.cargo', '=', 'cargo.id']
        ])->where([
            ['cedula', $cedula],
            ['cargos', 'PROFESOR']
        ])->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            foreach ($cons as $cons2) {
                # code...
                $id=$cons2->id;
                $nombre="$cons2->nombre $cons2->apellido";
            }
        }

        return response()->json([
            'id'=>$id,
            'nombre'=>$nombre,
            'num'=>$num
        ]);


    }
}
