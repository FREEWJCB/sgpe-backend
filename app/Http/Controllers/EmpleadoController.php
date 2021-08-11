<?php

namespace App\Http\Controllers;

use App\Http\Requests\Empleado as Validation;
use App\Models\Cargo;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\State;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
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
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $cons = Empleado::select('empleado.*', 'cargo.cargos', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
      ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')->where('empleado.status', '1')->orderBy('cedula', 'asc');
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
    $empleado = Empleado::select('empleado.*', 'cargo.cargos', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
      ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('empleado.id', $id)
      ->get();
    if (Empleado::find($id)) {
      return response()->json($empleado, 200);
    } else {
      return response()->json([
        "error" => "No se encontro el Empleado",
        "code" => 404
      ], 404);
    }
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
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


    $empleado = Empleado::create([
      'email' => $request->email,
      'cargo' => $request->cargo,
      'persona' => $persona->id
    ]);

    return response()->json($empleado, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Validation $request, $id)
  {
    //
    $empleado = Empleado::find($id);
    $persona = Persona::find($empleado->persona);
    $persona->cedula = $request->cedula;
    $persona->nombre = $request->nombre;
    $persona->apellido = $request->apellido;
    $persona->sex = $request->sex;
    $persona->telefono = $request->telefono;
    $persona->direccion = $request->direccion;
    $persona->municipality = $request->municipio;
    $empleado->email = $request->email;
    $empleado->cargo = $request->cargo;
    $persona->save();
    $empleado->save();

    return response()->json([
      'id' => $empleado->id,
      'cedula' => $persona->cedula,
      'nombre' => $persona->nombre,
      'apellido' => $persona->apellido,
      'sex' => $persona->sex,
      'telefono' => $persona->telefono,
      'direccion' => $persona->direccion,
      'municipio' => $persona->municipality,
      'email' => $empleado->email,
      'cargo' => $empleado->cargo
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
    $empleado = Empleado::find($id);
    $empleado->status = 0;
    $empleado->save();

    return response()->noContent(204);
  }
}
