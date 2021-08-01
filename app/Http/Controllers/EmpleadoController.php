<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeEmpleado;
use App\Http\Requests\Update\updateEmpleado;
use App\Models\Cargo;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\State;
use Illuminate\Http\Request;
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
        $cons = Empleado::select('empleado.*', 'cargo.cargos', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
                    ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
                    ->join('persona', 'empleado.persona', '=', 'persona.id')
                    ->join('municipality', 'persona.municipality', '=', 'municipality.id')
                    ->join('state', 'municipality.state', '=', 'state.id')->where('empleado.status', '1')->orderBy('cedula','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $cargo = Cargo::where('status', '1')->orderBy('cargos','asc');
        $cargo2 = $cargo->get();
        $num_cargo = $cargo->count();

        $state = State::where('status', '1')->orderBy('states','asc');
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
    public function store(storeEmpleado $request)
    {
        //
        $persona = Persona::create($request->all());

        Empleado::create([
            'email' => $request->email,
            'cargo' => $request->cargo,
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
    public function update(updateEmpleado $request, Empleado $Empleado)
    {
        //
        Persona::where('id', $request->persona)->update($request->all());

        $Empleado->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $Empleado)
    {
        //
        $Empleado->update(['status' => 0]);
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
        $cons = Empleado::select('empleado.*', 'cargo.cargos', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
                    ->join([
                        ['cargo', 'empleado.cargo', '=', 'cargo.id'],
                        ['persona', 'empleado.persona', '=', 'persona.id'],
                        ['municipality', 'persona.municipality', '=', 'municipality.id'],
                        ['state', 'municipality.state', '=', 'state.id']
                        ])
                    ->where([
                        ['empleado.status', '1'],
                        ['cedula','like', "%$cedula%"],
                        ['nombre','like', "%$nombre%"],
                        ['apellido','like', "%$apellido%"],
                        ['sex','like', "%$sex%"],
                        ['email','like', "%$email%"],
                        ['cargo','like', "%$cargo%"]
                        ])
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
        $empleado = Empleado::find($request->id)
                    ->join([
                        ['persona', 'empleado.persona', '=', 'persona.id'],
                        ['municipality', 'persona.municipality', '=', 'municipality.id']
                    ]);

        return response()->json([
            'cedula'=>$empleado->cedula,
            'nombre'=>$empleado->nombre,
            'apellido'=>$empleado->apellido,
            'sex'=>$empleado->sex,
            'telefono'=>$empleado->telefono,
            'direccion'=>$empleado->direccion,
            'state'=>$empleado->state,
            'municipality'=>$empleado->municipality,
            'email'=>$empleado->email,
            'cargo'=>$empleado->cargo,
            'persona'=>$empleado->persona
        ]);


    }
}
