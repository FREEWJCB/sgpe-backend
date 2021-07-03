<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('usuario')
                    ->select('usuario.*','empleado.*','persona.*','tipo_usuario.tipo as tip')
                    ->join('tipo_usuario', 'usuario.tipo', '=', 'tipo_usuario.id')
                    ->join('empleado', 'usuario.empleado', '=', 'empleado.id')
                    ->join('persona', 'empleado.persona', '=', 'persona.id')
                    ->where('usuario.status', '1')
                    ->orderBy('username','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $tipo = DB::table('tipo_usuario')->where('status', '1')->orderBy('tipo','asc');
        $tipo2 = $tipo->get();
        $num_tipo = $tipo->count();

        return view('view.Usuario',['cons' => $cons2, 'num' => $num, 'tipo' => $tipo2, 'num_tipo' => $num_tipo, 'js' => $js]);
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
        DB::table('usuario')->insert([
            'username' => $request->username,
            'pregunta' => $request->pregunta,
            'respuesta' => md5($request->respuesta),
            'tipo' => $request->tipo,
            'empleado' => $request->empleado
            ]);

        $cons = DB::table('usuario')->where('username', $request->username)->get();

        foreach ($cons as $cons2) {
            # code...
            $usuario=$cons2->id;
        }

        DB::table('password')->insert([
            'passw' => md5($request->password),
            'usuario' => $usuario
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
        DB::table('usuario')->where('id', $request->id)->update([
            'tipo' => $request->tipo
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
        DB::table('password')->where('usuario', $id)->update(['status' => 0]);
        DB::table('usuario')->where('id', $id)->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $cedula=$request->bs_cedula;
        $nombre=$request->bs_nombre;
        $apellido=$request->bs_apellido;
        $tipo=$request->bs_tipo;
        $username=$request->bs_username;
        $cons = DB::table('usuario')
                    ->select('usuario.*','empleado.*','persona.*','tipo_usuario.tipo as tip')
                    ->join('tipo_usuario', 'usuario.tipo', '=', 'tipo_usuario.id')
                    ->join('empleado', 'usuario.empleado', '=', 'empleado.id')
                    ->join('persona', 'empleado.persona', '=', 'persona.id')
                    ->where('usuario.status', '1')
                    ->where('cedula','like', "%$cedula%")
                    ->where('nombre','like', "%$nombre%")
                    ->where('apellido','like', "%$apellido%")
                    ->where('tipo_usuario.tipo','like', "%$tipo%")
                    ->where('username','like', "%$username%")
                    ->orderBy('username','asc');


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
                $username=$cons2->username;
                $nombre="$cons2->nombre $cons2->apellido";
                $email=$cons2->email;
                $tip=$cons2->tip;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$cedula</center></td>
                        <td><center>$username</center></td>
                        <td><center>$nombre</center></td>
                        <td><center>$email</center></td>
                        <td><center>$tip</center></td>
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
        $cons= DB::table('usuario')
                ->join('empleado', 'usuario.empleado', '=', 'empleado.id')
                ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
                ->join('persona', 'empleado.persona', '=', 'persona.id')
                ->where('usuario.id', $id)->get();
        foreach ($cons as $cons2) {
            # code...
            $cedula=$cons2->cedula;
            $nombre="$cons2->nombre $cons2->apellido";
            $cargo=$cons2->cargos;
            $tipo=$cons2->tipo;
            $username=$cons2->username;
            $pregunta=$cons2->pregunta;
            $empleado=$cons2->empleado;

        }
        return response()->json([
            'cedula'=>$cedula,
            'nombre'=>$nombre,
            'cargo'=>$cargo,
            'tipo'=>$tipo,
            'username'=>$username,
            'pregunta'=>$pregunta,
            'empleado'=>$empleado
        ]);


    }

    public function empleado(Request $request)
    {
        //
        $cedula=$request->cedula;
        $empleado="";
        $nombre="";
        $cargo="";
        $cons= DB::table('empleado')
                ->select('empleado.*', 'cargo.cargos', 'persona.cedula', 'persona.nombre', 'persona.apellido')
                ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
                ->join('persona', 'empleado.persona', '=', 'persona.id')
                ->where('cedula', $cedula);

        $cons1 = $cons->get();
        $num = $cons->count();
        foreach ($cons1 as $cons2) {
            # code...
            $empleado=$cons2->id;
            $cargo=$cons2->cargos;
            $nombre="$cons2->nombre $cons2->apellido";

        }
        return response()->json([
            'empleado'=>$empleado,
            'nombre'=>$nombre,
            'cargo'=>$cargo,
            'num'=>$num
        ]);


    }
}