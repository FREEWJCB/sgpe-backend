<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Tipo_usuario;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
  /**
   * Create a new AuthController
   *
   * @return void
   * */
  public function __construct()
  {
   $this->middleware('auth:api', ['except' => ['login']]);
  }

  /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login()
  {
    $credentials = request(['email', 'password']);
    if (! $token = auth()->attempt($credentials)){
      return response()->json(['error' => 'Unauthorized'], 401);
    }
    return $this->responseWithToken($token);
  }

  /**
   * Get the authentication User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {

    $idEmpleado = auth()->user();
    $empleado = Empleado::select('empleado.*', 'cargo.cargos', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
      ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('empleado.id', $idEmpleado->empleado)
      ->get();
    $tipo = Tipo_Usuario::where('tipo', $idEmpleado->tipo);
    return response()->json([
      "user" => auth()->user(),
      "empleado" => $empleado,
      "tipo" => $tipo
    ]);
  }

  /**
   * Log the user out (Invalidate the token)
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    auth()->logout();

    return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Refresh a token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function refresh()
  {
    return $this->responseWithToken(auth()->refresh());
  }

  /**
   * Get the token array structure
   *
   * @param string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function responseWithToken($token)
  {
    $idEmpleado = auth()->user();
    $empleado = Empleado::select('empleado.*', 'cargo.cargos', 'state.states', 'municipality.municipalitys', 'persona.cedula', 'persona.nombre', 'persona.apellido', 'persona.sex', 'persona.telefono')
      ->join('cargo', 'empleado.cargo', '=', 'cargo.id')
      ->join('persona', 'empleado.persona', '=', 'persona.id')
      ->join('municipality', 'persona.municipality', '=', 'municipality.id')
      ->join('state', 'municipality.state', '=', 'state.id')
      ->where('empleado.id', $idEmpleado->empleado)
      ->first();
    $tipo = DB::table('tipo_usuario')->where('id', '=', auth()->user()->tipo)->value('tipo');
    return response()->json([
      'username' => $empleado->nombre,
      'tipo' => $tipo,
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60
    ]);
  }
}
