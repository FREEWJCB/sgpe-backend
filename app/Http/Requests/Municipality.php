<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Municipality extends FormRequest
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
      'municipio' => 'required|bail|unique:municipality,municipalitys',
      'estado_id' => 'required'
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
      'municipio.required' => 'Es requerido el nombre del municipio',
      'municipio.baild' => 'fallo la validacion',
      'municipio.unique' => 'El nombre del municipio debe ser unico',
      'estado_id.required' => 'Es requerido el estado'
    ];
  }
}
