<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Cinzel:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar_1.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Token CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <!-- Barra de búsqueda -->
                <form action="{{ route('usuarios.index') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Buscar" name="query"
                            value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit" style="margin-left: 5px;">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-danger"
                                style="margin-left: 5px;">
                                <i class="fas fa-times"></i>
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

                    <!-- Reportes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-alt icon-reports"></i> Reportes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                            <li class="dropdown-header">Importar Reporte</li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#importReportesModal">
                                    <i class="fas fa-file-excel icon-excel"></i> Importar Excel
                                </a>
                            </li>
                            <hr class="dropdown-divider">
                            <li class="dropdown-header">Exportar Reporte</li>
                            <li>
                                <form action="{{ route('generar-pdf') }}" method="GET" target="_blank">
                                    @csrf
                                    <input type="hidden" name="usuarios" value="{{ json_encode($usuarios->all()) }}">
                                    <button type="submit" class="dropdown-item"><i class="fas fa-file-pdf icon-pdf"></i>
                                        Exportar PDF</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('generar-excel') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="usuarios" value="{{ json_encode($usuarios->all()) }}">
                                    <button type="submit" class="dropdown-item"><i
                                            class="fas fa-file-excel icon-excel"></i> Exportar Excel</button>
                                </form>
                            </li>
                            <hr class="dropdown-divider">
                            <li class="dropdown-header">Exportar Reporte Completo</li>
                            <li><a class="dropdown-item" href="{{ route('reporte.completo.pdf') }}" target="_blank"><i
                                        class="fas fa-file-pdf icon-pdf"></i> Exportar PDF (Completo)</a></li>
                            <li><a class="dropdown-item" href="{{ route('reporte.completo.excel') }}"><i
                                        class="fas fa-file-excel icon-excel"></i> Exportar Excel (Completo)</a></li>
                        </ul>
                    </li>

                    <!-- Gráficos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-chart-bar icon-graphs"></i> Ver Gráficos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown3">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#chartModal"><i
                                        class="fas fa-chart-pie icon-chart2"></i> Usuarios por Rol</a></li>
                        </ul>
                    </li>

                    <!-- Cerrar Sesión -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="cursor: pointer;">
                                <i class="fas fa-sign-out-alt icon-logout"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-1">
        <h1 class="text-center">Usuarios</h1>
        <!-- Botón para abrir el modal de creación -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
            Crear Usuario
        </button>

        <!-- Tabla de usuarios -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario['usuarios_id'] }}</td>
                    <td>{{ $usuario['nombre'] }}</td>
                    <td>{{ $usuario['apellido'] }}</td>
                    <td>{{ $usuario['correo'] }}</td>
                    <td>{{ $usuario['telefono'] }}</td>
                    <td>{{ $usuario['rol'] }}</td>
                    <td>
                        <!-- Botón para ver usuario -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewUserModal"
                            data-id="{{ $usuario['usuarios_id'] }}" data-nombre="{{ $usuario['nombre'] }}"
                            data-apellido="{{ $usuario['apellido'] }}" data-correo="{{ $usuario['correo'] }}"
                            data-telefono="{{ $usuario['telefono'] }}" data-rol="{{ $usuario['rol'] }}">Ver</button>

                        <!-- Botón para editar usuario -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal"
                            data-id="{{ $usuario['usuarios_id'] }}" data-nombre="{{ $usuario['nombre'] }}"
                            data-apellido="{{ $usuario['apellido'] }}" data-correo="{{ $usuario['correo'] }}"
                            data-telefono="{{ $usuario['telefono'] }}" data-rol="{{ $usuario['rol'] }}">Editar</button>

                        <!-- Botón para eliminar usuario -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                            data-id="{{ $usuario['usuarios_id'] }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center mt-1">
            {!! $usuarios->links('pagination::bootstrap-5') !!}
        </nav>

        <!-- Modal para crear usuario -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Formulario de creación -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select class="form-select" id="rol" name="rol" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Usuario">Usuario</option>
                                    <option value="Guardia">Guardia</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
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

        <!-- Modal para ver usuario -->
        <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewUserModalLabel">Ver Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Información del usuario -->
                        <div class="mb-3">
                            <label for="viewNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="viewNombre" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewApellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="viewApellido" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewCorreo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="viewCorreo" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewTelefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="viewTelefono" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewRol" class="form-label">Rol</label>
                            <input type="text" class="form-control" id="viewRol" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para editar usuario -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <!-- Formulario de edición -->
                            <div class="mb-3">
                                <label for="editNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editApellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="editApellido" name="apellido" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCorreo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="editCorreo" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTelefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="editTelefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRol" class="form-label">Rol</label>
                                <select class="form-select" id="editRol" name="rol" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Usuario">Usuario</option>
                                    <option value="Guardia">Guardia</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">Contraseña</label>
                                <input type="text" class="form-control" id="editPassword" name="password" required>
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

        <!-- Modal para eliminar usuario -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Eliminar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="deleteUserForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                            <input type="hidden" id="deleteUserId" name="deleteUserId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal para gráficos -->
        <div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalLabel">Usuarios por Rol</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <canvas id="usersRoleChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para importar reportes -->
        <div class="modal fade" id="importReportesModal" tabindex="-1" aria-labelledby="importReportesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importReportesModalLabel">Importar Reportes de Usuarios</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="importReportesForm" action="{{ route('import.reportes') }}" method="POST"
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

        <!-- Modal para mostrar resultados de la importación -->
        <div id="importResultModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Resultado de la Importación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="importSuccessMessage" class="alert alert-success d-none">
                            <p><strong>¡Importación exitosa!</strong></p>
                            <p>Registros nuevos: <span id="importedCount">0</span></p>
                            <p>Registros omitidos: <span id="skippedCount">0</span></p>
                        </div>
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
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/usuarios.js') }}"></script>
</body>

</html>