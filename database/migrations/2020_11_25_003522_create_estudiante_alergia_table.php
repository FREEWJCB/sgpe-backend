<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudianteAlergiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante_alergia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante');
            $table->unsignedBigInteger('alergia');
            $table->foreign('estudiante')->references('id')->on('estudiante');
            $table->foreign('alergia')->references('id')->on('alergia');
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
        Schema::dropIfExists('estudiante_alergia');
    }
}
