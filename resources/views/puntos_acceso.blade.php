<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puntos de Acceso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Cinzel:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navbar_2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/puntos_acceso.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SRFOptimer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Barra de Búsqueda -->
                <form action="{{ route('puntos_acceso.index') }}" method="GET" class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Buscar" name="query"
                            value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit" style="margin-left: 5px;">
                                <i class="fas fa-search"></i> <!-- Icono de búsqueda -->
                            </button>
                            <a href="{{ route('puntos_acceso.index') }}" class="btn btn-outline-danger"
                                style="margin-left: 5px;">
                                <i class="fas fa-times"></i> <!-- Icono de limpiar -->
                            </a>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav ms-auto">
                    <!-- Botón con Menú Desplegable para Vistas Principales -->
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

                    <!-- Botón con Menú Desplegable para Reportes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-alt icon-reports"></i> Reportes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                            <li class="dropdown-header">Importar Puntos de Acceso</li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#importPuntosAccesoModal">
                                    <i class="fas fa-file-excel icon-excel"></i> Importar Excel
                                </a>
                            </li>
                            <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-header">Exportar Reporte</li>
                    <!-- Reporte Filtrado -->
                    <li>
                        <form action="{{ route('generar-pdf-puntos-acceso') }}" method="GET" target="_blank"
                            style="display: inline;">
                            @csrf
                            <input type="hidden" name="puntos_acceso" value="{{ json_encode($puntos_acceso->all()) }}">
                            <button type="submit" class="dropdown-item"><i class="fas fa-file-pdf icon-pdf"></i>
                                Exportar PDF</button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('generar-excel-puntos-acceso') }}" method="GET" style="display: inline;">
                            @csrf
                            <input type="hidden" name="puntos_acceso" value="{{ json_encode($puntos_acceso->all()) }}">
                            <button type="submit" class="dropdown-item"><i class="fas fa-file-excel icon-excel"></i>
                                Exportar Excel</button>
                        </form>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <!-- Reporte Completo -->
                    <li><a class="dropdown-item" href="{{ route('reporte-completo-pdf-puntos-acceso') }}"
                            target="_blank">
                            <i class="fas fa-file-pdf icon-pdf"></i> Exportar PDF (Completo)</a></li>
                    <li><a class="dropdown-item" href="{{ route('reporte-completo-excel-puntos-acceso') }}"
                            target="_blank">
                            <i class="fas fa-file-excel icon-excel"></i> Exportar Excel (Completo)</a></li>
                </ul>
                </li>

                <!-- Botón con Menú Desplegable para Ver Gráficos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-bar icon-graphs"></i> Ver Gráficos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown3">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#chartModalTipo"><i
                                    class="fas fa-chart-pie icon-chart2"></i> Puntos
                                de Acceso por Tipo</a></li>
                    </ul>
                </li>

                <!-- Botón de Cerrar Sesión -->
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="display: inline; cursor: pointer;">
                            <i class="fas fa-sign-out-alt icon-logout"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-1">
        <h1 class="text-center">Puntos de Acceso</h1>

        <!-- Botón para abrir el modal de creación -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPuntoAccesoModal">Crear Punto
            de Acceso</button>

        <!-- Tabla de puntos de acceso -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($puntos_acceso as $punto)
                <tr>
                    <td>{{ $punto['puntos_acceso_id'] }}</td>
                    <td>{{ $punto['nombre'] }}</td>
                    <td>{{ $punto['ubicacion'] }}</td>
                    <td>{{ $punto['tipo'] }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#viewPuntoAccesoModal" data-id="{{ $punto['puntos_acceso_id'] }}"
                            data-nombre="{{ $punto['nombre'] }}" data-ubicacion="{{ $punto['ubicacion'] }}"
                            data-tipo="{{ $punto['tipo'] }}">Ver</button>

                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editPuntoAccesoModal" data-id="{{ $punto['puntos_acceso_id'] }}"
                            data-nombre="{{ $punto['nombre'] }}" data-ubicacion="{{ $punto['ubicacion'] }}"
                            data-tipo="{{ $punto['tipo'] }}">Editar</button>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deletePuntoAccesoModal"
                            data-id="{{ $punto['puntos_acceso_id'] }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        <!-- Paginación -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-1">
            {!! $puntos_acceso->links('pagination::bootstrap-5') !!}
        </nav>


        <!-- Modal para crear punto de acceso -->
        <div class="modal fade" id="createPuntoAccesoModal" tabindex="-1" aria-labelledby="createPuntoAccesoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPuntoAccesoModalLabel">Crear Punto de Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('puntos_acceso.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Formulario de creación -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Salida">Salida</option>
                                    <option value="Ambos">Ambos</option>
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

        <!-- Modal para ver punto de acceso -->
        <div class="modal fade" id="viewPuntoAccesoModal" tabindex="-1" aria-labelledby="viewPuntoAccesoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewPuntoAccesoModalLabel">Ver Punto de Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Información del punto de acceso -->
                        <div class="mb-3">
                            <label for="viewNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="viewNombre" name="viewNombre" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewUbicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="viewUbicacion" name="viewUbicacion" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewTipo" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="viewTipo" name="viewTipo" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar punto de acceso -->
        <div class="modal fade" id="editPuntoAccesoModal" tabindex="-1" aria-labelledby="editPuntoAccesoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPuntoAccesoModalLabel">Editar Punto de Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="editPuntoAccesoForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <!-- Formulario de edición -->
                            <div class="mb-3">
                                <label for="editNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUbicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="editUbicacion" name="ubicacion" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTipo" class="form-label">Tipo</label>
                                <select class="form-select" id="editTipo" name="tipo" required>
                                    <option value="Entrada">Entrada</option>
                                    <option value="Salida">Salida</option>
                                    <option value="Ambos">Ambos</option>
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

        <!-- Modal para eliminar punto de acceso -->
        <div class="modal fade" id="deletePuntoAccesoModal" tabindex="-1" aria-labelledby="deletePuntoAccesoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePuntoAccesoModalLabel">Eliminar Punto de Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="deletePuntoAccesoForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas eliminar este punto de acceso?</p>
                            <input type="hidden" id="deletePuntoAccesoId" name="deletePuntoAccesoId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para el Gráfico de Tipos -->
        <div class="modal fade" id="chartModalTipo" tabindex="-1" aria-labelledby="chartModalTipoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <!-- Usar modal-md para hacer el modal de tamaño mediano -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalTipoLabel">Puntos de Acceso por Tipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <canvas id="puntosAccesoChartTipo"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Importar Puntos de Acceso -->
        <div class="modal fade" id="importPuntosAccesoModal" tabindex="-1"
            aria-labelledby="importPuntosAccesoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="importPuntosAccesoForm" action="{{ route('importar-puntos-acceso') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importPuntosAccesoModalLabel">Importar Puntos de Acceso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="file" class="form-label">Selecciona un archivo Excel o CSV</label>
                                <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .csv"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Importar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal de Resultado de Importación -->
        <div class="modal fade" id="resultadoImportacionModal" tabindex="-1"
            aria-labelledby="resultadoImportacionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoImportacionModalLabel">Resultado de Importación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Aquí se mostrará el mensaje dinámico -->
                        <p id="mensajeResultado"></p>
                        <ul id="detallesResultado" class="list-unstyled"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript de Bootstrap y scripts adicionales -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/pnt_acceso.js') }}"></script>
</body>

</html>