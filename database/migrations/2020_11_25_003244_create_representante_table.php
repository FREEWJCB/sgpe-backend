<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representante', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona');
            $table->unsignedBigInteger('ocupacion_laboral');
            $table->decimal('status',1,0)->default(1);
            $table->foreign('ocupacion_laboral')->references('id')->on('ocupacion_laboral');
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
        Schema::dropIfExists('representante');
    }
}
