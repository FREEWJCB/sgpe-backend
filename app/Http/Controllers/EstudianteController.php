<?php

namespace App\Http\Controllers;

use App\Http\Requests\Estudiante as Validation;
use App\Models\Estudiante;
use App\Models\Persona;

class EstudianteController extends Controller
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
    $skip = ($page != 1) ? ($page - 1) * $limit : 0;
    //
    $cons = Estudiante::select('estudiante.*', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'municipality.municipalitys', 'state.states')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('estudiante.status', '1');
    // total de los estudiantes
    $count = $cons->count();
    // paginación
    $cons = $cons
      ->skip($skip)
      ->limit($limit)
      ->orderBy('estudiante.id', 'desc');
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
    $res = Estudiante::select('estudiante.*', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'municipality.municipalitys', 'state.states')
      ->join('persona', 'estudiante.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('estudiante.status', '=', '1')
      ->where('persona.cedula', 'like', '%' . $busqueda . '%')
      ->orWhere('persona.nombre', 'like', '%' . $busqueda . '%')
      ->orWhere('persona.apellido', 'like', '%' . $busqueda . '%')
      ->orderBy('estudiante.id', 'desc');
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
    $estudiante = Estudiante::select('estudiante.*', 'persona.cedula', 'persona.nombre', 'persona.telefono', 'persona.apellido', 'persona.sex', 'persona.direccion', 'municipality.id as municipality', 'state.id as states')
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
      'persona' => $persona->id,
      'fecha_nacimiento' => $request->fecha_nacimiento,
      'lugar_nacimiento' => $request->lugar_nacimiento,
      'descripcion' => $request->descripcion,
      'estatura' => $request->estatura,
      'peso' => $request->peso,
      'talla' => $request->talla,
      't_sangre' => $request->t_sangre,
      'fecha_inscrip' => $request->fecha_inscrip,
      'estado_inscrip' => $request->estado_inscrip,
      'beca' => $request->beca,
      'repite' => $request->repite
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
      'descripcion' => $estudiante->descripcion,
      'estatura' => $estudiante->estatura,
      'peso' => $estudiante->peso,
      'talla' => $estudiante->talla,
      't_sangre' => $estudiante->t_sangre,
      'fecha_inscrip' => $estudiante->fecha_inscrip,
      'estado_inscrip' => $estudiante->estado_inscrip,
      'beca' => $estudiante->beca,
      'repite' => $estudiante->repite
    ], 202);
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
    $estudiante-> lugar_nacimiento = $request->lugar_nacimiento;
    $estudiante->descripcion = $request->descripcion;
    $estudiante->estatura = $request->estatura;
    $estudiante->peso = $request->peso;
    $estudiante->talla = $request->talla;
    $estudiante->t_sangre = $request->t_sangre;
    $estudiante->fecha_inscrip = $request->fecha_inscrip;
    $estudiante->estado_inscrip = $request->estado_inscrip;
    $estudiante->beca = $request->beca;
    $estudiante->repite = $request->repite;
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
      'descripcion' => $estudiante->descripcion,
      'estatura' => $estudiante->estatura,
      'peso' => $estudiante->peso,
      'talla' => $estudiante->talla,
      't_sangre' => $estudiante->t_sangre,
      'fecha_inscrip' => $estudiante->fecha_inscrip,
      'estado_inscrip' => $estudiante->estado_inscrip,
      'beca' => $estudiante->beca,
      'repite' => $estudiante->repite
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
