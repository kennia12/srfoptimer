<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class NotificacionesReportesController extends Controller
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

    // Listar todas las notificaciones y reportes
    public function index(Request $request)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario
    
        $query = $request->input('query');
    
        // Obtener y filtrar las notificaciones de reportes
        $response = Http::get('http://localhost:3000/api/notificaciones_reportes');
        if ($response->successful()) {
            $notificaciones_reportes = collect($response->json()); // Convertir a colección
    
            if ($query) {
                $notificaciones_reportes = $notificaciones_reportes->filter(function ($item) use ($query) {
                    return stripos($item['tipo'], $query) !== false ||
                        stripos($item['mensaje'], $query) !== false ||
                        stripos($item['fecha'], $query) !== false;
                });
            }
    
            // Agrupar notificaciones por tipo y estado de lectura
            $tiposData = $notificaciones_reportes->groupBy('tipo')->map(function ($reports) {
                return $reports->count();
            });
    
            $leidosData = $notificaciones_reportes->groupBy('leido')->map(function ($reports) {
                return $reports->count();
            });
    
            // Paginación para las notificaciones de reportes
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10;
            $currentItems = $notificaciones_reportes->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $paginatedNotificacionesReportes = new LengthAwarePaginator($currentItems, $notificaciones_reportes->count(), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath()
            ]);
    
            return view('notificaciones_reportes', [
                'notificaciones_reportes' => $paginatedNotificacionesReportes,
                'query' => $query,
                'tiposData' => $tiposData,
                'leidosData' => $leidosData
            ]);
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al consultar la API']);
        }
    }     

    // Mostrar formulario de creación de notificación o reporte
    public function create()
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        return view('notificaciones_reportes.create');
    }

    // Guardar una nueva notificación o reporte
    public function store(Request $request)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        // Excluir el campo _token de los datos que se envían a la API
        $data = $request->except('_token');

        $response = Http::post('http://localhost:3000/api/notificaciones_reportes', $data);

        if ($response->successful()) {
            return Redirect::route('notificaciones_reportes.index')->with('success', 'Notificación/Reporte creado exitosamente');
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al crear la notificación/reporte']);
        }
    }

    // Mostrar formulario de edición de notificación o reporte
    public function edit($id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        $response = Http::get('http://localhost:3000/api/notificaciones_reportes/' . $id);
        if ($response->successful()) {
            $notificacion_reporte = $response->json();
            return view('notificaciones_reportes.edit', compact('notificacion_reporte'));
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al consultar la API']);
        }
    }

    // Actualizar una notificación o reporte existente
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        // Excluir los campos _token y _method de los datos que se envían a la API
        $data = $request->except(['_token', '_method']);

        $response = Http::put("http://localhost:3000/api/notificaciones_reportes/{$id}", $data);

        if ($response->successful()) {
            return Redirect::route('notificaciones_reportes.index')->with('success', 'Notificación/Reporte actualizada exitosamente');
        } else {
            return Redirect::back()->withErrors(['error' => 'Error al actualizar la notificación/reporte']);
        }
    }

    // Eliminar una notificación o reporte
    public function destroy($id)
    {
        $this->authorizeAdmin(); // Autorizar solo a administradores
        session()->regenerate(); // Regenerar la sesión después de autenticar al usuario

        $response = Http::delete('http://localhost:3000/api/notificaciones_reportes/' . $id);

        if ($response->successful()) {
            return redirect()->route('notificaciones_reportes.index')->with('success', 'Notificación o reporte eliminado exitosamente');
        } else {
            return redirect()->route('notificaciones_reportes.index')->with('error', 'Error al eliminar la notificación o reporte');
        }
    }
}
