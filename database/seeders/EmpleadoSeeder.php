<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('empleado')->insert([
        "cargo" => 1, "persona" => 1, "anio_ing_inst" => "01-01-2000",	"anio_ing_mppe" => "01-01-2000",
	"tit_pregrad" => "la verda no se que poner aqui", "tit_postgrad" => "y aun menos aqui"
      ]);

      Empleado::factory(10)->create();
    }
}
