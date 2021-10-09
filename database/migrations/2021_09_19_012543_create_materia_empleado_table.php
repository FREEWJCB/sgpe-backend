<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_empleado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materia');
            $table->unsignedBigInteger('empleado');
            $table->decimal('status',1,0)->default(1);
            $table->foreign('materia')->references('id')->on('materia');
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
        Schema::dropIfExists('materia_empleado');
    }
}
