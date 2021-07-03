<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class cosmeticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('cosmeticos')->where('status', '1')->orderBy('cosmetico','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.cosmetico',['cons' => $cons2, 'num' => $num, 'js' => $js]);
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
        DB::table('cosmeticos')->insert([
            'marca' => $request->marca,
            'tipo' => $request->tipo,
            'modelo' => $request->modelo,
            'descripcion' => $request->descripcion,
            'cosmetico' => $request->cosmetico
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
        DB::table('cosmeticos')->where('id', $request->id)->update([
        'marca' => $request->marca,
        'tipo' => $request->tipo,
        'modelo' => $request->modelo,
        'descripcion' => $request->descripcion,
        'cosmetico' => $request->cosmetico
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
        DB::table('cosmeticos')->where('id', $id)->delete();
    }

    public function cargar(Request $request)
    {
        $cat="";
        $tipo=$request->bs_tipo;
        $marca=$request->bs_marca;
        $modelo=$request->bs_modelo;
        $cosmetico=$request->bs_cosmetico;
        $cons= DB::table('cosmeticos')
                 ->where('tipo','like', "%$tipo%")
                 ->where('marca','like', "%$marca%")
                 ->where('modelo','like', "%$modelo%")
                 ->where('cosmetico','like', "%$cosmetico%")
                 ->where('status', '1')
                 ->orderBy('cosmetico','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $tipo=$cons2->tipo;
                $marca=$cons2->marca;
                $modelo=$cons2->modelo;
                $cosmetico=$cons2->cosmetico;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$tipo</center></td>
                        <td><center>$marca</center></td>
                        <td><center>$modelo</center></td>
                        <td><center>$cosmetico</center></td>
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
            $cat="<tr><td colspan='6'>No hay datos registrados</td></tr>";
        }
        return response()->json([
            'catalogo'=>$cat
        ]);

    }

    public function mostrar(Request $request)
    {
        //
        $id=$request->id;
        $cons= DB::table('cosmeticos')
                 ->where('id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $tipo=$cons2->tipo;
            $marca=$cons2->marca;
            $modelo=$cons2->modelo;
            $descripcion=$cons2->descripcion;
            $cosmetico=$cons2->cosmetico;

        }
        return response()->json([
            'tipo'=>$tipo,
            'marca'=>$marca,
            'modelo'=>$modelo,
            'descripcion'=>$descripcion,
            'cosmetico'=>$cosmetico
        ]);


    }
}
