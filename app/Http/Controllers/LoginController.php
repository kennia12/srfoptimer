<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $loginAttempt = DB::table('login_attempts')->where('email', $credentials['email'])->first();

        if ($loginAttempt && $loginAttempt->is_locked) {
            $lockedUntil = Carbon::parse($loginAttempt->locked_until);
            if (Carbon::now()->lt($lockedUntil)) {
                $remainingMinutes = Carbon::now()->diffInMinutes($lockedUntil);
                return back()->withErrors(['email' => 'Esta cuenta está bloqueada debido a múltiples intentos fallidos. Inténtalo de nuevo en ' . $remainingMinutes . ' minutos.']);
            } else {
                // Desbloquear si el tiempo de bloqueo ha pasado
                DB::table('login_attempts')->where('email', $credentials['email'])->update([
                    'attempts' => 0,
                    'is_locked' => false,
                    'locked_until' => null
                ]);
            }
        }

        $usuario = DB::table('usuarios')->where('correo', $credentials['email'])->first();

        if (!$usuario) {
            $this->incrementLoginAttempts($credentials['email']);
            return back()->withErrors(['email' => 'El correo electrónico no está registrado.']);
        }

        if ($credentials['password'] !== $usuario->password) {
            $this->incrementLoginAttempts($credentials['email']);
            return back()->withErrors(['password' => 'La contraseña es incorrecta.']);
        }

        // Resetear intentos fallidos al iniciar sesión correctamente
        DB::table('login_attempts')->where('email', $credentials['email'])->update([
            'attempts' => 0,
            'last_attempt_at' => null,
            'is_locked' => false,
            'locked_until' => null
        ]);

        // Autenticar al usuario manualmente
        Session::put('authenticated', true);
        Session::put('user_email', $usuario->correo);
        Session::put('user_role', $usuario->rol);

        // Regenerar la sesión para mantenerla activa
        session()->regenerate();

        // Redirigir al usuario según el rol
        switch ($usuario->rol) {
            case 'Admin':
                return redirect()->route('usuarios.index')->with('success', 'Login exitoso. Bienvenido, Administrador.');
            case 'Usuario':
                return redirect()->route('dashboard')->with('success', 'Login exitoso. Bienvenido, Usuario.');
            case 'Guardia':
                return redirect()->route('guard.dashboard')->with('success', 'Login exitoso. Bienvenido, Guardia.');
            default:
                return back()->withErrors(['email' => 'Rol de usuario no reconocido.']);
        }
    }

    private function incrementLoginAttempts($email)
    {
        $loginAttempt = DB::table('login_attempts')->where('email', $email)->first();

        if ($loginAttempt) {
            $attempts = $loginAttempt->attempts + 1;
            $isLocked = $attempts >= 3;

            DB::table('login_attempts')->where('email', $email)->update([
                'attempts' => $attempts,
                'last_attempt_at' => Carbon::now(),
                'is_locked' => $isLocked,
                'locked_until' => $isLocked ? Carbon::now()->addMinutes(5) : null, // Bloqueo durante 5 minutos
            ]);

            if ($isLocked) {
                return back()->withErrors(['email' => 'Has fallado 3 veces. Debes esperar 5 minutos antes de intentar nuevamente.']);
            }
        } else {
            DB::table('login_attempts')->insert([
                'email' => $email,
                'attempts' => 1,
                'last_attempt_at' => Carbon::now(),
                'is_locked' => false,
                'locked_until' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente.');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'email' => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:8|confirmed',
        ]);

        $userId = DB::table('usuarios')->insertGetId([
            'nombre' => $request->nombre,
            'correo' => $request->email,
            'password' => $request->password,
            'rol' => 'Usuario',
            'fecha_registro' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Autenticar y redirigir al usuario registrado
        Session::put('authenticated', true);
        Session::put('user_email', $request->email);
        Session::put('user_role', 'Usuario');

        return redirect('/dashboard');
    }
}
