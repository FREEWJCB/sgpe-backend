<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciaEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencia_empleado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asistencia');
            $table->unsignedBigInteger('empleado');
            $table->decimal('status',1,0)->default(1);
            $table->foreign('asistencia')->references('id')->on('asistencia');
            $table->foreign('empleado')->references('id')->on('empleado');
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
        Schema::dropIfExists('asistencia_empleado');
    }
}
