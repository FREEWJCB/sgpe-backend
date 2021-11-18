<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiante';

    protected $guarded = ['id'];

    // protected $fillable = ['fecha_nacimiento', 'lugar_nacimiento', 'descripcion', 'persona'];
}
