<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PuntosAccesoTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('puntos_acceso')->insert([
                'nombre' => Str::random(10),
                'ubicacion' => Str::random(20),
                'tipo' => ['Entrada', 'Salida', 'Ambos'][array_rand(['Entrada', 'Salida', 'Ambos'])],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
