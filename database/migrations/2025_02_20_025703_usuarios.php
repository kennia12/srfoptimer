<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuarios_id');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('correo', 100);
            $table->string('telefono', 20);
            $table->enum('rol', ['Admin', 'Usuario', 'Guardia']);
            $table->string('rfid', 50);
            $table->text('hash_rostro');
            $table->enum('estado', ['Activo', 'Inactivo']);
            $table->datetime('fecha_registro');
            $table->string('password'); // Añadir el campo password
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
