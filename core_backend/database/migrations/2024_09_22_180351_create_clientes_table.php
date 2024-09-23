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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',200)->index();
            $table->unsignedBigInteger('telefono')->unique()->nullable();   
            $table->string('tipo_documento',10)->nullable();
            $table->unsignedBigInteger('numero_documento')->unique();
            $table->string('comentarios',500)->nullable();

            $table->foreign('tipo_documento')->references('codigo')->on('tipo_documento')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('clientes');
    }
};
