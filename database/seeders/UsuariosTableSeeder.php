<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsuariosTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('usuarios')->insert([
                'nombre' => Str::random(10),
                'apellido' => Str::random(10),
                'correo' => Str::random(10) . '@example.com',
                'telefono' => '1234567890',
                'rol' => ['Admin', 'Usuario', 'Guardia'][array_rand(['Admin', 'Usuario', 'Guardia'])],
                'rfid' => Str::random(10),
                'hash_rostro' => Str::random(30),
                'estado' => ['Activo', 'Inactivo'][array_rand(['Activo', 'Inactivo'])],
                'fecha_registro' => now(),
                'password' => Str::random(10), // Añadir campo password
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
