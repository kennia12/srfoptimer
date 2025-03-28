<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    // ------------------------- Usuarios -------------------------

    // Método para mostrar el formulario de importación (opcional)
    public function showImportForm()
    {
        return view('import'); // Vista con el formulario de importación
    }

    // Método para manejar la importación de Usuarios
    public function importUsuarios(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            // Procesar el archivo Excel
            [$successMessage, $omittedCount, $newRecordsCount] = $this->processExcel(
                $request->file('file'),
                'usuarios'
            );

            // Retornar respuesta en JSON
            return response()->json([
                'success' => $successMessage,
                'nuevos_registros' => $newRecordsCount,
                'registros_omitidos' => $omittedCount,
            ]);
        } catch (\Exception $e) {
            // Registrar el error en el log para depuración
            Log::error('Error en importación de usuarios: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error durante la importación: ' . $e->getMessage(),
            ], 500); // Devolver error en JSON
        }
    }

    // Método genérico para procesar archivos Excel
    private function processExcel($file, $table)
    {
        try {
            $spreadsheet = IOFactory::load($file->getPathname());
        } catch (\Exception $e) {
            throw new \Exception('El archivo Excel no es válido o está corrupto.');
        }

        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (empty($rows) || count($rows) <= 1) {
            throw new \Exception('El archivo no contiene registros válidos.');
        }

        // Verificar encabezados
        $header = $rows[0];
        if ($table === 'usuarios') {
            $requiredHeaders = ['usuarios_id', 'nombre', 'apellido', 'correo', 'telefono', 'rol', 'password'];
        } elseif ($table === 'notificaciones_reportes') {
            $requiredHeaders = ['usuarios_id', 'tipo', 'mensaje', 'fecha', 'leido'];
        } elseif ($table === 'registros_acceso') {
            $requiredHeaders = ['usuarios_id', 'puntos_acceso_id', 'metodo', 'fecha_hora', 'resultado'];
        } elseif ($table === 'puntos_acceso') { // Agregar encabezados requeridos para "puntos_acceso"
            $requiredHeaders = ['nombre', 'ubicacion', 'tipo'];
        } else {
            throw new \Exception("La tabla {$table} no está soportada para la importación.");
        }

        foreach ($requiredHeaders as $required) {
            if (!in_array($required, $header)) {
                throw new \Exception("Falta la columna requerida: {$required}");
            }
        }

        unset($rows[0]); // Eliminar la cabecera del conjunto de filas

        $newRecordsCount = 0;
        $omittedCount = 0;

        foreach ($rows as $row) {
            $data = array_combine($header, $row);

            // Lógica para la tabla "usuarios"
            if ($table === 'usuarios') {
                $result = $this->validateAndInsertUsuario($data);
            }
            // Lógica para la tabla "notificaciones_reportes"
            elseif ($table === 'notificaciones_reportes') {
                $result = $this->validateAndInsertNotificacionReporte($data);
            }
            // Lógica para la tabla "registros_acceso"
            elseif ($table === 'registros_acceso') {
                $result = $this->validateAndInsertRegistroAcceso($data);
            }
            // Lógica para la tabla "puntos_acceso"
            elseif ($table === 'puntos_acceso') {
                $result = $this->validateAndInsertPuntosAcceso($data);
            }

            // Contadores según el resultado
            if ($result) {
                $newRecordsCount++;
            } else {
                $omittedCount++;
            }
        }

        return ['Importación completada con éxito.', $omittedCount, $newRecordsCount];
    }

    // Método para validar e insertar un registro en la tabla Usuarios
    private function validateAndInsertUsuario($data)
    {
        try {
            // Validaciones específicas para los usuarios
            if (!isset($data['correo']) || !filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('El correo proporcionado no es válido.');
            }

            if (!in_array($data['rol'], ['Admin', 'Usuario', 'Guardia'])) {
                throw new \Exception('El rol proporcionado no es válido.');
            }

            // Verificar duplicados según el correo
            if (DB::table('usuarios')->where('correo', $data['correo'])->exists()) {
                throw new \Exception('Ya existe un usuario con este correo.');
            }

            // Insertar el registro en la base de datos
            DB::table('usuarios')->insert([
                'usuarios_id' => $data['usuarios_id'] ?? null,
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'correo' => $data['correo'],
                'telefono' => $data['telefono'] ?? null,
                'rol' => $data['rol'],
                'estado' => $data['estado'] ?? 'Activo',
                'password' => bcrypt($data['password']),
                'rfid' => Str::random(10), // Generar automáticamente el RFID
                'hash_rostro' => Str::random(64), // Generar automáticamente el hash del rostro
                'fecha_registro' => now(),
            ]);

            return true; // Registro insertado con éxito
        } catch (\Exception $e) {
            // Registrar el error específico
            Log::error('Error al insertar usuario: ' . $e->getMessage());
            return false; // Retornar falso para indicar que el registro falló
        }
    }

    // ------------------------- Notificaciones/Reportes -------------------------
    public function importNotificacionesReportes(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            // Procesar el archivo Excel
            [$successMessage, $omittedCount, $newRecordsCount] = $this->processExcel(
                $request->file('file'),
                'notificaciones_reportes'
            );

            // Retornar respuesta en JSON
            return response()->json([
                'success' => $successMessage,
                'nuevos_registros' => $newRecordsCount,
                'registros_omitidos' => $omittedCount,
            ]);
        } catch (\Exception $e) {
            // Registrar el error en el log para depuración
            Log::error('Error en importación de notificaciones/reportes: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error durante la importación: ' . $e->getMessage(),
            ], 500); // Devolver error en JSON
        }
    }

    // Método para validar e insertar un registro en la tabla Notificaciones/Reportes
    private function validateAndInsertNotificacionReporte($data)
    {
        try {
            // Validaciones específicas para las notificaciones/reportes
            if (!isset($data['usuarios_id']) || !is_numeric($data['usuarios_id'])) {
                throw new \Exception('El usuarios_id proporcionado no es válido.');
            }

            if (!in_array($data['tipo'], ['Notificación', 'Reporte'])) {
                throw new \Exception('El tipo proporcionado no es válido.');
            }

            if (!isset($data['mensaje']) || empty($data['mensaje'])) {
                throw new \Exception('El mensaje no puede estar vacío.');
            }

            // Insertar el registro en la base de datos
            DB::table('notificaciones_reportes')->insert([
                'usuarios_id' => $data['usuarios_id'],
                'tipo' => $data['tipo'],
                'mensaje' => $data['mensaje'],
                'fecha' => $data['fecha'] ?? now(),
                'leido' => isset($data['leido']) && $data['leido'] === '1',
            ]);

            return true; // Registro insertado con éxito
        } catch (\Exception $e) {
            // Registrar el error específico
            Log::error('Error al insertar notificación/reporte: ' . $e->getMessage());
            return false; // Retornar falso para indicar que el registro falló
        }
    }

    // ------------------------- Puntos/Acceso -------------------------
    public function importPuntosAcceso(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            // Procesar el archivo Excel
            [$successMessage, $omittedCount, $newRecordsCount] = $this->processExcel(
                $request->file('file'),
                'puntos_acceso'
            );

            // Retornar respuesta en JSON
            return response()->json([
                'success' => $successMessage,
                'nuevos_registros' => $newRecordsCount,
                'registros_omitidos' => $omittedCount,
            ]);
        } catch (\Exception $e) {
            // Registrar el error en el log para depuración
            Log::error('Error en importación de puntos de acceso: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error durante la importación: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Método para validar e insertar un registro en la tabla "puntos_acceso"
    private function validateAndInsertPuntosAcceso($data)
    {
        try {
            // Validaciones específicas para los puntos de acceso
            if (!isset($data['nombre']) || empty($data['nombre'])) {
                throw new \Exception('El nombre proporcionado no puede estar vacío.');
            }

            if (!isset($data['ubicacion']) || empty($data['ubicacion'])) {
                throw new \Exception('La ubicación proporcionada no puede estar vacía.');
            }

            if (!in_array($data['tipo'], ['Entrada', 'Salida', 'Ambos'])) {
                throw new \Exception('El tipo proporcionado no es válido.');
            }

            // Verificar si el registro ya existe
            $exists = DB::table('puntos_acceso')->where([
                ['nombre', '=', $data['nombre']],
                ['ubicacion', '=', $data['ubicacion']],
                ['tipo', '=', $data['tipo']],
            ])->exists();

            if ($exists) {
                return false; // Omitir registro duplicado
            }

            // Insertar el registro en la base de datos
            DB::table('puntos_acceso')->insert([
                'nombre' => $data['nombre'],
                'ubicacion' => $data['ubicacion'],
                'tipo' => $data['tipo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return true; // Registro insertado con éxito
        } catch (\Exception $e) {
            // Registrar el error específico
            Log::error('Error al insertar punto de acceso: ' . $e->getMessage());
            return false; // Retornar falso para indicar que el registro falló
        }
    }

    // ------------------------- Registros/Acceso -------------------------
    // ------------------------- Registros de Acceso -------------------------
    public function importRegistrosAcceso(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            // Procesar el archivo Excel
            [$successMessage, $omittedCount, $newRecordsCount] = $this->processExcel(
                $request->file('file'),
                'registros_acceso'
            );

            // Retornar respuesta en JSON
            return response()->json([
                'success' => $successMessage,
                'nuevos_registros' => $newRecordsCount,
                'registros_omitidos' => $omittedCount,
            ]);
        } catch (\Exception $e) {
            // Registrar el error en el log para depuración
            Log::error('Error en importación de registros de acceso: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error durante la importación: ' . $e->getMessage(),
            ], 500); // Devolver error en JSON
        }
    }

    // Método para validar e insertar un registro en la tabla Registros de Acceso
    private function validateAndInsertRegistroAcceso($data)
    {
        try {
            // Validaciones específicas para los registros de acceso
            if (!isset($data['usuarios_id']) || !is_numeric($data['usuarios_id'])) {
                throw new \Exception('El usuarios_id proporcionado no es válido.');
            }

            if (!isset($data['puntos_acceso_id']) || !is_numeric($data['puntos_acceso_id'])) {
                throw new \Exception('El puntos_acceso_id proporcionado no es válido.');
            }

            if (!in_array($data['metodo'], ['RFID', 'Reconocimiento Facial'])) {
                throw new \Exception('El método proporcionado no es válido.');
            }

            if (!isset($data['fecha_hora']) || !strtotime($data['fecha_hora'])) {
                throw new \Exception('La fecha y hora proporcionadas no son válidas.');
            }

            if (!in_array($data['resultado'], ['Permitido', 'Denegado'])) {
                throw new \Exception('El resultado proporcionado no es válido.');
            }

            // Insertar el registro en la base de datos
            DB::table('registros_acceso')->insert([
                'usuarios_id' => $data['usuarios_id'],
                'puntos_acceso_id' => $data['puntos_acceso_id'],
                'metodo' => $data['metodo'],
                'fecha_hora' => $data['fecha_hora'],
                'resultado' => $data['resultado'],
            ]);

            return true; // Registro insertado con éxito
        } catch (\Exception $e) {
            // Registrar el error específico
            Log::error('Error al insertar registro de acceso: ' . $e->getMessage());
            return false; // Retornar falso para indicar que el registro falló
        }
    }
}
