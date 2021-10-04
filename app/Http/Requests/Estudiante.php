<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Estudiante extends FormRequest
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
      'fecha_nacimiento' => 'required|date',
      'lugar_nacimiento' => 'required|string|min:10',
      'descripcion' => 'required|string|min:9',
      'estatura' => 'required|numeric|min:60',
      'peso' => 'required|numeric|min:20',
      'talla' => 'required|string|min:1',
      't_sangre' => 'required|string|min:1',
      'fecha_inscrip' => 'date',
      'estado_inscrip' => 'boolean',
      'beca' => 'required|boolean',
      'repite' => 'required|boolean'
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
      'fecha_nacimiento.required' => 'Es requerido la fecha de nacimiento',
      'fecha_nacimiento.date' => 'la fecha de nacimiento debe ser tipo Date',
      'lugar_nacimiento.string' => 'El lugar de nacimiento debe tener solo letras y numeros',
      'lugar_nacimiento.min' => 'El Lugar de ser minimo de 10 numeros',
      'descripcion.required' => 'Es requerida la descripcion',
      'descripcion.string' => 'La descripcion debe ser alfanumerica',
      'descripcion.min' => 'La descripcion debe ser mayor a 10 characteres',
      'estatura.required' => 'Es requerida la estatura',
      'estatura.numeric' => 'La estatura debe ser numeros',
      'estatura.min' => 'la estatura debe ser mayor a 60cm',
      'peso.required' => 'Es requerida la peso',
      'peso.numeric' => 'La peso debe ser numeros',
      'peso.min' => 'la peso debe ser mayor a 20 kilos',
      'talla.required' => 'Es requerida la talla',
      'talla.string' => 'La talla debe ser letras',
      'talla.min' => 'la talla debe ser mayor a una letra',
      't_sangre.required' => 'Es requerida el tipo de sangre',
      't_sangre.string' => 'el tipo de sangre deben ser letras',
      't_sangre.min' => 'el tipo de sangre debe ser mayor a una letra',
      'fecha_inscrip.date' => 'la fecha de inscripcion debe ser una fecha',
      'estado_inscrip.boolean' => 'el estado de inscripcion debe ser del tipo boolean',
      'beca.required' => 'Es requerida la beca',
      'beca.boolean' => 'la beca debe ser del tipo boolean',
      'repite.required' => 'si repite es requerida',
      'repite.boolean' => 'repite debe ser del tipo boolean',
    ];
  }
}
