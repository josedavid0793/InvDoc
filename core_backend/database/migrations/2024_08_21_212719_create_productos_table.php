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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',200)->unique();
            $table->string('descripcion',1000);
            $table->integer('precio_unidad');
            $table->integer('costo_unidad');
            $table->string('codigo',50)->unique();
            $table->integer('cantidad_disponible');
            $table->string('imagen',500);
            $table->string('categoria');

           $table->foreign('categoria')->references('nombre')->on('categorias')->onDelete('cascade')->onUpdate('cascade');
            //$table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('productos');
    }
};
