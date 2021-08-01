<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodoEscolarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodo_escolar', function (Blueprint $table) {
            $table->id();
            $table->string('ano',100);
            $table->unsignedBigInteger('seccion');
            $table->unsignedBigInteger('salon');
            $table->unsignedBigInteger('grado');
            $table->unsignedBigInteger('empleado');
            $table->decimal('status',1,0)->default(1);
            $table->foreign('seccion')->references('id')->on('seccion');
            $table->foreign('salon')->references('id')->on('salon');
            $table->foreign('grado')->references('id')->on('grado');
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
        Schema::dropIfExists('periodo_escolar');
    }
}
