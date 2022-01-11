<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RecuperaContrasenaController extends Controller
{
    /**
     *  Verificar si existe el Correo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * */
    public function verificarCorreo(Request $request)
    {
        $user = User::where('email', $request->email);

        if (User::where('email', $request->email)->count() < 1) {
            return response()->json(['msg' => 'El correo: ' . $request->email . ' no se encuentra registrado'], 404);
        }

        $user = $user->first();
        $id = $user->id;
        $pregunta = $user->pregunta;

        return response()->json(['id' => $id, 'pregunta' => $pregunta]);
    }

    /**
     *  Cambiar la contraseña
     *
     * @param User user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * */
    public function recuperarContrasena(User $user, Request $request)
    {
        $this->validate($request, [
            'password' => ['required ', 'string', 'min:8', 'max:30'],
            'respuesta' => ['required', Rule::in($user->respuesta)]
        ], [
            'password.required' => 'Es obligatoria la contraseña',
            'password.string' => 'la contraseña debe tener caracteres especiales, numeros y letras',
            'password.min' => 'La contraseña de se minimo de 8 characteres',
            'password.max' => 'La contraseña de se maximo de 30 characteres',
            'respuesta.required' => 'La respuesta es obligatoria',
            'respuesta.in' => 'No coincide la respuesta'
        ]);

        $password = $request->password;

        try {

            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            return response()->json(['msg' => 'Se cambio la contraseña']);
        } catch (\Exception $e) {

            return response()->json(['errors' => [
                "password" => 'No se pudo cambiar la contraseña',
                "error" => $e
            ]]);
        }
    }
}
