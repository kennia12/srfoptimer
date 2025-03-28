<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class UsuariosController extends Controller
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

    public function index(Request $request)
    {
        $query = $request->input('query');
    
        // Obtener y filtrar los usuarios
        $responseUsuarios = Http::get('http://localhost:3000/api/usuarios');
        $dataUsuarios = collect($responseUsuarios->json());
    
        if ($query) {
            $dataUsuarios = $dataUsuarios->filter(function ($item) use ($query) {
                return stripos($item['nombre'], $query) !== false ||
                    stripos($item['correo'], $query) !== false ||
                    stripos($item['rol'], $query) !== false;
            });
        }
    
        // Agrupar usuarios por rol para el gráfico
        $rolesData = $dataUsuarios->groupBy('rol')->map(function ($users) {
            return $users->count();
        });
    
        // Paginación para los usuarios
        $currentPageUsuarios = $request->input('page_usuarios', 1);
        $perPageUsuarios = 10;
        $paginatedUsuarios = new LengthAwarePaginator(
            $dataUsuarios->forPage($currentPageUsuarios, $perPageUsuarios),
            $dataUsuarios->count(),
            $perPageUsuarios,
            $currentPageUsuarios,
            ['path' => $request->url(), 'query' => $request->query(), 'pageName' => 'page_usuarios']
        );
    
        return view('usuarios', [
            'usuarios' => $paginatedUsuarios,
            'query' => $query,
            'rolesData' => $rolesData
        ]);
    }     

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $response = Http::post('http://localhost:3000/api/usuarios', $data);

        if ($response->successful()) {
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
        } else {
            return redirect()->route('usuarios.index')->with('error', 'Error al crear el usuario.');
        }
    }

    public function edit($usuarios_id)
    {
        $response = Http::get('http://localhost:3000/api/usuarios/' . $usuarios_id);
        if ($response->successful()) {
            $usuario = $response->json();
            return view('usuarios.edit', compact('usuario'));
        } else {
            return redirect()->route('usuarios.index')->with('error', 'Error al consultar el usuario.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);

        $response = Http::put('http://localhost:3000/api/usuarios/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
        } else {
            return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el usuario.');
        }
    }

    public function destroy($id)
    {
        $response = Http::delete('http://localhost:3000/api/usuarios/' . $id);

        if ($response->successful()) {
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
        } else {
            return redirect()->route('usuarios.index')->with('error', 'Error al eliminar el usuario.');
        }
    }
}
