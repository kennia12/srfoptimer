<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Cliente HTTP
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    private $esp32Url = "192.168.137.161"; // Reemplaza con la IP del ESP32
    public function mostrarVistaPerfilUsuario()
    {
        // Datos de ejemplo
        $datos = [
            'lastRFID' => '432FCA01', // Ejemplo de datos
            'accessMessage' => 'Acceso CORRECTO',
            'motionDetected' => true,
            'motionMessage' => 'Alerta: Movimiento detectado en la zona 1.'
        ];

        // Retornar la vista perfil_usuario con los datos
        return view('perfil_usuario', compact('datos'));
    }
    // Función para obtener datos del ESP32 y almacenarlos en la tabla
    public function registrarAcceso()
    {
        $response = Http::get($this->esp32Url . "/sendAccessData");

        // Validar respuesta del ESP32
        if ($response->ok()) {
            $data = $response->json();

            // Insertar en la tabla registros_acceso
            DB::table('registros_acceso')->insert([
                'usuarios_id' => $data['usuarios_id'],
                'puntos_acceso_id' => $data['puntos_acceso_id'],
                'metodo' => $data['metodo'],
                'fecha_hora' => now(), // Fecha y hora actuales
                'resultado' => $data['resultado'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Registro de acceso agregado correctamente.');
        } else {
            return redirect()->back()->withErrors('No se pudo obtener datos del ESP32.');
        }
    }

    // Función para mostrar registros de acceso
    public function mostrarRegistrosAcceso()
    {
        // Obtener los registros de acceso de la base de datos
        $registros = DB::table('registros_acceso')
            ->join('tb_usuarios', 'registros_acceso.usuarios_id', '=', 'tb_usuarios.id_usuario')
            ->join('puntos_acceso', 'registros_acceso.puntos_acceso_id', '=', 'puntos_acceso.id_punto_acceso')
            ->select(
                'registros_acceso.registros_acceso_id',
                'tb_usuarios.nombre as usuario',
                'puntos_acceso.nombre as punto_acceso',
                'registros_acceso.metodo',
                'registros_acceso.fecha_hora',
                'registros_acceso.resultado'
            )
            ->paginate(10); // Paginación de 10 registros por página

        // Retornar la vista con los registros
        return view('registros_acceso.index', compact('registros'));
    }

    // Función para eliminar un registro por su ID
    public function eliminarRegistroAcceso($id)
    {
        // Eliminar el registro por su ID
        $deleted = DB::table('registros_acceso')->where('registros_acceso_id', $id)->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Registro de acceso eliminado correctamente.');
        } else {
            return redirect()->back()->withErrors('No se pudo eliminar el registro.');
        }
    }

    // Función para mostrar detalles de un registro específico
    public function detallesRegistroAcceso($id)
    {
        // Obtener los detalles del registro específico
        $registro = DB::table('registros_acceso')
            ->join('tb_usuarios', 'registros_acceso.usuarios_id', '=', 'tb_usuarios.id_usuario')
            ->join('puntos_acceso', 'registros_acceso.puntos_acceso_id', '=', 'puntos_acceso.id_punto_acceso')
            ->select(
                'registros_acceso.registros_acceso_id',
                'tb_usuarios.nombre as usuario',
                'puntos_acceso.nombre as punto_acceso',
                'registros_acceso.metodo',
                'registros_acceso.fecha_hora',
                'registros_acceso.resultado'
            )
            ->where('registros_acceso.registros_acceso_id', $id)
            ->first();

        if ($registro) {
            return view('registros_acceso.detalles', compact('registro'));
        } else {
            return redirect()->back()->withErrors('Registro no encontrado.');
        }
    }
}
