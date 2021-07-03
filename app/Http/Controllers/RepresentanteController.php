<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeRepresentante;
use App\Http\Requests\Update\updateRepresentante;
use App\Models\Ocupacion_laboral;
use App\Models\Persona;
use App\Models\Representante;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepresentanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = Representante::select('representante.*', 'ocupacion_laboral.labor', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
                    ->join([
                        ['ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id'],
                        ['persona', 'representante.persona', '=', 'persona.id'],
                        ['municipality', 'persona.municipality', '=', 'municipality.id'],
                        ['state', 'municipality.state', '=', 'state.id']
                    ])->where('representante.status', '1')->orderBy('cedula','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $ocupacion_laboral = Ocupacion_laboral::where('status', '1')->orderBy('labor','asc');
        $ocupacion_laboral2 = $ocupacion_laboral->get();
        $num_ocupacion_laboral = $ocupacion_laboral->count();

        $state = State::where('status', '1')->orderBy('states','asc');
        $state2 = $state->get();
        $num_state = $state->count();

        return view('view.representante',['cons' => $cons2, 'num' => $num, 'ocupacion_laboral' => $ocupacion_laboral2, 'num_ocupacion_laboral' => $num_ocupacion_laboral, 'state' => $state2, 'num_state' => $num_state, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeRepresentante $request)
    {
        //
        $persona = Persona::create($request->all());

        DB::table('representante')->insert([
            'ocupacion_laboral' => $request->ocupacion_laboral,
            'persona' => $persona->id
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateRepresentante $request, Representante $Representante)
    {
        //
        Persona::find($request->persona)->update($request->all());

        $Representante->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Representante $Representante)
    {
        //
        $Representante->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $cedula=$request->bs_cedula;
        $nombre=$request->bs_nombre;
        $apellido=$request->bs_apellido;
        $sex=$request->bs_sex;
        $ocupacion_laboral=$request->bs_ocupacion_laboral;
        $cons = Representante::select('representante.*', 'ocupacion_laboral.labor', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
                    ->join([
                        ['ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id'],
                        ['persona', 'representante.persona', '=', 'persona.id'],
                        ['municipality', 'persona.municipality', '=', 'municipality.id'],
                        ['state', 'municipality.state', '=', 'state.id']
                    ])
                    ->where([
                        ['representante.status', '1'],
                        ['cedula','like', "%$cedula%"],
                        ['nombre','like', "%$nombre%"],
                        ['apellido','like', "%$apellido%"],
                        ['sex','like', "%$sex%"],
                        ['ocupacion_laboral','like', "%$ocupacion_laboral%"]
                    ])->orderBy('cedula','asc');

        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $cedula=$cons2->cedula;
                $nombre="$cons2->nombre $cons2->apellido";
                $sex=$cons2->sex;
                $states=$cons2->states;
                $municipalitys=$cons2->municipalitys;
                $labor=$cons2->labor;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$cedula</center></td>
                        <td><center>$nombre</center></td>
                        <td><center>$sex</center></td>
                        <td><center>$states</center></td>
                        <td><center>$municipalitys</center></td>
                        <td><center>$labor</center></td>
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
        return response()->json(['catalogo'=>$cat]);

    }

    public function mostrar(Request $request)
    {
        //
        $representante= Representante::find($request->id)
                 ->join([
                     ['persona', 'representante.persona', '=', 'persona.id'],
                     ['municipality', 'persona.municipality', '=', 'municipality.id']
                 ]);

        return response()->json([
            'cedula'=>$representante->cedula,
            'nombre'=>$representante->nombre,
            'apellido'=>$representante->apellido,
            'sex'=>$representante->sex,
            'telefono'=>$representante->telefono,
            'direccion'=>$representante->direccion,
            'state'=>$representante->state,
            'municipality'=>$representante->municipality,
            'ocupacion_laboral'=>$representante->ocupacion_laboral,
            'persona'=>$representante->persona
        ]);


    }
}
