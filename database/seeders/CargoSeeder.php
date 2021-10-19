<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table("cargo")->insert([
        ["cargos" => "Director"],
        ["cargos" => "Sub Director"],
        ["cargos" => "Secretaria"],
        ["cargos" => "Profesor"],
        ["cargos" => "Maestro"],
      ]);
    }
}
