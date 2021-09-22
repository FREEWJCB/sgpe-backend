<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Empleado extends FormRequest
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
    if ($this->method() == "POST") {
      $cedula = 'required|unique:persona,cedula|numeric|min:1111111|max:100000000';
    } else {
      $cedula = 'required|numeric|min:1111111|max:100000000';
    }
    return [
      'cedula' => $cedula,
      'nombre' => 'required|string|min:5|max:30',
      'apellido' => 'required|string|min:5|max:30',
      'sex' => 'required',
      'telefono' => 'required|string|min:11|max:12',
      'direccion' => 'required|string|min:10|max:50',
      'municipio' => 'required|numeric|min:1',
      'cargo' => 'required|numeric|min:1'
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
      'cedula.required' => 'Es requerido la cedula',
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
      'sex.required' => 'Es requerido el sexo',
      'telefono.required' => 'Es requerido el telefono',
      'telefono.string' => 'El telefono debe tener solo numeros y letras',
      'telefono.min' => 'El telefono de ser minimo de 11 numeros',
      'telefono.max' => 'El telefono de ser maximo de 12 numeros',
      'direccion.required' => 'Es requerido la direccion',
      'direccion.string' => 'la direccion debe tener solo texto',
      'direccion.min' => 'La direccion de ser minimo de 10 letras y numeros',
      'direccion.max' => 'La direccion de ser maximo de 50 letras y numeros',
      'municipio.required' => 'Es requerido el municipio',
      'municipio.numeric' => 'El Municipio debe tener solo numeros',
      'municipio.min' => 'El municipio de ser minimo de 1 numeros',
      'cargo.required' => 'Debe Seleccionar un cargo',
      'cargo.numeric' => 'Debe Seleccionar un cargo',
      'cargo.min' => 'Debe Seleccionar un cargo'
    ];
  }

  /**
   * Response if the request is for ajax
   *
   * @return response
   */
  public function ajax()
  {
    if (!$this->ajax()) {
      return response()->json([
        "error" => "solo se acepta ajax"
      ]);
    }
  }
}
