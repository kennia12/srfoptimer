<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Acceso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Cinzel:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navbar_1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/registros_acceso.css') }}">
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
                <form action="{{ route('registros_acceso.index') }}" method="GET" class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Buscar" name="query"
                            value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit" style="margin-left: 5px;">
                                <i class="fas fa-search"></i> <!-- Icono de búsqueda -->
                            </button>
                            <a href="{{ route('registros_acceso.index') }}" class="btn btn-outline-danger"
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
                            <li class="dropdown-header">Importar Reporte</li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#importRegistrosAccesoModal">
                                    <i class="fas fa-file-excel icon-excel"></i> Importar Excel
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-header">Exportar Reporte</li>
                            <!-- Reporte Filtrado -->
                            <li>
                                <form action="{{ route('generar-pdf-registros') }}" method="GET" target="_blank"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="registros_acceso"
                                        value="{{ json_encode($registros_acceso->all()) }}">
                                    <button type="submit" class="dropdown-item"><i class="fas fa-file-pdf icon-pdf"></i>
                                        Exportar PDF</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('generar-excel-registros') }}" method="GET"
                                    style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="registros_acceso"
                                        value="{{ json_encode($registros_acceso->all()) }}">
                                    <button type="submit" class="dropdown-item"><i
                                            class="fas fa-file-excel icon-excel"></i>
                                        Exportar Excel</button>
                                </form>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- Reporte Completo -->
                            <li><a class="dropdown-item" href="{{ route('reporte-completo-pdf-registros') }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf icon-pdf"></i> Exportar PDF (Completo)</a></li>
                            <li><a class="dropdown-item" href="{{ route('reporte-completo-excel-registros') }}"
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
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#chartModalMetodo"><i class="fas fa-chart-pie icon-chart2"></i>
                                    Registros por Método</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#chartModalResultado"><i class="fas fa-chart-bar icon-chart3"></i>
                                    Registros por Resultado</a></li>
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
        <h1 class="text-center">Registros de Acceso</h1>

        <!-- Botón para abrir el modal de creación -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createRegistroAccesoModal">Crear
            Registro de Acceso</button>

        <!-- Tabla de registros de acceso -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario ID</th>
                    <th>Punto de Acceso ID</th>
                    <th>Método</th>
                    <th>Fecha y Hora</th>
                    <th>Resultado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registros_acceso as $registro)
                <tr>
                    <td>{{ $registro['registros_acceso_id'] }}</td>
                    <td>{{ $registro['usuarios_id'] }}</td>
                    <td>{{ $registro['puntos_acceso_id'] }}</td>
                    <td>{{ $registro['metodo'] }}</td>
                    <td>{{ $registro['fecha_hora'] }}</td>
                    <td>{{ $registro['resultado'] }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#viewRegistroAccesoModal" data-id="{{ $registro['registros_acceso_id'] }}"
                            data-usuarios_id="{{ $registro['usuarios_id'] }}"
                            data-puntos_acceso_id="{{ $registro['puntos_acceso_id'] }}"
                            data-metodo="{{ $registro['metodo'] }}" data-fecha_hora="{{ $registro['fecha_hora'] }}"
                            data-resultado="{{ $registro['resultado'] }}">Ver</button>

                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editRegistroAccesoModal" data-id="{{ $registro['registros_acceso_id'] }}"
                            data-usuarios_id="{{ $registro['usuarios_id'] }}"
                            data-puntos_acceso_id="{{ $registro['puntos_acceso_id'] }}"
                            data-metodo="{{ $registro['metodo'] }}" data-fecha_hora="{{ $registro['fecha_hora'] }}"
                            data-resultado="{{ $registro['resultado'] }}">Editar</button>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteRegistroAccesoModal"
                            data-id="{{ $registro['registros_acceso_id'] }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        <!-- Paginación -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-1">
            {!! $registros_acceso->links('pagination::bootstrap-5') !!}
        </nav>


        <!-- Modal para crear registro de acceso -->
        <div class="modal fade" id="createRegistroAccesoModal" tabindex="-1"
            aria-labelledby="createRegistroAccesoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createRegistroAccesoModalLabel">Crear Registro de Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('registros_acceso.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Formulario de creación -->
                            <div class="mb-3">
                                <label for="usuarios_id" class="form-label">Usuario ID</label>
                                <input type="number" class="form-control" id="usuarios_id" name="usuarios_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="puntos_acceso_id" class="form-label">Punto de Acceso ID</label>
                                <input type="number" class="form-control" id="puntos_acceso_id" name="puntos_acceso_id"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="metodo" class="form-label">Método</label>
                                <input type="text" class="form-control" id="metodo" name="metodo" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_hora" class="form-label">Fecha y Hora</label>
                                <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="resultado" class="form-label">Resultado</label>
                                <input type="text" class="form-control" id="resultado" name="resultado" required>
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

        <!-- Modal para ver registro de acceso -->
        <div class="modal fade" id="viewRegistroAccesoModal" tabindex="-1"
            aria-labelledby="viewRegistroAccesoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewRegistroAccesoModalLabel">Ver Registro de Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Información del registro de acceso -->
                        <div class="mb-3">
                            <label for="viewUsuariosId" class="form-label">Usuario ID</label>
                            <input type="number" class="form-control" id="viewUsuariosId" name="viewUsuariosId"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewPuntosAccesoId" class="form-label">Punto de Acceso ID</label>
                            <input type="number" class="form-control" id="viewPuntosAccesoId" name="viewPuntosAccesoId"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewMetodo" class="form-label">Método</label>
                            <input type="text" class="form-control" id="viewMetodo" name="viewMetodo" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewFechaHora" class="form-label">Fecha y Hora</label>
                            <input type="datetime-local" class="form-control" id="viewFechaHora" name="viewFechaHora"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewResultado" class="form-label">Resultado</label>
                            <input type="text" class="form-control" id="viewResultado" name="viewResultado" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar registro de acceso -->
        <div class="modal fade" id="editRegistroAccesoModal" tabindex="-1"
            aria-labelledby="editRegistroAccesoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRegistroAccesoModalLabel">Editar Registro de Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="editRegistroAccesoForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <!-- Formulario de edición -->
                            <div class="mb-3">
                                <label for="editUsuariosId" class="form-label">Usuario ID</label>
                                <input type="number" class="form-control" id="editUsuariosId" name="usuarios_id"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editPuntosAccesoId" class="form-label">Punto de Acceso ID</label>
                                <input type="number" class="form-control" id="editPuntosAccesoId"
                                    name="puntos_acceso_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="editMetodo" class="form-label">Método</label>
                                <input type="text" class="form-control" id="editMetodo" name="metodo" required>
                            </div>
                            <div class="mb-3">
                                <label for="editFechaHora" class="form-label">Fecha y Hora</label>
                                <input type="datetime-local" class="form-control" id="editFechaHora" name="fecha_hora"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editResultado" class="form-label">Resultado</label>
                                <input type="text" class="form-control" id="editResultado" name="resultado" required>
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

        <!-- Modal para eliminar registro de acceso -->
        <div class="modal fade" id="deleteRegistroAccesoModal" tabindex="-1"
            aria-labelledby="deleteRegistroAccesoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteRegistroAccesoModalLabel">Eliminar Registro de Acceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="deleteRegistroAccesoForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas eliminar este registro de acceso?</p>
                            <input type="hidden" id="deleteRegistroAccesoId" name="deleteRegistroAccesoId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para el Gráfico de Métodos -->
        <div class="modal fade" id="chartModalMetodo" tabindex="-1" aria-labelledby="chartModalMetodoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <!-- Usar modal-md para hacer el modal de tamaño mediano -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalMetodoLabel">Registros por Método</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <canvas id="registrosChartMetodo"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para el Gráfico de Resultados -->
        <div class="modal fade" id="chartModalResultado" tabindex="-1" aria-labelledby="chartModalResultadoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <!-- Usar modal-md para hacer el modal de tamaño mediano -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalResultadoLabel">Registros por Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <canvas id="registrosChartResultado"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Importar Registros de Acceso -->
        <div class="modal fade" id="importRegistrosAccesoModal" tabindex="-1"
            aria-labelledby="importRegistrosAccesoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="importRegistrosAccesoForm" action="{{ route('importar-registros-acceso') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importRegistrosAccesoModalLabel">Importar Registros de Acceso
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="file" class="form-label">Selecciona un archivo Excel o CSV</label>
                                <input type="file" class="form-control" id="file" name="file" required>
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
        <script src="{{ asset('js/rgt_acceso.js') }}"></script>
</body>

</html>