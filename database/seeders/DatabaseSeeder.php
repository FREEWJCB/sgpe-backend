<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      // \App\Models\User::factory(10)->create();
      $this->call([
        CargoSeeder::class,
        StateSeeder::class,
        MunicipalitySeeder::class,
        PersonaSeeder::class,
        EmpleadoSeeder::class,
        TipoUsuarioSeeder::class,
        UserSeeder::class,
        LapsoSeeder::class
    ]);
    }
}
