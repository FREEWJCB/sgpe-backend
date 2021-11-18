<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaGrupoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_grupo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materia');
            $table->unsignedBigInteger('grupo');
            $table->decimal('status',1,0)->default(1);
            $table->foreign('materia')->references('id')->on('materia');
            $table->foreign('grupo')->references('id')->on('grupo');
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
        Schema::dropIfExists('materia_grupo');
    }
}
