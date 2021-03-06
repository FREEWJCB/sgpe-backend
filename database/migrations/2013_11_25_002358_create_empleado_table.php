<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('empleado', function (Blueprint $table) {
      $table->id();
      $table->date("anio_ing_inst")->nullable();
      $table->date("anio_ing_mppe")->nullable();
      $table->string("tit_pregrad", 100)->nullable();
      $table->string("tit_postgrad", 100)->nullable();
      $table->unsignedBigInteger('cargo');
      $table->unsignedBigInteger('persona');
      $table->decimal('status', 1, 0)->default(1);
      $table->foreign('cargo')->references('id')->on('cargo');
      $table->foreign('persona')->references('id')->on('persona');
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
    Schema::dropIfExists('empleado');
  }
}
