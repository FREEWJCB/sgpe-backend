<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_notas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materia');
            $table->unsignedBigInteger('notas');
            $table->foreign('materia')->references('id')->on('materia');
            $table->foreign('notas')->references('id')->on('notas');
            $table->decimal('status',1,0)->default(1);
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
        Schema::dropIfExists('materia_notas');
    }
}