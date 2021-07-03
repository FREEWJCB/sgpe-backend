<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Store\storeParentesco;
use App\Http\Requests\Update\updateParentesco;
use App\Models\Parentesco;
// use Illuminate\Support\Facades\DB;

class ParentescoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cons = Parentesco::where('status', '1')->orderBy('parentescos','asc');
        $cons2 = $cons->get();
        $num = $cons->count();
        return view('view.parentesco',['cons' => $cons2, 'num' => $num, 'js' => $js]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeParentesco $request)
    {
        //
        $parentesco = Parentesco::where('parentescos', $request->parentescos);
        $num = $parentesco->count();
        if ($num > 0) {
            # code...
            $parentesco->update(['status' => 1]);
        }else{
            Parentesco::create($request->all());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateParentesco $request, Parentesco $Parentesco)
    {
        //
        $parentesco = Parentesco::where([['parentescos', $request->parentescos],['status', 0]]);
        $num = $parentesco->count();
        $id=0;
        if ($num > 0) {
            $parentesco1 = $parentesco->get();
            foreach ($parentesco1 as $parentesco2) {
                # code...
                $id = $parentesco2->id;
            }
            $parentesco->update(['status' => 1]);
            $Parentesco->update(['status' => 0]);
        }else{
            $Parentesco->update($request->all());
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
    public function destroy(Parentesco $Parentesco)
    {
        //
        // DB::table('parentesco')->where('id', $Parentesco->id)->update(['status' => 0]);
        $Parentesco->update(['status' => 0]);
    }

    public function cargar(Request $request)
    {
        $cat="";
        $parentescos=$request->bs_parentescos;
        $cons = Parentesco::where([
            ['status', '1'],
            ['parentescos','like', "%$parentescos%"]
            ])->orderBy('parentescos','asc');

        $cons1 = $cons->get();
        $num = $cons->count();
        if ($num>0) {
            # code...
            $i=0;
            foreach ($cons1 as $cons2) {
                # code...
                $i++;
                $id=$cons2->id;
                $parentescos=$cons2->parentescos;
                $cat.="<tr>
                        <th scope='row'><center>$i</center></th>
                        <td><center>$parentescos</center></td>
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
        $parentesco = Parentesco::find($request->id);

        return response()->json([
            'parentescos'=>$parentesco->parentescos
        ]);


    }
}
