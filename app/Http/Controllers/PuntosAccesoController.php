<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PuntosAccesoController extends Controller
{
    public function __construct()
    {
        // Middleware para verificar la sesión
        $this->middleware(function ($request, $next) {
            if (!session('authenticated')) {
                return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para acceder a esta página.']);
            }
            return $next($request);
        });
    }

    // Método para autorizar solo a administradores
    private function authorizeAdmin()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para acceder a esta página.']);
        }

        $user = Auth::user();
        if ($user->role !== 'Admin') {
            abort(403, 'No tienes permiso para acceder a esta página');
        }
    }

    // Listar todos los puntos de acceso
    public function index(Request $request)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario
    
        $query = $request->input('query');
    
        // Obtener y filtrar los puntos de acceso
        $response = Http::get('http://localhost:3000/api/puntos_acceso');
        if ($response->successful()) {
            $puntos_acceso = collect($response->json()); // Convertir a colección
    
            if ($query) {
                $puntos_acceso = $puntos_acceso->filter(function ($item) use ($query) {
                    return stripos($item['nombre'], $query) !== false ||
                        stripos($item['ubicacion'], $query) !== false ||
                        stripos($item['tipo'], $query) !== false;
                });
            }
    
            // Agrupar puntos de acceso por tipo
            $tiposData = $puntos_acceso->groupBy('tipo')->map(function ($puntos) {
                return $puntos->count();
            });
    
            // Paginación para los puntos de acceso
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10;
            $currentItems = $puntos_acceso->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $paginatedPuntosAcceso = new LengthAwarePaginator($currentItems, $puntos_acceso->count(), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath()
            ]);
    
            return view('puntos_acceso', [
                'puntos_acceso' => $paginatedPuntosAcceso,
                'query' => $query,
                'tiposData' => $tiposData
            ]);
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al consultar la API']);
        }
    }         

    // Mostrar formulario de creación de punto de acceso
    public function create()
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        return view('puntos_acceso.create');
    }

    // Guardar un nuevo punto de acceso
    public function store(Request $request)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        // Excluir el campo _token de los datos que se envían a la API
        $data = $request->except('_token');

        $response = Http::post('http://localhost:3000/api/puntos_acceso', $data);

        if ($response->successful()) {
            return Redirect::route('puntos_acceso.index')->with('success', 'Punto de acceso creado exitosamente');
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al crear el punto de acceso']);
        }
    }

    // Mostrar formulario de edición de punto de acceso
    public function edit($id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        $response = Http::get('http://localhost:3000/api/puntos_acceso/' . $id);
        if ($response->successful()) {
            $punto_acceso = $response->json();
            return view('puntos_acceso.edit', compact('punto_acceso'));
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al consultar la API']);
        }
    }

    // Actualizar un punto de acceso existente
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        // Excluir los campos _token y _method de los datos que se envían a la API
        $data = $request->except(['_token', '_method']);

        $response = Http::put("http://localhost:3000/api/puntos_acceso/{$id}", $data);

        if ($response->successful()) {
            return Redirect::route('puntos_acceso.index')->with('success', 'Punto de acceso actualizado exitosamente');
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al actualizar el punto de acceso']);
        }
    }

    // Eliminar un punto de acceso
    public function destroy($id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        $response = Http::delete('http://localhost:3000/api/puntos_acceso/' . $id);

        if ($response->successful()) {
            return redirect()->route('puntos_acceso.index')->with('success', 'Punto de acceso eliminado exitosamente');
        } else {
            return redirect()->route('puntos_acceso.index')->with('error', 'Error al eliminar el punto de acceso');
        }
    }
}
