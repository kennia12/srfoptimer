<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones y Reportes</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Cinzel:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/navbar_2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notificaciones_reportes.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SRFOptimer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Barra de Búsqueda -->
                <form action="{{ route('notificaciones_reportes.index') }}" method="GET"
                    class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Buscar" name="query"
                            value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit" style="margin-left: 5px;">
                                <i class="fas fa-search"></i> <!-- Icono de búsqueda -->
                            </button>
                            <a href="{{ route('notificaciones_reportes.index') }}" class="btn btn-outline-danger"
                                style="margin-left: 5px;">
                                <i class="fas fa-times"></i> <!-- Icono de limpiar -->
                            </a>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav ms-auto">
                    <!-- Menú Principal -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bars"></i> Menú Principal
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <li><a class="dropdown-item" href="{{ route('usuarios.index') }}"><i
                                        class="fas fa-users icon-users"></i> Usuarios</a></li>
                            <li><a class="dropdown-item" href="{{ route('notificaciones_reportes.index') }}"><i
                                        class="fas fa-bell icon-notifications"></i> Notificaciones/Reportes</a></li>
                            <li><a class="dropdown-item" href="{{ route('registros_acceso.index') }}"><i
                                        class="fas fa-file-alt icon-records"></i> Registros de Acceso</a></li>
                            <li><a class="dropdown-item" href="{{ route('puntos_acceso.index') }}"><i
                                        class="fas fa-map-marker-alt icon-access-points"></i> Puntos de Acceso</a></li>
                        </ul>
                    </li>

                    <!-- Menú para Importar/Exportar Reportes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-alt icon-reports"></i> Reportes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                            <li class="dropdown-header">Importar Notificaciones/Reportes</li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#importNotificacionesModal">
                                    <i class="fas fa-file-excel icon-excel"></i> Importar Excel
                                </a>
                            </li>
                            <hr class="dropdown-divider">
                            <li class="dropdown-header">Exportar Reporte</li>
                            <li>
                                <form action="{{ route('generar-pdf-notificaciones-reportes') }}" method="GET"
                                    target="_blank" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="notificaciones_reportes"
                                        value="{{ json_encode($notificaciones_reportes->all()) }}">
                                    <button type="submit" class="dropdown-item"><i class="fas fa-file-pdf icon-pdf"></i>
                                        Exportar PDF</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('generar-excel-notificaciones-reportes') }}" method="GET"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="notificaciones_reportes"
                                        value="{{ json_encode($notificaciones_reportes->all()) }}">
                                    <button type="submit" class="dropdown-item"><i
                                            class="fas fa-file-excel icon-excel"></i> Exportar Excel</button>
                                </form>
                            </li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item"
                                    href="{{ route('reporte-completo-pdf-notificaciones-reportes') }}"
                                    target="_blank"><i class="fas fa-file-pdf icon-pdf"></i> Exportar PDF (Completo)</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('reporte-completo-excel-notificaciones-reportes') }}"
                                    target="_blank"><i class="fas fa-file-excel icon-excel"></i> Exportar Excel
                                    (Completo)</a></li>
                        </ul>
                    </li>

                    <!-- Menú para Ver Gráficos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-chart-bar icon-graphs"></i> Ver Gráficos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown3">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#chartModalTipo"><i class="fas fa-chart-pie icon-chart2"></i>
                                    Notificaciones por Tipo</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#chartModalEstado"><i class="fas fa-chart-bar icon-chart3"></i>
                                    Notificaciones por Estado</a></li>
                        </ul>
                    </li>

                    <!-- Botón de Cerrar Sesión -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link"
                                style="display: inline; cursor: pointer;">
                                <i class="fas fa-sign-out-alt icon-logout"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-1">
        <h1 class="text-center">Notificaciones y Reportes</h1>
        <!-- Botón para abrir el modal de creación -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createNotificacionReporteModal">
            Crear Notificación/Reporte
        </button>

        <!-- Tabla de notificaciones y reportes -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                    <th>Leído</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notificaciones_reportes as $reporte)
                <tr>
                    <td>{{ $reporte['notificaciones_reportes_id'] }}</td>
                    <td>{{ $reporte['usuarios_id'] }}</td>
                    <td>{{ $reporte['tipo'] }}</td>
                    <td>{{ $reporte['mensaje'] }}</td>
                    <td>{{ $reporte['fecha'] }}</td>
                    <td>{{ $reporte['leido'] ? 'Sí' : 'No' }}</td>
                    <td>
                        <!-- Botón para abrir el modal de "Ver" -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#viewNotificacionReporteModal"
                            data-id="{{ $reporte['notificaciones_reportes_id'] }}"
                            data-usuarios_id="{{ $reporte['usuarios_id'] }}" data-tipo="{{ $reporte['tipo'] }}"
                            data-mensaje="{{ $reporte['mensaje'] }}" data-fecha="{{ $reporte['fecha'] }}"
                            data-leido="{{ $reporte['leido'] ? 'true' : 'false' }}">Ver</button>

                        <!-- Botón para abrir el modal de "Editar" -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editNotificacionReporteModal"
                            data-id="{{ $reporte['notificaciones_reportes_id'] }}"
                            data-usuarios_id="{{ $reporte['usuarios_id'] }}" data-tipo="{{ $reporte['tipo'] }}"
                            data-mensaje="{{ $reporte['mensaje'] }}" data-fecha="{{ $reporte['fecha'] }}"
                            data-leido="{{ $reporte['leido'] ? 'true' : 'false' }}">Editar</button>

                        <!-- Botón para abrir el modal de "Eliminar" -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteNotificacionReporteModal"
                            data-id="{{ $reporte['notificaciones_reportes_id'] }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <div id="viewNotificacionReporteModal" class="modal fade" tabindex="-1" aria-labelledby="viewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewModalLabel">Detalles de la Notificación/Reporte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Usuario ID:</strong> <span id="viewUsuariosId"></span></p>
                            <p><strong>Tipo:</strong> <span id="viewTipo"></span></p>
                            <p><strong>Mensaje:</strong> <span id="viewMensaje"></span></p>
                            <p><strong>Fecha:</strong> <span id="viewFecha"></span></p>
                            <p><strong>Leído:</strong> <span id="viewLeido"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="editNotificacionReporteModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Notificación/Reporte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <form id="editNotificacionReporteForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="editUsuariosId" class="form-label">Usuario ID</label>
                                    <input type="number" class="form-control" id="editUsuariosId" name="usuarios_id"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="editTipo" class="form-label">Tipo</label>
                                    <select class="form-select" id="editTipo" name="tipo" required>
                                        <option value="Notificación">Notificación</option>
                                        <option value="Reporte">Reporte</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editMensaje" class="form-label">Mensaje</label>
                                    <textarea class="form-control" id="editMensaje" name="mensaje" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editFecha" class="form-label">Fecha y Hora</label>
                                    <input type="datetime-local" class="form-control" id="editFecha" name="fecha"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="editLeido" class="form-label">Leído</label>
                                    <select class="form-select" id="editLeido" name="leido" required>
                                        <option value="true">Sí</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </table>

        <!-- Paginación -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-1">
            {!! $notificaciones_reportes->links('pagination::bootstrap-5') !!}
        </nav>
        <!-- Modal para crear notificación/reporte -->
        <div class="modal fade" id="createNotificacionReporteModal" tabindex="-1"
            aria-labelledby="createNotificacionReporteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createNotificacionReporteModalLabel">Crear Notificación/Reporte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('notificaciones_reportes.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Formulario de creación -->
                            <div class="mb-3">
                                <label for="usuarios_id" class="form-label">Usuario ID</label>
                                <input type="number" class="form-control" id="usuarios_id" name="usuarios_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="Notificación">Notificación</option>
                                    <option value="Reporte">Reporte</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha y Hora</label>
                                <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="mb-3">
                                <label for="leido" class="form-label">Leído</label>
                                <select class="form-select" id="leido" name="leido" required>
                                    <option value="true">Sí</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para eliminar notificación/reporte -->
        <div class="modal fade" id="deleteNotificacionReporteModal" tabindex="-1"
            aria-labelledby="deleteNotificacionReporteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteNotificacionReporteModalLabel">Eliminar Notificación/Reporte
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="deleteNotificacionReporteForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas eliminar esta notificación/reporte?</p>
                            <input type="hidden" id="deleteNotificacionReporteId" name="deleteNotificacionReporteId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modales para los Gráficos -->
        <div class="modal fade" id="chartModalTipo" tabindex="-1" aria-labelledby="chartModalTipoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalTipoLabel">Notificaciones por Tipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <canvas id="notificationsChartTipo"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="chartModalEstado" tabindex="-1" aria-labelledby="chartModalEstadoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalEstadoLabel">Notificaciones por Estado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <canvas id="notificationsChartEstado"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Importar Notificaciones/Reportes -->
        <div class="modal fade" id="importNotificacionesModal" tabindex="-1"
            aria-labelledby="importNotificacionesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importNotificacionesModalLabel">Importar Notificaciones/Reportes
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="importNotificacionesForm" action="{{ route('import.notificaciones') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="file">Selecciona un archivo Excel</label>
                                <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .csv"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Importar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Modal para Mostrar Resultados de la Importación -->
        <div id="importResultModal" class="modal fade" tabindex="-1" aria-labelledby="importResultModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importResultModalLabel">Resultado de la Importación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Mensaje de éxito -->
                        <div id="importSuccessMessage" class="alert alert-success d-none">
                            <p><strong>¡Importación exitosa!</strong></p>
                            <p>Registros nuevos: <span id="importedCount">0</span></p>
                            <p>Registros omitidos: <span id="skippedCount">0</span></p>
                        </div>
                        <!-- Mensaje de error -->
                        <div id="importErrorMessage" class="alert alert-danger d-none">
                            <p><strong>Error durante la importación:</strong></p>
                            <p id="errorDetail"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datos dinámicos para los gráficos -->
        <script type="application/json" id="tiposLabels">
        ["Notificación", "Reporte"]
        </script>
        <script type="application/json" id="tiposData">
        [10, 5]
        </script>
        <script type="application/json" id="leidosData">
        [7, 8]
        </script>

        <!-- JavaScript de Bootstrap y Scripts adicionales -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/not_rep.js') }}"></script>
    </div>
</body>

</html>