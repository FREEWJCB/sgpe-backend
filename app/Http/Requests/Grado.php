<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Grado extends FormRequest
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
            'grado' => 'required|unique:grado,grados|string|min:1'
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
      'grado.required' => 'Es requerido el grado',
      'grado.unique' => 'Es nombre del grado debe ser unico',
      'grado.string' => 'El nombre del grado debe tener letras y numeros',
      'grado.min' => 'El nombre del grado de ser minimo de 5 letras'
    ];
  }
}
