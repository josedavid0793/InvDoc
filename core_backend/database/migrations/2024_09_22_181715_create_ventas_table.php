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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('valor');
            $table->integer('iva')->nullable();
            $table->integer('valor_total');
            $table->string('concepto',500)->nullable();
            $table->string('nombre_producto',200);
            $table->integer('cantidad')->nullable();
            $table->string('modalidad_pago',100);
            $table->string('metodo_pago',100);
            $table->string('nombre_cliente',200)->nullable();

            $table->foreign('nombre_producto')->references('nombre')->on('productos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('modalidad_pago')->references('modalidad')->on('modalidad_pago')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('metodo_pago')->references('metodo')->on('metodos_pago')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nombre_cliente')->references('nombre')->on('clientes')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('ventas');
    }
};
