<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeState;
use App\Http\Requests\Update\updateState;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($js="AJAX")
    {
        //
        $cons = State::where('status', '1')->orderBy('states','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.state',['cons' => $cons2, 'num' => $num, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeState $request)
    {
        //
        $state = State::where('states', $request->states);
        $num = $state->count();
        if ($num > 0) {
            # code...
            $state->update(['status' => 1]);
        }else{
            State::create($request->all());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateState $request, State $State)
    {
        //
        $state = State::where([['states', $request->states],['status', 0]]);
        $num = $state->count();
        $id=0;
        if ($num > 0) {
            $state1 = $state->get();
            foreach ($state1 as $state2) {
                # code...
                $id = $state2->id;
            }
            $state->update(['status' => 1]);
            $State->update(['status' => 0]);
        }else{
            $State->update($request->all());
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
    public function destroy(State $State)
    {
        //
        $State->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $states=$request->bs_states;
        $cons = State::where([
            ['status', '1'],
            ['states','like', "%$states%"]
        ])->orderBy('states','asc');
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
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$states</center></td>
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
        $state= State::find($request->id);

        return response()->json([
            'states'=>$state->states
        ]);


    }
}
