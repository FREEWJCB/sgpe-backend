<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->decimal('cedula',8,0)->unique();
            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->string('sex',100);
            $table->string('telefono',11);
            $table->text('direccion');
            $table->unsignedBigInteger('municipality');
            $table->foreign('municipality')->references('id')->on('municipality');
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
        Schema::dropIfExists('persona');
    }
}
