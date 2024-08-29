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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // Esto crea un campo 'id' con AUTO_INCREMENT
            $table->string('nombres', 200);
            $table->string('apellidos', 250);
            $table->string('email', 300)->unique();
            $table->string('tipo_documento', 10);
            $table->unsignedBigInteger('numero_documento')->unique();
            $table->unsignedBigInteger('telefono')->unique();
        
            // Asegúrate de que el campo 'tipo_documento' sea un campo de clave ajena en la tabla 'tipo_documento'.
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
        Schema::dropIfExists('usuarios');
    }
};
