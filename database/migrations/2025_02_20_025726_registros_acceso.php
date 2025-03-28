<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('registros_acceso', function (Blueprint $table) {
            $table->id('registros_acceso_id');
            $table->unsignedBigInteger('usuarios_id');
            $table->unsignedBigInteger('puntos_acceso_id');
            $table->enum('metodo', ['RFID', 'Reconocimiento Facial']);
            $table->timestamp('fecha_hora');
            $table->enum('resultado', ['Permitido', 'Denegado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registros_acceso');
    }
};
