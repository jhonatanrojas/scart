<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntar_documencts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('email');
            $table->string('telefono');
            $table->string('carta_trabajo');
            $table->string('cedula_rif');
            $table->string('id_usuario');
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
        Schema::dropIfExists('adjuntar_documencts');
    }
};
