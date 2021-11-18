<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoGrupoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_grupo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grupo');
            $table->unsignedBigInteger('empleado');
            $table->decimal('status',1,0)->default(1);
            $table->foreign('grupo')->references('id')->on('grupo');
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
        Schema::dropIfExists('empleado_grupo');
    }
}
