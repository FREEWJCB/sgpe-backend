<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeParroquia;
use App\Http\Requests\Update\updateParroquia;
use App\Models\Parroquia;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParroquiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cons = Parroquia::select('parroquia.*', 'municipality.municipalitys', 'state.states')
                    ->join([
                        ['municipality', 'parroquia.municipality', '=', 'municipality.id'],
                        ['state', 'municipality.state', '=', 'state.id']
                    ])->where('parroquia.status', '1')->orderBy('parroquias','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $state = State::where('status', '1')->orderBy('states','asc');
        $state2 = $state->get();
        $num_state = $state->count();

        return view('view.parroquia',['cons' => $cons2, 'num' => $num, 'num_state' => $num_state, 'state' => $state2, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeParroquia $request)
    {
        //
        $parroquia = Parroquia::where('parroquias', $request->parroquias);
        $num = $parroquia->count();
        if ($num > 0) {
            # code...
            $parroquia->update(['status' => 1]);
        }else{
            Parroquia::create($request->all());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateParroquia $request, Parroquia $Parroquia)
    {
        //
        $parroquia = Parroquia::where([['parroquias', $request->parroquias],['status', 0]]);
        $num = $parroquia->count();
        $id=0;
        if ($num > 0) {
            $parroquia1 = $parroquia->get();
            foreach ($parroquia1 as $parroquia2) {
                # code...
                $id = $parroquia2->id;
            }
            $parroquia->update(['status' => 1]);
            $Parroquia->update(['status' => 0]);
        }else{
            $Parroquia->update($request->all());
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
    public function destroy(Parroquia $Parroquia)
    {
        //
        $Parroquia->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $state=$request->bs_state;
        $municipality=$request->bs_municipality;
        $parroquias=$request->bs_parroquias;
        $cons = Parroquia::select('parroquia.*', 'municipality.municipalitys', 'state.states')
                    ->join([
                        ['municipality', 'parroquia.municipality', '=', 'municipality.id'],
                        ['state', 'municipality.state', '=', 'state.id']
                    ])->where([
                        ['parroquias','like', "%$parroquias%"],
                        ['state', 'like', "%$state%"],
                        ['municipality', 'like', "%$municipality%"],
                        ['parroquia.status', '1']
                    ])->orderBy('parroquias','asc');

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
                $parroquias=$cons2->parroquias;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$states</center></td>
                        <td><center>$Municipalitys</center></td>
                        <td><center>$parroquias</center></td>
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
        $parroquia = Parroquia::find($request->id)->join('municipality', 'parroquia.municipality', '=', 'municipality.id');

        return response()->json([
            'state'=> $parroquia->state,
            'municipality'=> $parroquia->municipality,
            'parroquias'=>$parroquia->parroquias
        ]);


    }
}
