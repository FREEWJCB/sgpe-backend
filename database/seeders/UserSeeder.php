<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::factory(10)->create();

    DB::table('users')->insert([
      'email' => 'vasquezpinedaj@gmail.com',
      'password' => Hash::make('562738194'),
      'remember_token' => Str::random(10),
      'tipo' => 1,
      'created_at' => now(),
      'updated_at' => now(),
      "empleado" => 1,
      "pregunta" => "¿Cual es tu color favorito?",
      "respuesta" => "Azul"
    ]);
  }
}
