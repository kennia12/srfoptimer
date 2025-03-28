<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('puntos_acceso', function (Blueprint $table) {
            $table->id('puntos_acceso_id');
            $table->string('nombre', 100);
            $table->string('ubicacion', 255);
            $table->enum('tipo', ['Entrada', 'Salida', 'Ambos']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('puntos_acceso');
    }
};
