<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiante';

    protected $guarded = ['id'];

    protected $casts = [
        'fecha_nacimiento' => 'date:d/m/Y',
        'created_at' => 'date:d/m/Y',
    ];

    protected $fillable = ['fecha_nacimiento', 'lugar_nacimiento', 'descripcion', 'persona'];
}
