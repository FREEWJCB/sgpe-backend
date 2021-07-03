<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo_escolar extends Model
{
    use HasFactory;

    protected $table = 'periodo_escolar';

    protected $guarded = ['status'];

    // protected $fillable = ['ano', 'seccion', 'salon', 'grado', 'empleado'];
}
