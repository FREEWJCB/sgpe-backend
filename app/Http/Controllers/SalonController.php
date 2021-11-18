<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeSalon;
use App\Http\Requests\Update\updateSalon;
use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cons = Salon::where('status', '1')->orderBy('salones','asc');
        $cons2 = $cons->get();
        //$num = $cons->count();
        return response()->json($cons2, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeSalon $request)
    {
        //
        $salon = Salon::where('salones', $request->salones);
        $num = $salon->count();
        if ($num > 0) {
            # code...
            $salon->update(['status' => 1]);
        }else{
            Salon::create($request->all());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateSalon $request, Salon $Salon)
    {
        //
        $salon = Salon::where([['salones', $request->salones],['status', 0]]);
        $num = $salon->count();
        $id=0;
        if ($num > 0) {
            $salon1 = $salon->get();
            foreach ($salon1 as $salon2) {
                # code...
                $id = $salon2->id;
            }
            $salon->update(['status' => 1]);
            $Salon->update(['status' => 0]);
        }else{
            $Salon->update($request->all());
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
    public function destroy(Salon $Salon)
    {
        //
        $Salon->update(['status' => 0]);
    }
}
