<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudianteDiscapacidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante_discapacidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante');
            $table->unsignedBigInteger('discapacidad');
            $table->foreign('estudiante')->references('id')->on('estudiante');
            $table->foreign('discapacidad')->references('id')->on('discapacidad');
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
        Schema::dropIfExists('estudiante_discapacidad');
    }
}
