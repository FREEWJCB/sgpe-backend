<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OcupacionLaboralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('ocupacion_laboral')
        ->insert([
          ['labor' => 'Medico'],
          ['labor' => 'Abogado'],
          ['labor' => 'Profesor'],
          ['labor' => 'Maestro'],
          ['labor' => 'Chef'],
          ['labor' => 'Ingeniero'],
          ['labor' => 'Carpintero'],
          ['labor' => 'Programador'],
          ['labor' => 'Enfermero'],
        ]);
    }
}
