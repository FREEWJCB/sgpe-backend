<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosmetic extends Model
{
    use HasFactory;

    protected $table = 'cosmetics';

    protected $guarded = ['status'];

    // protected $fillable = ['cosmetico', 'descripcion', 'tipo', 'modelo'];
}
