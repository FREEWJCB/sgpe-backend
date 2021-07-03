<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocupacion_laboral extends Model
{
    use HasFactory;

    protected $table = 'ocupacion_laboral';

    protected $guarded = ['id'];

    // protected $fillable = ['labor'];
}
