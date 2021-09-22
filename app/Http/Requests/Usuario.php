<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Usuario extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:30',
            'email' => 'required|email',
            'pregunta' => 'required|string',
            'respuesta' => 'required|string',
            'tipo' => 'required|numric',
            'empleado' => 'required|numeric'
        ];
    }

  /**
   * Get the error messages for the defined validation rules.
   *     
   * @return array
   */
  public function messages()
  {
    return [
      'name.required' => 'Es requerido la cedula',
      'cedula.unique' => 'la cedula debe ser unico',
      'cedula.numeric' => 'la cedula debe tener solo numeros',
      'cedula.min' => 'La cedula de ser minimo de 5 numeros',
      'cedula.max' => 'La cedula de ser maximo de 12 numeros',
      'nombre.required' => 'Es requerido el nombre',
      'nombre.string' => 'la nombre debe tener solo letras y numeros',
      'nombre.min' => 'El nombre debe ser minimo de 5 numeros',
      'nombre.max' => 'El nombre debe ser maximo de 12 numeros',
      'apellido.required' => 'Es requerido el apellido',
      'apellido.unique' => 'El apellido debe ser unico',
      'apellido.string' => 'El apellido debe tener solo numeros',
      'apellido.min' => 'El apellido de ser minimo de 5 numeros',
      'apellido.max' => 'El apellido de ser maximo de 12 numeros',
      'sex.required' => 'Es requerido el sexo'
    ];
  }
}
