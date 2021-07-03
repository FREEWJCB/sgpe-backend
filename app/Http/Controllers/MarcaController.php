<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('marcas')->where('status', '1')->orderBy('marca','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.marca',['cons' => $cons2, 'num' => $num, 'js' => $js]);

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
        DB::table('marcas')->insert(['marca' => $request->marca]);

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
        DB::table('marcas')->where('id', $request->id)->update(['marca' => $request->marca]);
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
        DB::table('marcas')->where('id', $id)->delete();
    }

    public function cargar(Request $request)
    {
        $cat="";
        $marca=$request->bs_marca;
        $cons= DB::table('marcas')
                 ->where('marca','like', "%$marca%")
                 ->where('status', '1')
                 ->orderBy('marca','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $marca=$cons2->marca;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$marca</center></td>
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
            $cat="<tr><td colspan='3'>No hay datos registrados</td></tr>";
        }
        return response()->json([
            'catalogo'=>$cat
        ]);

    }

    public function mostrar(Request $request)
    {
        //
        $id=$request->id;
        $cons= DB::table('marcas')
                 ->where('id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $marca=$cons2->marca;

        }
        return response()->json([
            'marca'=>$marca
        ]);


    }
}
