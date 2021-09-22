<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('pregunta',100)->nullable();
            $table->string('respuesta',100)->nullable();
            $table->unsignedBigInteger('tipo')->nullable();
            $table->unsignedBigInteger('empleado')->unique()->nullable();
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
        Schema::dropIfExists('users');
    }
}
