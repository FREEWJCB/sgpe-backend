<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class combo extends Controller
{

    public function store(Request $request)
    {
        //
        $id=$request->id;
        $opt=$request->opt;
        $cons=$request->cons;
        $dat=$request->dat;
        $tabla=$request->tabla;
        $columna=$request->columna;
        $dato=$request->dato;

        $combo = DB::table($tabla)
                ->select("$dato as dato", 'id')
                ->where('status', '1')
                ->orderBy($dato,'asc');

        if($id!="null"){
            $combo=$combo->where($columna, $id);
        }
        $combo1 = $combo->get();
        $num = $combo->count();
        if($cons==0){
            $select="<option value=''>Seleccione un $opt</option>";
        }elseif($cons==1){
            $select="<option disabled value='null'>Seleccione un $opt</option>";
        }else{
            $select="<option disabled value='null' selected>Seleccione un $opt</option>";
        }
        if ($num>0) {
            # code...
            foreach ($combo1 as $combo2) {
                # code...
                $value=$combo2->id;
                $option=$combo2->dato;

                if($dat == $value){
                    $select.="<option value='$value' selected>$option</option>";
                }else{
                    $select.="<option value='$value'>$option</option>";
                }
            }
        }
        return response()->json([
            'combo'=>$select
        ]);
    }


}