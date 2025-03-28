<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notificaciones_reportes', function (Blueprint $table) {
            $table->id('notificaciones_reportes_id');
            $table->unsignedBigInteger('usuarios_id');
            $table->enum('tipo', ['Notificación', 'Reporte']);
            $table->text('mensaje');
            $table->timestamp('fecha');
            $table->boolean('leido');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificaciones_reportes');
    }
};
