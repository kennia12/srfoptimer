<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Session::get('authenticated')) {
            return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para acceder a esta página.']);
        }

        // Obtener el rol del usuario desde la sesión
        $role = Session::get('user_role');

        // Verificar si el usuario tiene el rol de Admin o Usuario
        if ($role !== 'Admin' && $role !== 'Usuario') {
            abort(403, 'No tienes permiso para acceder a esta página');
        }

        // Obtener el usuario autenticado para pasar a la vista
        $userEmail = Session::get('user_email');

        // Regenerar la sesión para mantenerla activa
        session()->regenerate();

        return view('dashboard', compact('userEmail'));
    }
}