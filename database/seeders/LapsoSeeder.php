<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LapsoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
  {
    DB::table("lapso")->insert([
        ["numero" => "1"],
        ["numero" => "2"],
        ["numero" => "3"],
    ]);
  }
}
