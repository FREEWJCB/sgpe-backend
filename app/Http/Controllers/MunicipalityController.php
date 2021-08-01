<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeMunicipality;
use App\Http\Requests\Update\updateMunicipality;
use App\Models\Municipality;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cons = Municipality::select('municipality.*', 'state.states')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('municipality.status', '1')
                    ->orderBy('municipalitys','asc');
        $cons2 = $cons->get();
        $num = $cons->count();

        $state = State::where('status', '1')->orderBy('states','asc');
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
    public function store(storeMunicipality $request)
    {
        //
        $municipality = Municipality::where('municipalitys', $request->municipalitys);
        $num = $municipality->count();
        if ($num > 0) {
            # code...
            $municipality->update(['status' => 1]);
        }else{
            Municipality::create($request->all());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateMunicipality $request, Municipality $Municipality)
    {
        //
        $municipality = Municipality::where([['municipalitys', $request->municipalitys],['status', 0]]);
        $num = $municipality->count();
        $id=0;
        if ($num > 0) {
            $municipality1 = $municipality->get();
            foreach ($municipality1 as $municipality2) {
                # code...
                $id = $municipality2->id;
            }
            $municipality->update(['status' => 1]);
            $Municipality->update(['status' => 0]);
        }else{
            $Municipality->update($request->all());
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
    public function destroy(Municipality $Municipality)
    {
        //
        $Municipality->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $state=$request->bs_state;
        $municipalitys=$request->bs_municipalitys;
        $cons = Municipality::select('municipality.*', 'state.states')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where([
                        ['municipalitys','like', "%$municipalitys%"],
                        ['state', 'like', "%$state%"],
                        ['municipality.status', '1']
                    ])->orderBy('municipalitys','asc');

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
        $municipality = Municipality::find($request->id);

        return response()->json([
            'state'=> $municipality->state,
            'municipalitys'=>$municipality->municipalitys
        ]);


    }
}
