<?php

namespace App\Http\Controllers;

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
  public function index()
  {
    //
    $res = State::where('status', '1')->orderBy('states', 'asc');
    $res = $res->get();
    //$num = $cons->count();
    return response()->json($res, 200);
  }

  /**
   * Show the profile for the given user.
   *
   * @param  int  $id
   * @return StateCollection
   */
  public function show($id)
  {
    return response()->json(State::findOrFail($id), 200);
    //return new StateResource(State::find($id));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if ($request->has(['estado'])) {
      $res = State::updateOrCreate(['states' => $request->estado]);
      return response()->json($res, 202);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
    //$state = State::where([['states', $request->states], ['status', 0]]);
    //$num = $state->count();
    //$id = 0;
    //if ($num > 0) {
      //$state1 = $state->get();
      //foreach ($state1 as $state2) {
        //# code...
        //$id = $state2->id;
      //}
      //$state->update(['status' => 1]);
      //$State->update(['status' => 0]);
    //} else {
      //$State->update($request->all());
    //}

    //return response()->json([
      //'i' => $num,
      //'id' => $id
    //]);
    $res = State::find($id);
    $res->states = $request->estado;
    $res->save();
    return response()->json($res, 200);
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
    if (DB::table('municipality')->where('state', $id)->get()->count()) {

      $res = State::find($id);
      if ($res->status == 1) {
        $res->status = 0;
      } else {
        $res->status = 1;
      }
      $res->save();
    } else {

      $res = State::find($id);
      $res->delete();
    }

    return response()->json($res, 201);
  }
}
