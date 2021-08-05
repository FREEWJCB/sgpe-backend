<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\storeRepresentante;
use App\Http\Requests\Update\updateRepresentante;
use App\Models\Ocupacion_laboral;
use App\Models\Persona;
use App\Models\Representante;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Repesentante as Validation;

class RepresentanteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $cons = Representante::select('representante.*', 'ocupacion_laboral.labor', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
      ->join('ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id')
      ->join('persona', 'representante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('representante.status', '1')->orderBy('cedula', 'asc');
    $cons2 = $cons->get();
    //$num = $cons->count();

    return response()->json($cons2, 200);
  }

  /**
   * Show the profile for the given user.
   *
   * @param  int  $id
   * @return Municipality
   */
  public function show($id)
  {
    $representante = Representante::select('representante.*', 'ocupacion_laboral.labor', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
      ->join('ocupacion_laboral', 'representante.ocupacion_laboral', '=', 'ocupacion_laboral.id')
      ->join('persona', 'representante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('representante.id', $id)
      ->get();
    if (Representante::find($id)) {
      return response()->json($representante, 200);
    } else {
      return response()->json([
        "error" => "No se encontro el Representante",
        "code" => 404
      ], 404);
    }
    //return new StateResource(State::find($id));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  App\Http\Request\Estudiante $request
   * @return \Illuminate\Http\Response
   */
  public function store(Validation $request)
  {
    //
    $persona = Persona::create([
        'cedula' => $request->cedula,
        'nombre' => $request->nombre, 
        'apellido' => $request->apellido,
        'sex' => $request->sex,
        'telefono' => $request->telefono,
        'direccion' => $request->direccion,
        'municipality' => $request->municipio
    ]);

    $representante = Representante::updateOrCreate([
      'persona' => Persona::find($persona->id)->id,
      'ocupacion_laboral' => $request->ocupacion_laboral,
    ]);

    return response()->json([
        'id' => $representante->id,
        'cedula' => $persona->cedula,
        'nombre' => $persona->nombre, 
        'apellido' => $persona->apellido,
        'sex' => $persona->sex,
        'telefono' => $persona->telefono,
        'direccion' => $persona->direccion,
        'municipio' => $persona->municipio,
        'ocupacion_laboral' => $representante->ocupacion_laboral
    ], 202);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  App\Http\Request\Estudiante  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Validation $request, $id)
  {
    //
    $representante = Representante::find($id);
    $persona = Persona::find($representante->persona);
    $persona->cedula = $request->cedula;
    $persona->nombre = $request->nombre;
    $persona->apellido = $request->apellido;
    $persona->sex = $request->sex;
    $persona->telefono = $request->telefono;
    $persona->direccion = $request->direccion;
    $persona->municipality = $request->municipio;
    $representante->ocupacion_laboral = $request->ocupacion_laboral;
    $persona->save();
    $representante->save();

    return response()->json([
        'id' => $representante->id,
        'cedula' => $persona->cedula,
        'nombre' => $persona->nombre, 
        'apellido' => $persona->apellido,
        'sex' => $persona->sex,
        'telefono' => $persona->telefono,
        'direccion' => $persona->direccion,
        'municipio' => $persona->municipality,
        'ocupacion_laboral' => $representante->ocupacion_laboral,
    ], 200);
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
    $representante = Representante::find($id);
    $representante->status = 0;
    $representante->save();

    $persona = Persona::find($representante->persona);
    $persona->status = 0;

    return response()->noContent(204);
  }
}
