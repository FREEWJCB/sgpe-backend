<?php

namespace Database\Factories;

use App\Models\Representante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class RepresentanteFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Representante::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $id = DB::table('persona')
      ->insertGetId([
        "cedula" => $this->faker->numberBetween(1000000, 99999999),
        "nombre" => $this->faker->name,
        "apellido" => $this->faker->lastName,
        "sex" => $this->sex($this->faker->numberBetween(0, 1)),
        "telefono" => $this->faker->numberBetween(1000000000, 99999999999),
        "direccion" => $this->faker->address,
        "municipality" => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ]);

    return [
      "persona" => $id,
      "ocupacion_laboral" => $this->faker->numberBetween(1, 9),
      'created_at' => now(),
      'updated_at' => now(),
    ];
  }

  public function sex($number)
  {
    $sex = "";
    if ($number === 1) {
      $sex = "Masculino";
    } else {
      $sex = "Femenino";
    }

    return $sex;
  }
}
