<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AlergiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('alergia')
                    ->select('alergia.*', 'tipo_alergia.tipo as tip')
                    ->join('tipo_alergia', 'alergia.tipo', '=', 'tipo_alergia.id')
                    ->where('alergia.status', '1')
                    ->orderBy('alergias','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $tipo_alergia = DB::table('tipo_alergia')->where('status', '1')->orderBy('tipo','asc');
        $tipo_alergia2 = $tipo_alergia->get();
        $num_tipo = $tipo_alergia->count();

        return view('view.alergia',['cons' => $cons2, 'num' => $num, 'num_tipo' => $num_tipo, 'tipo_alergia' => $tipo_alergia2, 'js' => $js]);
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
        DB::table('alergia')->insert([
            'tipo' => $request->tipo,
            'alergias' => $request->alergias,
            'descripcion' => $request->descripcion
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
        DB::table('alergia')->where('id', $request->id)->update([
            'tipo' => $request->tipo,
            'alergias' => $request->alergias,
            'descripcion' => $request->descripcion
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
        DB::table('alergia')->where('id', $id)->delete();
    }

    public function cargar(Request $request)
    {
        $cat="";
        $tipo=$request->bs_tipo;
        $alergias=$request->bs_alergias;
        $cons = DB::table('alergia')
                ->select('alergia.*', 'tipo_alergia.tipo as tip')
                ->join('tipo_alergia', 'alergia.tipo', '=', 'tipo_alergia.id')
                ->where('alergia.tipo', 'like', "%$tipo%")
                ->where('alergias','like', "%$alergias%")
                ->where('alergia.status', '1')
                ->orderBy('alergias','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $tip=$cons2->tip;
                $alergias=$cons2->alergias;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$tip</center></td>
                        <td><center>$alergias</center></td>
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
            $cat="<tr><td colspan='4'>No hay datos registrados</td></tr>";
        }
        return response()->json([
            'catalogo'=>$cat
        ]);

    }

    public function mostrar(Request $request)
    {
        //
        $id=$request->id;
        $cons= DB::table('alergia')
                 ->where('id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $tipo=$cons2->tipo;
            $alergias=$cons2->alergias;
            $descripcion=$cons2->descripcion;

        }
        return response()->json([
            'tipo'=>$tipo,
            'alergias'=>$alergias,
            'descripcion'=>$descripcion
        ]);


    }
}