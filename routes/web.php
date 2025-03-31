<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\NotificacionesReportesController;
use App\Http\Controllers\RegistrosAccesoController;
use App\Http\Controllers\PuntosAccesoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\AccesosController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\AccessController;


// ------------------------- Página de Bienvenida -------------------------

Route::get('/', function () {
    return view('landing'); // Se cambia "welcome" por "landing"
});

// Ruta para registrar accesos desde ESP32
Route::get('/registrar-acceso', [AccessController::class, 'registrarAcceso'])->name('registrar.acceso');
// Ruta para obtener datos desde el ESP32
Route::get('/perfil/datos-esp32', [PerfilController::class, 'obtenerDatosESP32'])->name('perfil.datos-esp32');
// Ruta para mostrar la vista perfil_usuario
Route::get('/perfil-usuario', [PerfilController::class, 'mostrarVistaPerfilUsuario'])->name('perfil.usuario');
// Ruta para mostrar la vista con los datos obtenidos del ESP32
//Route::get('/perfil-usuario', [PerfilController::class, 'mostrarVistaPerfilUsuario'])->name('perfil.usuario');

// Ruta para registrar datos obtenidos del ESP32 en la base de datos
Route::post('/registrar-acceso', [PerfilController::class, 'registrarAccesoDesdeESP32'])->name('registrar.acceso');
// ------------------------- Rutas de Autenticación -------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

// ------------------------- Ruta de Dashboard -------------------------
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/historial', [HistorialController::class, 'index'])->name('historial');
Route::get('/mis-accesos', [AccesosController::class, 'index'])->name('mis-accesos')->middleware('auth');
Route::get('/historial', [HistorialController::class, 'index'])->middleware('auth');

// ------------------------- Rutas para Usuarios -------------------------
Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::get('/usuarios/{usuarios_id}', [UsuariosController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{usuarios_id}', [UsuariosController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{usuarios_id}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

// ------------------------- Rutas para Notificaciones y Reportes -------------------------
Route::get('/notificaciones_reportes', [NotificacionesReportesController::class, 'index'])->name('notificaciones_reportes.index');
Route::post('/notificaciones_reportes', [NotificacionesReportesController::class, 'store'])->name('notificaciones_reportes.store');
Route::get('/notificaciones_reportes/create', [NotificacionesReportesController::class, 'create'])->name('notificaciones_reportes.create');
Route::get('/notificaciones_reportes/{notificaciones_reportes_id}', [NotificacionesReportesController::class, 'edit'])->name('notificaciones_reportes.edit');
Route::put('/notificaciones_reportes/{notificaciones_reportes_id}', [NotificacionesReportesController::class, 'update'])->name('notificaciones_reportes.update');
Route::delete('/notificaciones_reportes/{notificaciones_reportes_id}', [NotificacionesReportesController::class, 'destroy'])->name('notificaciones_reportes.destroy');

// ------------------------- Rutas para Registros de Acceso -------------------------
Route::get('/registros_acceso', [RegistrosAccesoController::class, 'index'])->name('registros_acceso.index');
Route::post('/registros_acceso', [RegistrosAccesoController::class, 'store'])->name('registros_acceso.store');
Route::get('/registros_acceso/create', [RegistrosAccesoController::class, 'create'])->name('registros_acceso.create');
Route::get('/registros_acceso/{registros_acceso_id}', [RegistrosAccesoController::class, 'edit'])->name('registros_acceso.edit');
Route::put('/registros_acceso/{registros_acceso_id}', [RegistrosAccesoController::class, 'update'])->name('registros_acceso.update');
Route::delete('/registros_acceso/{registros_acceso_id}', [RegistrosAccesoController::class, 'destroy'])->name('registros_acceso.destroy');

// ------------------------- Rutas para Puntos de Acceso -------------------------
Route::get('/puntos_acceso', [PuntosAccesoController::class, 'index'])->name('puntos_acceso.index');
Route::post('/puntos_acceso', [PuntosAccesoController::class, 'store'])->name('puntos_acceso.store');
Route::get('/puntos_acceso/create', [PuntosAccesoController::class, 'create'])->name('puntos_acceso.create');
Route::get('/puntos_acceso/{puntos_acceso_id}', [PuntosAccesoController::class, 'edit'])->name('puntos_acceso.edit');
Route::put('/puntos_acceso/{puntos_acceso_id}', [PuntosAccesoController::class, 'update'])->name('puntos_acceso.update');
Route::delete('/puntos_acceso/{puntos_acceso_id}', [PuntosAccesoController::class, 'destroy'])->name('puntos_acceso.destroy');

// ------------------------- Rutas para Secciones Públicas -------------------------
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
// Rutas para las secciones públicas
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ------------------------- Rutas para Reportes (PDF y Excel) -------------------------
Route::get('/reportes/generar-pdf', [ReportController::class, 'generarPDF'])->name('generar-pdf');
Route::get('/reportes/generar-excel', [ReportController::class, 'generarExcel'])->name('generar-excel');

// Reportes para Registros de Acceso
Route::get('/reportes/generar-pdf-registros', [ReportController::class, 'generarPDFRegistros'])->name('generar-pdf-registros');
Route::get('/reportes/generar-excel-registros', [ReportController::class, 'generarExcelRegistros'])->name('generar-excel-registros');

// Reportes para Puntos de Acceso
Route::get('/reportes/generar-pdf-puntos-acceso', [ReportController::class, 'generarPDFPuntosAcceso'])->name('generar-pdf-puntos-acceso');
Route::get('/reportes/generar-excel-puntos-acceso', [ReportController::class, 'generarExcelPuntosAcceso'])->name('generar-excel-puntos-acceso');

// Reportes para Notificaciones y Reportes
Route::get('/reportes/generar-pdf-notificaciones-reportes', [ReportController::class, 'generarPDFNotificacionesReportes'])->name('generar-pdf-notificaciones-reportes');
Route::get('/reportes/generar-excel-notificaciones-reportes', [ReportController::class, 'generarExcelNotificacionesReportes'])->name('generar-excel-notificaciones-reportes');

// ------------------------- Rutas para Importaciones -------------------------
Route::get('/import', [ImportController::class, 'showImportForm'])->name('import.form');

// Ruta para importar reportes
Route::post('/import/reportes', [ImportController::class, 'importUsuarios'])->name('import.reportes');

// Importación de Usuarios
Route::post('/import/usuarios', [ImportController::class, 'importUsuarios'])->name('import.usuarios');

// Importación de Notificaciones/Reportes
Route::post('/import/notificaciones', [ImportController::class, 'importNotificacionesReportes'])->name('import.notificaciones');

// Importación de Registros de Acceso
Route::post('/importar-registros-acceso', [ImportController::class, 'importRegistrosAcceso'])->name('importar-registros-acceso');

// Importación de Puntos de Acceso
Route::post('/importar-puntos-acceso', [ImportController::class, 'importPuntosAcceso'])->name('importar-puntos-acceso');

// ------------------------- Rutas para Reportes Completos -------------------------
// Reporte Completo de Usuarios
Route::get('/reporte-completo-pdf', [ReportController::class, 'generarReporteCompletoPDF'])->name('reporte.completo.pdf');
Route::get('/reporte/completo/excel', [ReportController::class, 'generarReporteCompletoExcel'])->name('reporte.completo.excel');

// Reporte Completo de Registros de Acceso
Route::get('/reporte-completo-registros-pdf', [ReportController::class, 'generarPDFRegistrosCompleto'])->name('reporte-completo-pdf-registros');
Route::get('/reporte-completo-registros-excel', [ReportController::class, 'generarExcelRegistrosCompleto'])->name('reporte-completo-excel-registros');

// Reporte Completo de Puntos de Acceso
Route::get('/reporte-completo-puntos-acceso-pdf', [ReportController::class, 'generarPDFPuntosAccesoCompleto'])->name('reporte-completo-pdf-puntos-acceso');
Route::get('/reporte-completo-puntos-acceso-excel', [ReportController::class, 'generarExcelPuntosAccesoCompleto'])->name('reporte-completo-excel-puntos-acceso');

// Reporte Completo de Notificaciones y Reportes
Route::get('/reporte-completo-notificaciones-reportes-pdf', [ReportController::class, 'generarPDFNotificacionesReportesCompleto'])->name('reporte-completo-pdf-notificaciones-reportes');
Route::get('/reporte-completo-notificaciones-reportes-excel', [ReportController::class, 'generarExcelNotificacionesReportesCompleto'])->name('reporte-completo-excel-notificaciones-reportes');