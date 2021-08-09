<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'name' => 'Jose Daniel Vasquez pineda',
            'email' => 'vasquezpinedaj@gmail.com',
            'password' => Hash::make('562738194'),
        ]);
  }
}
