<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class RegistrosAccesoController extends Controller
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

    // Listar todos los registros de acceso
    public function index(Request $request)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario
    
        $query = $request->input('query');
    
        // Obtener y filtrar los registros de acceso
        $response = Http::get('http://localhost:3000/api/registros_acceso');
        if ($response->successful()) {
            $registros_acceso = collect($response->json()); // Convertir a colección
    
            if ($query) {
                $registros_acceso = $registros_acceso->filter(function ($item) use ($query) {
                    return stripos($item['metodo'], $query) !== false ||
                        stripos($item['resultado'], $query) !== false;
                });
            }
    
            // Agrupar registros por método y resultado
            $metodosData = $registros_acceso->groupBy('metodo')->map(function ($registros) {
                return $registros->count();
            });
    
            $resultadosData = $registros_acceso->groupBy('resultado')->map(function ($registros) {
                return $registros->count();
            });
    
            // Paginación para los registros de acceso
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10;
            $currentItems = $registros_acceso->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $paginatedRegistrosAcceso = new LengthAwarePaginator($currentItems, $registros_acceso->count(), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath()
            ]);
    
            return view('registros_acceso', [
                'registros_acceso' => $paginatedRegistrosAcceso,
                'query' => $query,
                'metodosData' => $metodosData,
                'resultadosData' => $resultadosData
            ]);
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al consultar la API']);
        }
    }

    // Mostrar formulario de creación de registro de acceso
    public function create()
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        return view('registros_acceso.create');
    }

    // Guardar un nuevo registro de acceso
    public function store(Request $request)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        // Excluir el campo _token de los datos que se envían a la API
        $data = $request->except('_token');

        $response = Http::post('http://localhost:3000/api/registros_acceso', $data);

        if ($response->successful()) {
            return Redirect::route('registros_acceso.index')->with('success', 'Registro de acceso creado exitosamente');
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al crear el registro de acceso']);
        }
    }

    // Mostrar formulario de edición de registro de acceso
    public function edit($id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        $response = Http::get('http://localhost:3000/api/registros_acceso/' . $id);
        if ($response->successful()) {
            $registro_acceso = $response->json();
            return view('registros_acceso.edit', compact('registro_acceso'));
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al consultar la API']);
        }
    }

    // Actualizar un registro de acceso existente
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        // Excluir los campos _token y _method de los datos que se envían a la API
        $data = $request->except(['_token', '_method']);

        $response = Http::put("http://localhost:3000/api/registros_acceso/{$id}", $data);

        if ($response->successful()) {
            return Redirect::route('registros_acceso.index')->with('success', 'Registro de acceso actualizado exitosamente');
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al actualizar el registro de acceso']);
        }
    }

    // Eliminar un registro de acceso
    public function destroy($id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        $response = Http::delete('http://localhost:3000/api/registros_acceso/' . $id);

        if ($response->successful()) {
            return redirect()->route('registros_acceso.index')->with('success', 'Registro de acceso eliminado exitosamente');
        } else {
            return redirect()->route('registros_acceso.index')->with('error', 'Error al eliminar el registro de acceso');
        }
    }
}