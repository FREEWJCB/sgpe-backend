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
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $cons = User::select('users.*', 'empleado.*', 'persona.*', 'tipo_usuario.tipo as tipo_usuario')
      ->join('tipo_usuario', 'users.tipo', '=', 'tipo_usuario.id')
      ->join('empleado', 'users.empleado', '=', 'empleado.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->where('users.status', '1')->orderBy('name', 'asc');
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
  public function store(Request $request)
  {
    //
    $usuario = User::updateOrCreate([
      'name' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'tipo' => $request->tipo_usuario,
      'empleado' => $request->empleado,
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
    return response()->json(User::select('*', 'tipo_usuario.tipo as tipo_usuario')->join('tipo_usuario', 'users.tipo', '=', 'tipo_usuario.id')
      ->join('empleado', 'users.empleado', '=', 'empleado.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->findOrFail($id), 202);
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
    $usuario->tipo = $request->tipo_usuario;
    $usuario->empleado = $request->empleado;
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
