<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discapacidad extends Model
{
    use HasFactory;

    protected $table = 'discapacidad';

    protected $guarded = ['id'];

    // protected $fillable = ['discapacidades', 'descripcion', 'tipo'];
}
