<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $table = 'representante';

    protected $guarded = ['id', 'persona'];

    // protected $fillable = ['ocupacion_laboral'];
}
