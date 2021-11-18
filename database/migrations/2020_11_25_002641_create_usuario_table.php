<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('username',100)->unique();
            $table->string('pregunta',100);
            $table->string('respuesta',100);
            $table->unsignedBigInteger('tipo');
            $table->unsignedBigInteger('empleado')->unique();
            $table->decimal('status',1,0)->default(1);
            $table->foreign('tipo')->references('id')->on('tipo_usuario');
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
        Schema::dropIfExists('usuario');
    }
}
