<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function generarPDF(Request $request)
    {
        // Obtener todos los datos de los usuarios desde la vista
        $usuarios = $request->input('usuarios');

        // Decodificar los datos JSON
        $usuarios = json_decode($usuarios, true);

        // Verificar la estructura de los datos
        if (!is_array($usuarios)) {
            return response()->json(['error' => 'Los datos de los usuarios no están en el formato correcto.', 'datos' => $usuarios], 400);
        }

        // Datos para el PDF
        $data = [
            'title' => 'Reporte de Usuarios',
            'usuarios' => $usuarios
        ];

        // Configurar Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar vista y convertirla a HTML
        $html = view('pdf', $data)->render();

        // Cargar el HTML y configurar el papel
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Presentar el PDF en una nueva ventana del navegador
        return $dompdf->stream('reporte_usuarios.pdf', ["Attachment" => false]);
    }

    public function generarExcel(Request $request)
    {
        // Obtener todos los datos de los usuarios desde la vista
        $usuarios = $request->input('usuarios');

        // Decodificar los datos JSON
        $usuarios = json_decode($usuarios, true);

        // Verificar la estructura de los datos
        if (!is_array($usuarios)) {
            return response()->json(['error' => 'Los datos de los usuarios no están en el formato correcto.', 'datos' => $usuarios], 400);
        }

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de la tabla
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Apellido');
        $sheet->setCellValue('D1', 'Correo');
        $sheet->setCellValue('E1', 'Teléfono');
        $sheet->setCellValue('F1', 'Rol');

        // Agregar datos a la hoja de cálculo
        $row = 2;
        foreach ($usuarios as $usuario) {
            if (is_array($usuario)) {
                $sheet->setCellValue('A' . $row, $usuario['usuarios_id']);
                $sheet->setCellValue('B' . $row, $usuario['nombre']);
                $sheet->setCellValue('C' . $row, $usuario['apellido']);
                $sheet->setCellValue('D' . $row, $usuario['correo']);
                $sheet->setCellValue('E' . $row, $usuario['telefono']);
                $sheet->setCellValue('F' . $row, $usuario['rol']);
                $row++;
            }
        }

        // Generar el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'reporte_usuarios.xlsx';

        // Descargar el archivo Excel
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }

    //Registros de Accesos PDF y Excel
    public function generarPDFRegistros(Request $request)
    {
        // Obtener todos los datos de los registros de acceso desde la vista
        $registros_acceso = $request->input('registros_acceso');

        // Decodificar los datos JSON
        $registros_acceso = json_decode($registros_acceso, true);

        // Verificar la estructura de los datos
        if (!is_array($registros_acceso)) {
            return response()->json(['error' => 'Los datos de los registros de acceso no están en el formato correcto.', 'datos' => $registros_acceso], 400);
        }

        // Datos para el PDF
        $data = [
            'title' => 'Reporte de Registros de Acceso',
            'registros_acceso' => $registros_acceso
        ];

        // Configurar Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar vista y convertirla a HTML
        $html = view('pdf_registros', $data)->render();

        // Cargar el HTML y configurar el papel
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Presentar el PDF en una nueva ventana del navegador
        return $dompdf->stream('reporte_registros_acceso.pdf', ["Attachment" => false]);
    }

    public function generarExcelRegistros(Request $request)
    {
        // Obtener todos los datos de los registros de acceso desde la vista
        $registros_acceso = $request->input('registros_acceso');

        // Decodificar los datos JSON
        $registros_acceso = json_decode($registros_acceso, true);

        // Verificar la estructura de los datos
        if (!is_array($registros_acceso)) {
            return response()->json(['error' => 'Los datos de los registros de acceso no están en el formato correcto.', 'datos' => $registros_acceso], 400);
        }

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de la tabla
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Usuario ID');
        $sheet->setCellValue('C1', 'Punto de Acceso ID');
        $sheet->setCellValue('D1', 'Método');
        $sheet->setCellValue('E1', 'Fecha y Hora');
        $sheet->setCellValue('F1', 'Resultado');

        // Agregar datos a la hoja de cálculo
        $row = 2;
        foreach ($registros_acceso as $registro) {
            if (is_array($registro)) {
                $sheet->setCellValue('A' . $row, $registro['registros_acceso_id']);
                $sheet->setCellValue('B' . $row, $registro['usuarios_id']);
                $sheet->setCellValue('C' . $row, $registro['puntos_acceso_id']);
                $sheet->setCellValue('D' . $row, $registro['metodo']);
                $sheet->setCellValue('E' . $row, $registro['fecha_hora']);
                $sheet->setCellValue('F' . $row, $registro['resultado']);
                $row++;
            }
        }

        // Generar el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'reporte_registros_acceso.xlsx';

        // Descargar el archivo Excel
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }

    //Puntos de Accesos PDF y Excel
    public function generarPDFPuntosAcceso(Request $request)
    {
        // Obtener todos los datos de los puntos de acceso desde la vista
        $puntos_acceso = $request->input('puntos_acceso');

        // Decodificar los datos JSON
        $puntos_acceso = json_decode($puntos_acceso, true);

        // Verificar la estructura de los datos
        if (!is_array($puntos_acceso)) {
            return response()->json(['error' => 'Los datos de los puntos de acceso no están en el formato correcto.', 'datos' => $puntos_acceso], 400);
        }

        // Datos para el PDF
        $data = [
            'title' => 'Reporte de Puntos de Acceso',
            'puntos_acceso' => $puntos_acceso
        ];

        // Configurar Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar vista y convertirla a HTML
        $html = view('pdf_puntos_acceso', $data)->render();

        // Cargar el HTML y configurar el papel
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Presentar el PDF en una nueva ventana del navegador
        return $dompdf->stream('reporte_puntos_acceso.pdf', ["Attachment" => false]);
    }

    public function generarExcelPuntosAcceso(Request $request)
    {
        // Obtener todos los datos de los puntos de acceso desde la vista
        $puntos_acceso = $request->input('puntos_acceso');

        // Decodificar los datos JSON
        $puntos_acceso = json_decode($puntos_acceso, true);

        // Verificar la estructura de los datos
        if (!is_array($puntos_acceso)) {
            return response()->json(['error' => 'Los datos de los puntos de acceso no están en el formato correcto.', 'datos' => $puntos_acceso], 400);
        }

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de la tabla
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Ubicación');
        $sheet->setCellValue('D1', 'Tipo');

        // Agregar datos a la hoja de cálculo
        $row = 2;
        foreach ($puntos_acceso as $punto) {
            if (is_array($punto)) {
                $sheet->setCellValue('A' . $row, $punto['puntos_acceso_id']);
                $sheet->setCellValue('B' . $row, $punto['nombre']);
                $sheet->setCellValue('C' . $row, $punto['ubicacion']);
                $sheet->setCellValue('D' . $row, $punto['tipo']);
                $row++;
            }
        }

        // Generar el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'reporte_puntos_acceso.xlsx';

        // Descargar el archivo Excel
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }

    //Notificaciones de Reportes PDF y Excel
    public function generarPDFNotificacionesReportes(Request $request)
    {
        // Obtener todos los datos de las notificaciones de reportes desde la vista
        $notificaciones_reportes = $request->input('notificaciones_reportes');

        // Decodificar los datos JSON
        $notificaciones_reportes = json_decode($notificaciones_reportes, true);

        // Verificar la estructura de los datos
        if (!is_array($notificaciones_reportes)) {
            return response()->json(['error' => 'Los datos de las notificaciones de reportes no están en el formato correcto.', 'datos' => $notificaciones_reportes], 400);
        }

        // Datos para el PDF
        $data = [
            'title' => 'Reporte de Notificaciones de Reportes',
            'notificaciones_reportes' => $notificaciones_reportes
        ];

        // Configurar Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Cargar vista y convertirla a HTML
        $html = view('pdf_notificaciones_reportes', $data)->render();

        // Cargar el HTML y configurar el papel
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Presentar el PDF en una nueva ventana del navegador
        return $dompdf->stream('reporte_notificaciones_reportes.pdf', ["Attachment" => false]);
    }

    public function generarExcelNotificacionesReportes(Request $request)
    {
        // Obtener todos los datos de las notificaciones de reportes desde la vista
        $notificaciones_reportes = $request->input('notificaciones_reportes');

        // Decodificar los datos JSON
        $notificaciones_reportes = json_decode($notificaciones_reportes, true);

        // Verificar la estructura de los datos
        if (!is_array($notificaciones_reportes)) {
            return response()->json(['error' => 'Los datos de las notificaciones de reportes no están en el formato correcto.', 'datos' => $notificaciones_reportes], 400);
        }

        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de la tabla
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Usuario ID');
        $sheet->setCellValue('C1', 'Tipo');
        $sheet->setCellValue('D1', 'Mensaje');
        $sheet->setCellValue('E1', 'Fecha');
        $sheet->setCellValue('F1', 'Leído');

        // Agregar datos a la hoja de cálculo
        $row = 2;
        foreach ($notificaciones_reportes as $reporte) {
            if (is_array($reporte)) {
                $sheet->setCellValue('A' . $row, $reporte['notificaciones_reportes_id']);
                $sheet->setCellValue('B' . $row, $reporte['usuarios_id']);
                $sheet->setCellValue('C' . $row, $reporte['tipo']);
                $sheet->setCellValue('D' . $row, $reporte['mensaje']);
                $sheet->setCellValue('E' . $row, $reporte['fecha']);
                $sheet->setCellValue('F' . $row, $reporte['leido'] ? 'Sí' : 'No');
                $row++;
            }
        }

        // Generar el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'reporte_notificaciones_reportes.xlsx';

        // Descargar el archivo Excel
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }

    //-------------------------------------------------------------------------------------------------------------------------------------


    public function generarReporteCompletoPDF()
    {
        // Obtener todos los registros de la base de datos
        $usuarios = DB::table('usuarios')->get()->toArray(); // Convertir a array

        // Verificar si los datos se recuperan correctamente
        if (empty($usuarios)) {
            logger('No se encontraron usuarios para el PDF completo.');
        } else {
            logger('Usuarios recuperados: ' . json_encode($usuarios));
        }

        $data = [
            'title' => 'Reporte Completo de Usuarios',
            'usuarios' => $usuarios
        ];

        // Configurar Dompdf
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);

        // Renderizar la vista
        $html = view('pdf', $data)->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('reporte_completo_usuarios.pdf', ["Attachment" => false]);
    }

    public function generarReporteCompletoExcel()
    {
        // Obtener todos los registros de la base de datos
        $usuarios = DB::table('usuarios')->get();

        // Crear una nueva hoja de cálculo
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Apellido');
        $sheet->setCellValue('D1', 'Correo Electrónico');
        $sheet->setCellValue('E1', 'Teléfono');
        $sheet->setCellValue('F1', 'Rol');
        $sheet->setCellValue('G1', 'Estado');
        $sheet->setCellValue('H1', 'Fecha Registro');

        // Llenar datos
        $row = 2;
        foreach ($usuarios as $usuario) {
            $sheet->setCellValue('A' . $row, $usuario->usuarios_id);
            $sheet->setCellValue('B' . $row, $usuario->nombre);
            $sheet->setCellValue('C' . $row, $usuario->apellido);
            $sheet->setCellValue('D' . $row, $usuario->correo);
            $sheet->setCellValue('E' . $row, $usuario->telefono);
            $sheet->setCellValue('F' . $row, $usuario->rol);
            $sheet->setCellValue('G' . $row, $usuario->estado);
            $sheet->setCellValue('H' . $row, $usuario->fecha_registro);
            $row++;
        }

        // Crear el archivo Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'reporte_completo_usuarios.xlsx';

        // Descargar el archivo Excel
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }

    public function generarPDFRegistrosCompleto()
    {
        // Obtener todos los registros de acceso desde la base de datos
        $registros_acceso = DB::table('registros_acceso')->get()->toArray();

        // Verificar si hay registros
        if (empty($registros_acceso)) {
            return response()->json(['error' => 'No se encontraron registros de acceso para generar el reporte.'], 404);
        }

        // Datos para el PDF
        $data = [
            'title' => 'Reporte Completo de Registros de Acceso',
            'registros_acceso' => $registros_acceso
        ];

        // Configurar Dompdf
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);

        // Cargar vista y convertirla a HTML
        $html = view('pdf_registros', $data)->render();

        // Cargar el HTML y configurar el papel
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Presentar el PDF en una nueva ventana del navegador
        return $dompdf->stream('reporte_completo_registros_acceso.pdf', ["Attachment" => false]);
    }

    public function generarExcelRegistrosCompleto()
    {
        // Obtener todos los registros de acceso desde la base de datos
        $registros_acceso = DB::table('registros_acceso')->get()->toArray();

        // Verificar si hay registros
        if (empty($registros_acceso)) {
            return response()->json(['error' => 'No se encontraron registros de acceso para generar el reporte.'], 404);
        }

        // Crear una nueva hoja de cálculo
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de la tabla
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Usuario ID');
        $sheet->setCellValue('C1', 'Punto de Acceso ID');
        $sheet->setCellValue('D1', 'Método');
        $sheet->setCellValue('E1', 'Fecha y Hora');
        $sheet->setCellValue('F1', 'Resultado');

        // Agregar datos a la hoja de cálculo
        $row = 2;
        foreach ($registros_acceso as $registro) {
            $sheet->setCellValue('A' . $row, $registro->registros_acceso_id);
            $sheet->setCellValue('B' . $row, $registro->usuarios_id);
            $sheet->setCellValue('C' . $row, $registro->puntos_acceso_id);
            $sheet->setCellValue('D' . $row, $registro->metodo);
            $sheet->setCellValue('E' . $row, $registro->fecha_hora);
            $sheet->setCellValue('F' . $row, $registro->resultado);
            $row++;
        }

        // Generar el archivo Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'reporte_completo_registros_acceso.xlsx';

        // Descargar el archivo Excel
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }


    public function generarPDFPuntosAccesoCompleto()
    {
        // Obtener todos los puntos de acceso desde la base de datos
        $puntos_acceso = DB::table('puntos_acceso')->get()->toArray();

        // Verificar si hay registros
        if (empty($puntos_acceso)) {
            return response()->json(['error' => 'No se encontraron puntos de acceso para generar el reporte.'], 404);
        }

        // Datos para el PDF
        $data = [
            'title' => 'Reporte Completo de Puntos de Acceso',
            'puntos_acceso' => $puntos_acceso
        ];

        // Configurar Dompdf
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);

        // Renderizar la vista y cargar en Dompdf
        $html = view('pdf_puntos_acceso', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Presentar el PDF en el navegador
        return $dompdf->stream('reporte_completo_puntos_acceso.pdf', ["Attachment" => false]);
    }

    public function generarExcelPuntosAccesoCompleto()
    {
        // Obtener todos los puntos de acceso desde la base de datos
        $puntos_acceso = DB::table('puntos_acceso')->get()->toArray();

        // Verificar si hay registros
        if (empty($puntos_acceso)) {
            return response()->json(['error' => 'No se encontraron puntos de acceso para generar el reporte.'], 404);
        }

        // Crear una nueva hoja de cálculo
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de la tabla
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Ubicación');
        $sheet->setCellValue('D1', 'Tipo');

        // Agregar datos a la hoja de cálculo
        $row = 2;
        foreach ($puntos_acceso as $punto) {
            $sheet->setCellValue('A' . $row, $punto->puntos_acceso_id);
            $sheet->setCellValue('B' . $row, $punto->nombre);
            $sheet->setCellValue('C' . $row, $punto->ubicacion);
            $sheet->setCellValue('D' . $row, $punto->tipo);
            $row++;
        }

        // Generar el archivo Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'reporte_completo_puntos_acceso.xlsx';

        // Descargar el archivo Excel
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }


    public function generarPDFNotificacionesReportesCompleto()
    {
        // Obtener todas las notificaciones de reportes desde la base de datos
        $notificaciones_reportes = DB::table('notificaciones_reportes')->get()->toArray();

        // Verificar si hay registros
        if (empty($notificaciones_reportes)) {
            return response()->json(['error' => 'No se encontraron notificaciones de reportes para generar el reporte.'], 404);
        }

        // Datos para el PDF
        $data = [
            'title' => 'Reporte Completo de Notificaciones de Reportes',
            'notificaciones_reportes' => $notificaciones_reportes
        ];

        // Configurar Dompdf
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);

        // Renderizar la vista y cargar en Dompdf
        $html = view('pdf_notificaciones_reportes', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Presentar el PDF en el navegador
        return $dompdf->stream('reporte_completo_notificaciones_reportes.pdf', ["Attachment" => false]);
    }

    public function generarExcelNotificacionesReportesCompleto()
    {
        // Obtener todas las notificaciones de reportes desde la base de datos
        $notificaciones_reportes = DB::table('notificaciones_reportes')->get()->toArray();

        // Verificar si hay registros
        if (empty($notificaciones_reportes)) {
            return response()->json(['error' => 'No se encontraron notificaciones de reportes para generar el reporte.'], 404);
        }

        // Crear una nueva hoja de cálculo
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de la tabla
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Usuario ID');
        $sheet->setCellValue('C1', 'Tipo');
        $sheet->setCellValue('D1', 'Mensaje');
        $sheet->setCellValue('E1', 'Fecha');
        $sheet->setCellValue('F1', 'Leído');

        // Agregar datos a la hoja de cálculo
        $row = 2;
        foreach ($notificaciones_reportes as $reporte) {
            $sheet->setCellValue('A' . $row, $reporte->notificaciones_reportes_id);
            $sheet->setCellValue('B' . $row, $reporte->usuarios_id);
            $sheet->setCellValue('C' . $row, $reporte->tipo);
            $sheet->setCellValue('D' . $row, $reporte->mensaje);
            $sheet->setCellValue('E' . $row, $reporte->fecha);
            $sheet->setCellValue('F' . $row, $reporte->leido ? 'Sí' : 'No');
            $row++;
        }

        // Generar el archivo Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'reporte_completo_notificaciones_reportes.xlsx';

        // Descargar el archivo Excel
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }
}
