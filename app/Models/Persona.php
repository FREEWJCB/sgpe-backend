<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';

    protected $guarded = ['id'];

    // protected $fillable = ['cedula', 'nombre', 'apellido', 'sex', 'telefono', 'direccion', 'municipality'];
}
