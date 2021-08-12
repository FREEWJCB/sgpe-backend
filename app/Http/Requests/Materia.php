<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Materia extends FormRequest
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
            'materia' => 'required|unique:materia,nombre|min:5'
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
      'materia.required' => 'Es requerido la materia',
      'materia.unique' => 'Es nombre de la materia debe ser unico',
      'materia.min' => 'El nombre de la materia de ser minimo de 5 letras'
    ];
  }
}
