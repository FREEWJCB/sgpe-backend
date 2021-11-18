<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Seccion extends FormRequest
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
          'seccion' => 'required|unique:seccion,secciones|string|min:1',
          'grado' => 'required|min:1'
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
      'seccion.required' => 'Es requerido el seccion',
      'seccion.unique' => 'Es nombre del seccion debe ser unico',
      'seccion.string' => 'El nombre del seccion debe tener letras y numeros',
      'seccion.min' => 'El nombre del seccion de ser minimo de 5 letras',
      'grado.required' => 'El grado es requerido',
      'grado.min' => 'Debe elejir un grado'
    ];
  }
}
