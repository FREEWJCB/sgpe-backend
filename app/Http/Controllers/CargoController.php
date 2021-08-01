<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Store\storeCargo;
use App\Http\Requests\Update\updateCargo;
use App\Models\Cargo;
// use Illuminate\Support\Facades\DB;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cons = Cargo::where('status', '1')->orderBy('cargos','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.cargo',['cons' => $cons2, 'num' => $num, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeCargo $request)
    {
        //
        $cargo = Cargo::where('cargos', $request->cargos);
        $num = $cargo->count();
        if ($num > 0) {
            # code...
            $cargo->update(['status' => 1]);
        }else{
            Cargo::create($request->all());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateCargo $request, Cargo $Cargo)
    {
        //
        $cargo = Cargo::where([['cargos', $request->cargos],['status', 0]]);
        $num = $cargo->count();
        $id=0;
        if ($num > 0) {
            $cargo1 = $cargo->get();
            foreach ($cargo1 as $cargo2) {
                # code...
                $id = $cargo2->id;
            }
            $cargo->update(['status' => 1]);
            $Cargo->update(['status' => 0]);
        }else{
            $Cargo->update($request->all());
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
    public function destroy(Cargo $Cargo)
    {
        //
        // DB::table('cargo')->where('id', $Cargo->id)->update(['status' => 0]);
        $Cargo->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $cargos=$request->bs_cargos;
        $cons = Cargo::where([
            ['status', '1'],
            ['cargos','like', "%$cargos%"]
            ])->orderBy('cargos','asc');

        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $cargos=$cons2->cargos;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
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
            $cat="<tr><td colspan='3'>No hay datos registrados</td></tr>";
        }
        return response()->json([
            'catalogo'=>$cat
        ]);

    }

    public function mostrar(Request $request)
    {
        //
        $cargo = Cargo::find($request->id);

        return response()->json([
            'cargos'=>$cargo->cargos
        ]);


    }
}
