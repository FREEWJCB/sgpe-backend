<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ocupacion_LaboralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('ocupacion_laboral')->where('status', '1')->orderBy('labor','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.ocupacion_laboral',['cons' => $cons2, 'num' => $num, 'js' => $js]);
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
        DB::table('ocupacion_laboral')->insert(['labor' => $request->labor]);
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
        DB::table('ocupacion_laboral')->where('id', $request->id)->update(['labor' => $request->labor]);

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
        DB::table('ocupacion_laboral')->where('id', $id)->delete();
    }

    public function cargar(Request $request)
    {
        $cat="";
        $labor=$request->bs_labor;
        $cons= DB::table('ocupacion_laboral')
                 ->where('labor','like', "%$labor%")
                 ->where('status', '1')
                 ->orderBy('labor','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $labor=$cons2->labor;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
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
        $cons= DB::table('ocupacion_laboral')
                 ->where('id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $labor=$cons2->labor;

        }
        return response()->json([
            'labor'=>$labor
        ]);


    }
}
