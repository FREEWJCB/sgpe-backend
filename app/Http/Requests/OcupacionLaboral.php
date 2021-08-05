<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OcupacionLaboral extends FormRequest
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
          'labor' => 'required|unique:ocupacion_laboral,labor|string|min:5'
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
        'labor.required' => 'El labor es requerido',
        'labor.unique' => 'El nombre del labor debe ser unico',
        'labor.string' => 'El nombre del balor debe ser alfanumerico',
        'labor.min' => 'El labor debe ser mayor a 5 characteres'
      ];
    }
}
