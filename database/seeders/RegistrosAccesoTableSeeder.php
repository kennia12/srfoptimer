<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrosAccesoTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('registros_acceso')->insert([
                'usuarios_id' => rand(1, 100),
                'puntos_acceso_id' => rand(1, 100),
                'metodo' => ['RFID', 'Reconocimiento Facial'][array_rand(['RFID', 'Reconocimiento Facial'])],
                'fecha_hora' => now(),
                'resultado' => ['Permitido', 'Denegado'][array_rand(['Permitido', 'Denegado'])],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
