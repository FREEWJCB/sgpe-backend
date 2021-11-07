<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\State;
use App\Http\Requests\Municipality as Validation;

class MunicipalityController extends Controller
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
     * @param string page
     * @param string limit
     * @return \Illuminate\Http\Response
     */
    public function index($page, $limit)
    {
        //
        $cons = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
                    ->join('state', 'municipality.state', '=', 'state.id')
                    ->where('municipality.status', '1');
    $count = $cons->count();
    // paginación
    $cons = $cons
      ->skip($skip)
      ->limit($limit)
      ->orderBy('municipality.id', 'desc');
    $cons2 = $cons->get();
    //$num = $cons->count();
    //
    $res = [
      'data' => $cons2,
      'meta' => [
        'all' => $count,
        'next' => ($limit != count($cons2)) ? $page : $page + 1,
        'prev' => ($page != 1) ? $page - 1 : $page,
        'first' => 1,
        'last' => ceil($count / $limit),
        'allData' => count($cons2),
        'skip' => $skip
      ],
    ];

        //$state = State::whermunicipalitystatus', '1')->orderBy('states','asc');
        //$state2 = $state->get();
        //$num_state = $state->count();

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
        $res = Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
                    ->join('state', 'municipality.state', '=', 'state.id')
      ->where('municipality.status', '=', '1')
      ->where('municipality.municipalitys', 'like', '%' . $busqueda . '%')
      ->orWhere('state.states', 'like', '%' . $busqueda . '%')
                    ->orderBy('municipalitys','desc');
    $res = $res->get();
    //$num = $cons->count();
    return response()->json($res, 200);
  }
  /**
   * Show the profile for the given user.
   *
   * @param  int  $id
   * @return Municipality
   */
  public function show($id)
  {
    return response()->json(Municipality::select('municipality.id', 'municipality.municipalitys', 'municipality.state as state_id', 'municipality.status', 'municipality.created_at', 'municipality.updated_at', 'state.states')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('municipality.status', '1')
      ->where('municipality.id', $id)
      ->get(), 200);
    //return new StateResource(State::find($id));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  App\Http\Requests\Municipality as Validation
   * @return \Illuminate\Http\Response
   */
  public function store(Validation $request)
  {
    //
    if ($request->has(['estado_id', 'municipio'])){
      $res = Municipality::updateOrCreate([
        'municipalitys' => $request->municipio,
        'state' => $request->estado_id
      ]);
      return response()->json($res, 202);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  App\Http\Requests\Municipality as Validation
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Validation $request, $id)
  {
    //
    $res = Municipality::find($id);
    $res->municipalitys = $request->municipio;
    $res->state = $request->estado_id;
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
    $res = Municipality::find($id);
    $res->status = "0";
    $res->save();
    return response()->json($res, 202);
  }
}
