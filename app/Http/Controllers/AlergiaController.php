<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeAlergia;
use App\Http\Requests\Update\updateAlergia;
use App\Models\Alergia;
use App\Models\Tipo_alergia;
use Illuminate\Http\Request;
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
        $cons = Alergia::select('alergia.*', 'tipo_alergia.tipo as tip')
                ->join('tipo_alergia', 'alergia.tipo', '=', 'tipo_alergia.id')
                ->where('alergia.status', '1')
                ->orderBy('alergias','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $tipo_alergia = Tipo_alergia::where('status', '1')->orderBy('tipo','asc');
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
    public function store(storeAlergia $request)
    {
        //
        $alergia = Alergia::where('alergias', $request->alergias);
        $num = $alergia->count();
        if ($num > 0) {
            # code...
            $alergia->update(['status' => 1]);
        }else{
            Alergia::create($request->all());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateAlergia $request, Alergia $Alergium)
    {
        //
        $alergia = Alergia::where([['alergias', $request->alergias],['status', 0]]);
        $num = $alergia->count();
        $id=0;
        if ($num > 0) {
            $alergia1 = $alergia->get();
            foreach ($alergia1 as $alergia2) {
                # code...
                $id = $alergia2->id;
            }
            $alergia->update(['status' => 1]);
            $Alergium->update(['status' => 0]);
        }else{
            $Alergium->update($request->all());
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
    public function destroy(Alergia $Alergium)
    {
        //
        $Alergium->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $tipo=$request->bs_tipo;
        $alergias=$request->bs_alergias;
        $cons = Alergia::select('alergia.*', 'tipo_alergia.tipo as tip')
                ->join('tipo_alergia', 'alergia.tipo', '=', 'tipo_alergia.id')
                ->where([
                    ['alergia.status', '1'],
                    ['alergia.tipo', 'like', "%$tipo%"],
                    ['alergias','like', "%$alergias%"]
                    ])
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
        $alergia = Alergia::find($request->id);

        return response()->json([
            'tipo'=>$alergia->tipo,
            'alergias'=>$alergia->alergias,
            'descripcion'=>$alergia->descripcion
        ]);


    }
}
