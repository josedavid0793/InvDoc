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
            $table->string('descripcion',1000)->nullable();
            $table->integer('precio_unidad')->nullable();
            $table->integer('costo_unidad')->nullable();
            $table->string('codigo',50)->unique()->nullable();
            $table->integer('cantidad_disponible')->nullable();
            $table->json('imagen')->nullable()->change();
            //$table->string('imagen',500);
            $table->string('categoria')->nullable();

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
