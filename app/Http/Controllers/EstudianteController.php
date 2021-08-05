<?php

namespace App\Http\Controllers;

use App\Http\Requests\Estudiante as Validation;
use App\Models\Estudiante;
use App\Models\Persona;

class EstudianteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $cons = Estudiante::select('estudiante.*', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'municipality.municipalitys', 'state.states')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('estudiante.status', '1')
      ->orderBy('cedula', 'asc');
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
    $estudiante = Estudiante::select('estudiante.*', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'municipality.municipalitys', 'state.states')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('estudiante.id', $id)
      ->get();
    if (Estudiante::find($id)) {
      return response()->json($estudiante, 200);
    } else {
      return response()->json([
        "error" => "No se encontro el Estudiante",
        "code" => 404
      ], 404);
    }
    //return new StateResource(State::find($id));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Validation $request)
  {
    $persona = Persona::create([
        'cedula' => $request->cedula,
        'nombre' => $request->nombre, 
        'apellido' => $request->apellido,
        'sex' => $request->sex,
        'telefono' => $request->telefono,
        'direccion' => $request->direccion,
        'municipality' => $request->municipio,
    ]);

    $estudiante = Estudiante::updateOrCreate([
      'fecha_nacimiento' => $request->fecha_nacimiento,
      'lugar_nacimiento' => $request->lugar_nacimiento,
      'descripcion' => $request->descripcion,
      'persona' => $persona->id
    ]);

    return response()->json([
        'id' => $estudiante->id,
        'cedula' => $persona->cedula,
        'nombre' => $persona->nombre, 
        'apellido' => $persona->apellido,
        'sex' => $persona->sex,
        'telefono' => $persona->telefono,
        'direccion' => $persona->direccion,
        'municipio' => $persona->municipio,
        'fecha_nacimiento' => $estudiante->fecha_nacimiento,
        'lugar_nacimiento' => $estudiante->lugar_nacimiento,
        'descripcion' => $estudiante->descripcion
    ], 202);

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Validation $request,$id)
  {
    //
    $estudiante = Estudiante::find($id);
    $persona = Persona::find($estudiante->persona);
    $persona->cedula = $request->cedula;
    $persona->nombre = $request->nombre;
    $persona->apellido = $request->apellido;
    $persona->sex = $request->sex;
    $persona->telefono = $request->telefono;
    $persona->direccion = $request->direccion;
    $persona->municipality = $request->municipio;
    $estudiante->fecha_nacimiento = $request->fecha_nacimiento;
    $estudiante->lugar_nacimiento = $request->lugar_nacimiento;
    $estudiante->descripcion = $request->descripcion;
    $persona->save();
    $estudiante->save();

    return response()->json([
        'id' => $estudiante->id,
        'cedula' => $persona->cedula,
        'nombre' => $persona->nombre, 
        'apellido' => $persona->apellido,
        'sex' => $persona->sex,
        'telefono' => $persona->telefono,
        'direccion' => $persona->direccion,
        'municipio' => $persona->municipality,
        'fecha_nacimiento' => $estudiante->fecha_nacimiento,
        'lugar_nacimiento' => $estudiante->lugar_nacimiento,
        'descripcion' => $estudiante->descripcion
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
    $estudiante = Estudiante::find($id);
    $estudiante->status = 0;
    $estudiante->save();

    $persona = Persona::find($estudiante->persona);
    $persona->status = 0;

    return response()->noContent(204);
  }
}
