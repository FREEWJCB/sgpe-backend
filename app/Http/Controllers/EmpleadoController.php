<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('empleado')
                    ->select('empleado.*', 'cargo.cargos', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
                    ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
                    ->join('persona', 'empleado.persona', '=', 'persona.id')
                    ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('empleado.status', '1')
                    ->orderBy('cedula','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $cargo = DB::table('cargo')->where('status', '1')->orderBy('cargos','asc');
        $cargo2 = $cargo->get();
        $num_cargo = $cargo->count();

        $state = DB::table('state')->where('status', '1')->orderBy('states','asc');
        $state2 = $state->get();
        $num_state = $state->count();

        return view('view.empleado',['cons' => $cons2, 'num' => $num, 'cargo' => $cargo2, 'num_cargo' => $num_cargo, 'state' => $state2, 'num_state' => $num_state, 'js' => $js]);
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

        DB::table('empleado')->insert([
            'email' => $request->email,
            'cargo' => $request->cargo,
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

        DB::table('empleado')->where('id', $request->id)->update([
            'email' => $request->email,
            'cargo' => $request->cargo
            ]);

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
        DB::table('empleado')->where('id', $id)->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $cedula=$request->bs_cedula;
        $nombre=$request->bs_nombre;
        $apellido=$request->bs_apellido;
        $sex=$request->bs_sex;
        $email=$request->bs_email;
        $cargo=$request->bs_cargo;
        $cons = DB::table('empleado')
                    ->select('empleado.*', 'cargo.cargos', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
                    ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
                    ->join('persona', 'empleado.persona', '=', 'persona.id')
                    ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('cedula','like', "%$cedula%")
                    ->where('nombre','like', "%$nombre%")
                    ->where('apellido','like', "%$apellido%")
                    ->where('sex','like', "%$sex%")
                    ->where('email','like', "%$email%")
                    ->where('cargo','like', "%$cargo%")
                    ->where('empleado.status', '1')
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
                $email=$cons2->email;
                $cargos=$cons2->cargos;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$cedula</center></td>
                        <td><center>$nombre</center></td>
                        <td><center>$sex</center></td>
                        <td><center>$states</center></td>
                        <td><center>$municipalitys</center></td>
                        <td><center>$email</center></td>
                        <td><center>$cargos</center></td>
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
        $cons= DB::table('empleado')
                 ->join('persona', 'empleado.persona', '=', 'persona.id')
                 ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                 ->where('empleado.id', $id)->get();

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
            $email=$cons2->email;
            $cargo=$cons2->cargo;
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
            'email'=>$email,
            'cargo'=>$cargo,
            'persona'=>$persona
        ]);


    }
}
