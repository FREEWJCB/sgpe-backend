<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table("persona")->insert(
        ["cedula" => "27122644", "nombre" => "Jose Daniel", "apellido" => "Vasquez Pineda", "sex" => "Masculino", "telefono" => "04245879762", "direccion" => "Sabana Larga, frente del mercal", "municipality" => 1]
      );
    }
}
