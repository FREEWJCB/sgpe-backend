<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Cargo extends FormRequest
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
      'cargo' => 'required|unique:cargo,cargos|string|min:5'
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
      'cargo.required' => 'Es requerido el cargo',
      'cargo.unique' => 'Es nombre del cargo debe ser unico',
      'cargo.string' => 'El nombre del cargo debe tener letras y numeros',
      'cargo.min' => 'El nombre del cargo de ser minimo de 5 letras'
    ];
  }

}
