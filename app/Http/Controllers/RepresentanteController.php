<?php

namespace App\Http\Controllers;

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
        $cons = DB::table('representante')
                    ->select('representante.*', 'ocupacion_laboral.labor', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
                    ->join('ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id')
                    ->join('persona', 'representante.persona', '=', 'persona.id')
                    ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('representante.status', '1')
                    ->orderBy('cedula','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $ocupacion_laboral = DB::table('ocupacion_laboral')->where('status', '1')->orderBy('labor','asc');
        $ocupacion_laboral2 = $ocupacion_laboral->get();
        $num_ocupacion_laboral = $ocupacion_laboral->count();

        $state = DB::table('state')->where('status', '1')->orderBy('states','asc');
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
    public function store(Request $request)
    {
        //
        DB::table('persona')->insert([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'sex' => $request->sex,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'municipality' => $request->municipality
            ]);

        $cons = DB::table('persona')->where('cedula', $request->cedula)->get();

        foreach ($cons as $cons2) {
            # code...
            $persona=$cons2->id;
        }

        DB::table('representante')->insert([
            'ocupacion_laboral' => $request->ocupacion_laboral,
            'persona' => $persona
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        DB::table('persona')->where('id', $request->persona)->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'sex' => $request->sex,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'municipality' => $request->municipality
            ]);

        DB::table('representante')->where('id', $request->id)->update(['ocupacion_laboral' => $request->ocupacion_laboral]);
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
        DB::table('representante')->where('id', $id)->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $cedula=$request->bs_cedula;
        $nombre=$request->bs_nombre;
        $apellido=$request->bs_apellido;
        $sex=$request->bs_sex;
        $ocupacion_laboral=$request->bs_ocupacion_laboral;
        $cons = DB::table('representante')
                    ->select('representante.*', 'ocupacion_laboral.labor', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
                    ->join('ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id')
                    ->join('persona', 'representante.persona', '=', 'persona.id')
                    ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('cedula','like', "%$cedula%")
                    ->where('nombre','like', "%$nombre%")
                    ->where('apellido','like', "%$apellido%")
                    ->where('sex','like', "%$sex%")
                    ->where('ocupacion_laboral','like', "%$ocupacion_laboral%")
                    ->where('representante.status', '1')
                    ->orderBy('cedula','asc');

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
        $id=$request->id;
        $cons= DB::table('representante')
                 ->join('persona', 'representante.persona', '=', 'persona.id')
                 ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                 ->where('representante.id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $cedula=$cons2->cedula;
            $nombre=$cons2->nombre;
            $apellido=$cons2->apellido;
            $sex=$cons2->sex;
            $telefono=$cons2->telefono;
            $direccion=$cons2->direccion;
            $state=$cons2->state;
            $municipality=$cons2->municipality;
            $ocupacion_laboral=$cons2->ocupacion_laboral;
            $persona=$cons2->persona;

        }
        return response()->json([
            'cedula'=>$cedula,
            'nombre'=>$nombre,
            'apellido'=>$apellido,
            'sex'=>$sex,
            'telefono'=>$telefono,
            'direccion'=>$direccion,
            'state'=>$state,
            'municipality'=>$municipality,
            'ocupacion_laboral'=>$ocupacion_laboral,
            'persona'=>$persona
        ]);


    }
}
