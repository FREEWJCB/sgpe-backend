<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Estudiante::factory(50)->state(new Sequence(
        ['t_sangre' => "A"],
        ['t_sangre' => "B"],
        ['t_sangre' => "AB"],
      ))->create();
    }
}
