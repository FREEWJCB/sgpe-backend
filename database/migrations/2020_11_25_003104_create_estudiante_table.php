<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudianteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_nacimiento');
            $table->text('lugar_nacimiento');
            $table->text('descripcion');
            $table->string('descripcion', 100);
            $table->decimal('estatura', 3);
            $table->decimal('peso', 3);
            $table->string('talla', 2);
            $table->string('t_sangre', 2);
            $table->date('fecha_inscrip')->default(false);
            $table->boolean('estado_inscrip')->default(false);
            $table->boolean('beca')->default(false);
            $table->boolean('repite')->default(false);
            $table->unsignedBigInteger('persona')->unique();
            $table->decimal('status',1,0)->default(1);
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
        Schema::dropIfExists('estudiante');
    }
}
