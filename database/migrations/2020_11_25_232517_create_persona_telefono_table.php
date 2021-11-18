<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTelefonoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona_telefono', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona');
            $table->unsignedBigInteger('telefono');
            $table->foreign('persona')->references('id')->on('persona');
            $table->foreign('telefono')->references('id')->on('telefono');
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
        Schema::dropIfExists('telefono');
    }
}
