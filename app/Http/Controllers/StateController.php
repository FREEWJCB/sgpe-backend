<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\State as Validation;

class StateController extends Controller
{
  /**
   * Create a new AuthController
   *
   * @return void
   * */
  public function __construct()
  {
   $this->middleware('auth:api');
  }

  /**
   * Display a listing of the resource.
   *
   * @param string busqueda
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $res = State::where('status', '1')
      ->orderBy('id', 'desc');
    $res = $res->get();
    //$num = $cons->count();
    return response()->json($res, 200);
  }

  /**
   * Display a listing of the resource.
   *
   * @param string busqueda
   * @return \Illuminate\Http\Response
   */
  public function search($busqueda)
  {
    //
    $res = State::where([
      ['status', '=', '1'],
      ['states', 'like', '%' . $busqueda . '%']
    ]
    )->orderBy('id', 'desc');
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
    return response()->json(State::findOrFail($id), 202);
    //return new StateResource(State::find($id));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  App\Http\Requests\State as Validation
   * @return \Illuminate\Http\Response
   */
  public function store(Validation $request)
  {
    $res = State::updateOrCreate(['states' => $request->estado]);
    return response()->json($res, 201);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  App\Http\Requests\State as Validation
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Validation $request, $id)
  {
    //
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

    return response()->json($res, 202);
  }
}
