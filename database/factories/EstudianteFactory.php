<?php

namespace Database\Factories;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class EstudianteFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Estudiante::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $id = DB::table('persona')
      ->insertGetId([
        "cedula" => $this->faker->numberBetween(10000000, 99999999),
        "nombre" => $this->faker->name,
        "apellido" => $this->faker->lastName,
        "sex" => $this->sex($this->faker->numberBetween(0,1)),
        "telefono" => $this->faker->numberBetween(1000000000, 99999999999),
        "direccion" => $this->faker->address,
        "municipality" => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ]);

    return [
      "persona" => $id,
      "fecha_nacimiento" => $this->faker->dateTimeBetween('-20 years', 'now'),
      "lugar_nacimiento" => $this->faker->address,
      "descripcion" => $this->faker->text,
      "estatura" => $this->faker->numberBetween(70, 200),
      "peso" => $this->faker->numberBetween(40, 100),
      "talla" => $this->faker->numberBetween(20, 45),
      "t_sangre" => "A",
      'created_at' => now(),
      'updated_at' => now(),
    ];
  }

  public function sex($number)
  {
    $sex = "";
    if($number === 1){
      $sex = "Masculino";
    } else {
      $sex = "Femenino";
    }

    return $sex;
  }
}
