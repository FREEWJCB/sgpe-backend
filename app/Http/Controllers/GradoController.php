<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeGrado;
use App\Http\Requests\Update\updateGrado;
use App\Models\Grado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = Grado::where('status', '1')->orderBy('grados','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.grado',['cons' => $cons2, 'num' => $num, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeGrado $request)
    {
        //
        $grado = Grado::where('grados', $request->grados);
        $num = $grado->count();
        if ($num > 0) {
            # code...
            $grado->update(['status' => 1]);
        }else{
            Grado::create($request->all());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateGrado $request, Grado $Grado)
    {
        //
        $grado = Grado::where([['grados', $request->grados],['status', 0]]);
        $num = $grado->count();
        $id=0;
        if ($num > 0) {
            $grado1 = $grado->get();
            foreach ($grado1 as $grado2) {
                # code...
                $id = $grado2->id;
            }
            $grado->update(['status' => 1]);
            $Grado->update(['status' => 0]);
        }else{
            $Grado->update($request->all());
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
    public function destroy(Grado $Grado)
    {
        //
        $Grado->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $grados=$request->bs_grados;
        $cons= Grado::where([
                ['status', '1'],
                ['grados','like', "%$grados%"]
            ])->orderBy('grados','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $grados=$cons2->grados;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$grados</center></td>
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
        $grado= Grado::find($request->id);

        return response()->json([
            'grados'=>$grado->grados
        ]);


    }
}
