<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccesosController extends Controller
{
    public function index()
    {
        // Asegurarse de que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para ver sus accesos.']);
        }

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Aquí puedes obtener los accesos del usuario desde la base de datos
        // Ejemplo: $accesos = Acceso::where('user_id', $user->id)->get();
        $accesos = [
            ['fecha' => '2025-03-20', 'hora' => '08:30 AM', 'lugar' => 'Entrada Principal'],
            ['fecha' => '2025-03-19', 'hora' => '05:15 PM', 'lugar' => 'Salida Principal'],
            ['fecha' => '2025-03-18', 'hora' => '09:00 AM', 'lugar' => 'Entrada Secundaria'],
        ];

        return view('mis-accesos', compact('user', 'accesos'));
    }
}

