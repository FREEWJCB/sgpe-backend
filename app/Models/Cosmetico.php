<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosmetico extends Model
{
    use HasFactory;

    protected $table = 'cosmeticos';

    protected $guarded = ['status'];

    // protected $fillable = ['cosmetico', 'descripcion', 'tipo', 'marca', 'modelo'];
}
