<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeOcupacion_Laboral;
use App\Http\Requests\Update\updateOcupacion_Laboral;
use App\Models\Ocupacion_laboral;
use Illuminate\Http\Request;

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
        $cons = Ocupacion_laboral::where('status', '1')->orderBy('labor','asc');
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
    public function store(storeOcupacion_Laboral $request)
    {
        //
        $ocupacion_laboral = Ocupacion_laboral::where('labor', $request->labor);
        $num = $ocupacion_laboral->count();
        if ($num > 0) {
            # code...
            $ocupacion_laboral->update(['status' => 1]);
        }else{
            Ocupacion_laboral::create($request->all());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateOcupacion_Laboral $request, Ocupacion_laboral $Ocupacion_Laboral)
    {
        //
        $ocupacion_laboral = Ocupacion_laboral::where([['labor', $request->labor],['status', 0]]);
        $num = $ocupacion_laboral->count();
        $id=0;
        if ($num > 0) {
            $ocupacion_laboral1 = $ocupacion_laboral->get();
            foreach ($ocupacion_laboral1 as $ocupacion_laboral2) {
                # code...
                $id = $ocupacion_laboral2->id;
            }
            $ocupacion_laboral->update(['status' => 1]);
            $Ocupacion_Laboral->update(['status' => 0]);
        }else{
            $Ocupacion_Laboral->update($request->all());
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
    public function destroy(Ocupacion_laboral $Ocupacion_Laboral)
    {
        //
        $Ocupacion_Laboral->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $labor=$request->bs_labor;
        $cons = Ocupacion_laboral::where([
            ['status', '1'],
            ['labor','like', "%$labor%"]
        ])->orderBy('labor','asc');

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
        $ocupacion_laboral= Ocupacion_laboral::find($request->id);

        return response()->json([
            'labor'=>$ocupacion_laboral->labor
        ]);


    }
}
