<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaestroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($maestro, $js="AJAX")
    {
        //
        if($maestro=="tipos"){
            $atributo="tipo";
        }
        $cons = DB::table($maestro)
                  ->select('id', "$atributo as dato")
                  ->where('status', '1')
                  ->orderBy('dato','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.maestro',['maestro' => $maestro, 'cons' => $cons2, 'num' => $num, 'js' => $js]);
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
        $maestro=$request->maestro;
        $atributo=$request->atributo;
        $dato=$request->dato;

        DB::table($maestro)->insert([$atributo => $dato]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $maestro=$request->maestro;
        $atributo=$request->atributo;
        $dato=$request->dato;
        $id=$request->id;
        DB::table($maestro)->where('id', $id)->update([$atributo => $dato]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$maestro)
    {
        //
        DB::table($maestro)->where('id', $id)->delete();
    }

    public function cargar(Request $request)
    {
        $cat="";
        $maestro=$request->maestro;
        $atributo=$request->atributo;
        $dato=$request->bs_dato;

        $cons= DB::table($maestro)
                 ->select('id', "$atributo as dato")
                 ->where('dato','like', "%$dato%")
                 ->where('status', '1')
                 ->orderBy('dato','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $dato=$cons2->dato;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$dato</center></td>
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
        $maestro=$request->maestro;
        $atributo=$request->atributo;

        $cons= DB::table($maestro)
                 ->select("$atributo as dato")
                 ->where('id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $dato=$cons2->dato;

        }
        return response()->json([
            'dato'=>$dato
        ]);


    }
}