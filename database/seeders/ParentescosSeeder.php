<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentescosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      DB::table("parentesco")->insert([
        ["parentescos" => "Madre"],
        ["parentescos" => "Padre"],
        ["parentescos" => "Tio"],
        ["parentescos" => "Tia"],
        ["parentescos" => "Abuela"],
        ["parentescos" => "Abuelo"]
      ]);
    }
}
