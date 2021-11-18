<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_materia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado');
            $table->unsignedBigInteger('materia');
            $table->foreign('empleado')->references('id')->on('empleado');
            $table->foreign('materia')->references('id')->on('materia');
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
        Schema::dropIfExists('empleado_materia');
    }
}
