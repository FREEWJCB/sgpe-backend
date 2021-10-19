<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class State extends FormRequest
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
      'estado' => 'required|unique:state,states|string|min:3'
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
      'estado.required' => 'Es requerido el estado',
      'estado.unique' => 'Es nombre del estado debe ser unico',
      'estado.string' => 'El nombre del estado debe tener letras y numeros',
      'estado.min' => 'El nombre del estado de ser minimo de 3 letras'
    ];
  }
}
