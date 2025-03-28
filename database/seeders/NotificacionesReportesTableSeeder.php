<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificacionesReportesTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('notificaciones_reportes')->insert([
                'usuarios_id' => rand(1, 100),
                'tipo' => ['Notificación', 'Reporte'][array_rand(['Notificación', 'Reporte'])],
                'mensaje' => Str::random(50),
                'fecha' => now(),
                'leido' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
