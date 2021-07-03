<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeTipo_Discapacidad;
use App\Http\Requests\Update\updateTipo_Discapacidad;
use App\Models\Tipo_discapacidad;
use Illuminate\Http\Request;

class Tipo_DiscapacidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = Tipo_discapacidad::where('status', '1')->orderBy('tipo','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.tipo_discapacidad',['cons' => $cons2, 'num' => $num, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeTipo_Discapacidad $request)
    {
        //
        $tipo_discapacidad = Tipo_Discapacidad::where('tipo', $request->tipo);
        $num = $tipo_discapacidad->count();
        if ($num > 0) {
            # code...
            $tipo_discapacidad->update(['status' => 1]);
        }else{
            Tipo_Discapacidad::create($request->all());
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateTipo_Discapacidad $request, Tipo_discapacidad $Tipo_Discapacidad)
    {
        //
        $tipo_discapacidad = Tipo_Discapacidad::where([['tipo', $request->tipo],['status', 0]]);
        $num = $tipo_discapacidad->count();
        $id=0;
        if ($num > 0) {
            $tipo_discapacidad1 = $tipo_discapacidad->get();
            foreach ($tipo_discapacidad1 as $tipo_discapacidad2) {
                # code...
                $id = $tipo_discapacidad2->id;
            }
            $tipo_discapacidad->update(['status' => 1]);
            $Tipo_Discapacidad->update(['status' => 0]);
        }else{
            $Tipo_Discapacidad->update($request->all());
        }

        return response()->json([
            'i' => $num,
            'id' => $id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipo_discapacidad $Tipo_Discapacidad)
    {
        //
        $Tipo_Discapacidad->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $tipo=$request->bs_tipo;
        $cons = Tipo_discapacidad::where([
            ['status', '1'],
            ['tipo','like', "%$tipo%"]
        ])->orderBy('tipo','asc');
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
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$tipo</center></td>
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
        $tipo_discapacidad = Tipo_discapacidad::find($request->id);

        return response()->json([
            'tipo'=>$tipo_discapacidad->tipo
        ]);


    }
}
