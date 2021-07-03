<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    use HasFactory;

    protected $table = 'parroquia';

    protected $guarded = ['id'];

    // protected $fillable = ['municipality','parroquias'];
}
