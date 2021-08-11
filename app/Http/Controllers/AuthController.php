<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

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
    return response()->json(auth()->user());
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
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60
    ]);
  }
}
