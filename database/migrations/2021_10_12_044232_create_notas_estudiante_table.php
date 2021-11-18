<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasEstudianteTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notas_estudiante', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('estudiante');
      $table->unsignedBigInteger('notas');
      $table->decimal('status', 1, 0)->default(1);
      $table->foreign('estudiante')->references('id')->on('estudiante');
      $table->foreign('notas')->references('id')->on('notas');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('notas_estudiante');
  }
}
