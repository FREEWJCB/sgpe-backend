<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = DB::table('municipality')
                    ->select('municipality.*', 'state.states')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('municipality.status', '1')
                    ->orderBy('municipalitys','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $state = DB::table('state')->where('status', '1')->orderBy('states','asc');
        $state2 = $state->get();
        $num_state = $state->count();

        return view('view.municipality',['cons' => $cons2, 'num' => $num, 'num_state' => $num_state, 'state' => $state2, 'js' => $js]);
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
        DB::table('municipality')->insert([
            'state' => $request->state,
            'municipalitys' => $request->municipalitys
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
        DB::table('municipality')->where('id', $request->id)->update([
            'state' => $request->state,
            'municipalitys' => $request->municipalitys
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
        DB::table('municipality')->where('id', $id)->delete();
    }

    public function cargar(Request $request)
    {
        $cat="";
        $state=$request->bs_state;
        $municipalitys=$request->bs_municipalitys;
        $cons = DB::table('municipality')
                ->select('municipality.*', 'state.states')
                ->join('state', 'municipality.state', '=', 'state.id')
                ->where('state', 'like', "%$state%")
                ->where('municipalitys','like', "%$municipalitys%")
                ->where('municipality.status', '1')
                ->orderBy('municipalitys','asc');
        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $states=$cons2->states;
                $municipalitys=$cons2->municipalitys;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$states</center></td>
                        <td><center>$municipalitys</center></td>
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
        $cons = DB::table('municipality')->where('id', $id)->get();

        foreach ($cons as $cons2) {
            # code...
            $state=$cons2->state;
            $municipalitys=$cons2->municipalitys;

        }
        return response()->json([
            'state'=> $state,
            'municipalitys'=>$municipalitys
        ]);


    }
}