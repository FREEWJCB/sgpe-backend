<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudianteRepresentanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante_representante', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parentesco');
            $table->unsignedBigInteger('estudiante');
            $table->unsignedBigInteger('representante');
            $table->decimal('status',1,0)->default(1);
            $table->foreign('parentesco')->references('id')->on('parentesco');
            $table->foreign('estudiante')->references('id')->on('estudiante');
            $table->foreign('representante')->references('id')->on('representante');
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
        Schema::dropIfExists('estudiante_representante');
    }
}
