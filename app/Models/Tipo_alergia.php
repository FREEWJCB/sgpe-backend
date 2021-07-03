<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_alergia extends Model
{
    use HasFactory;

    protected $table = 'tipo_alergia';

    protected $guarded = ['id'];

    // protected $fillable = ['tipo'];
}
