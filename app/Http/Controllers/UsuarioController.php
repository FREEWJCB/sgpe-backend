<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Tipo_usuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
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

    $cons = User::select('users.id', 'persona.nombre')
      ->join('empleado', 'users.empleado', '=', 'empleado.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->where('users.status', '1');
    $count = $cons->count();
    // paginación
    $cons = $cons
      ->skip($skip)
      ->limit($limit)
      ->orderBy('users.id', 'desc');
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
    $res = User::select('users.id', 'persona.nombre')
      ->join('empleado', 'users.empleado', '=', 'empleado.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->where('users.status', '=', '1')
      ->where('persona.cedula', 'like', '%' . $busqueda . '%')
      ->orWhere('persona.nombre', 'like', '%' . strtoupper($busqueda) . '%')
      ->orWhere('persona.nombre', 'like', '%' . strtolower($busqueda) . '%')
      ->orWhere('persona.apellido', 'like', '%' . strtoupper($busqueda) . '%')
      ->orWhere('persona.apellido', 'like', '%' . strtolower($busqueda) . '%')
      ->orderBy('users.id', 'desc');
    $res = $res->get();
    //$num = $cons->count();
    return response()->json($res, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
    $usuario = User::updateOrCreate([
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'tipo' => $request->tipo,
      'empleado' => $request->empleado_id,
      'pregunta' => $request->pregunta,
      'respuesta' => $request->respuesta
    ]);
    return response()->json($usuario, 200);
  }

  /**
   * Show the profile for the given user.
   *
   * @param  int  $id
   * @return StateCollection
   */
  public function show($id)
  {
    $res = User::select('users.email', 'users.tipo', 'users.empleado as empleado_id', 'users.pregunta', 'users.respuesta')
      ->join('empleado', 'users.empleado', '=', 'empleado.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->where([
        ['users.status', '1'],
        ['users.id', '=', $id]
      ])
    ->first();
    if (User::find($id)) {
      $empleado = Empleado::select('cargo.cargos as cargo', 'persona.cedula', 'persona.nombre', 'persona.apellido')
      ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->where('empleado.id', $res->empleado_id)
      ->first();
    $res->empleado = $empleado;
      return response()->json($res, 200);
    } else {
      return response()->json([
        "error" => "No se encontro el Usuario",
        "code" => 404
      ], 404);
    }
    //return new StateResource(State::find($id));
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
    $usuario = User::findOrFail($id);
    
    $usuario->email = $request->email;
    $usuario->tipo = $request->tipo;
    $usuario->empleado = $request->empleado_id;
    $usuario->pregunta = $request->pregunta;
    $usuario->respuesta = $request->respuesta;

    $usuario->save();

    return response()->json($usuario, 200);

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updatePassword(Request $request, $id)
  {
    //
    $usuario = User::findOrFail($id);

    if (!$request->newPassword) {
      $res = [
        "error" => "falta la nueva contraseña"
      ];
    } else if (Hash::check($request->password, $usuario->password)) {
      $usuario->password = Hash::make($request->newPassword);
      $usuario->save();
      $res = [
        "message" => "Se cambio la contraseña"
      ];
    } else {
      $res = [
        "error" => "No coincide la contraseña"
      ];
    }

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
    $usuario = User::findOrFail($id);

    $usuario->status = 0;

    $usuario->save();

    return response()->noContent(204);
  }
}
