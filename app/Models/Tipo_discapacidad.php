<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_discapacidad extends Model
{
    use HasFactory;

    protected $table = 'tipo_discapacidad';

    protected $guarded = ['id'];

    // protected $fillable = ['tipo'];
}
