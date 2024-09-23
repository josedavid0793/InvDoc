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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->integer('valor');
            $table->string('concepto',500)->nullable();
            $table->string('modalidad_pago',100);
            $table->string('metodo_pago',100);
            $table->string('proveedor',200);
            $table->date('fecha');
            $table->string('categoria_gasto',200);

            $table->foreign('metodo_pago')->references('metodo')->on('metodos_pago')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('categoria_gasto')->references('categoria')->on('categorias_gastos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('modalidad_pago')->references('modalidad')->on('modalidad_pago')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('gastos');
    }
};
