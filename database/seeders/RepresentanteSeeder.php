<?php

namespace Database\Seeders;

use App\Models\Representante;
use Illuminate\Database\Seeder;

class RepresentanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Representante::factory(10)->create();
    }
}
