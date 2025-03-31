<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background: #1b1b1b;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #6a1b9a;
        }

        .main-content {
            margin-left: 240px;
            padding: 40px;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .card {
            background: #333;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
        }

        .card i {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .btn-logout {
            width: 100%;
            background: #ff4d4d;
            color: white;
            margin-top: 20px;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
        }

        .btn-logout:hover {
            background: #ff1a1a;
        }

    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2><i class="fas fa-user"></i> Mi Perfil</h2>
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Inicio</a>
        <a href="{{ route('mis-accesos') }}"><i class="fas fa-user-check"></i> Mis Accesos</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
        </form>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Bienvenido, {{ $user->name ?? 'Invitado' }}</h1>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <i class="fas fa-door-open"></i>
                    <h3>5</h3>
                    <p>Accesos Hoy</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>20</h3>
                    <p>Accesos este mes</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <i class="fas fa-clock"></i>
                    <h3>Último acceso</h3>
                    <p>12:45 PM</p>
                </div>
            </div>
        </div>

        <!-- Gráfico de accesos -->
        <div class="chart-container" style="margin-top: 30px;">
            <h3>Historial de Accesos</h3>
            <canvas id="accessChart"></canvas>
        </div>
    </div>

    <script>
        // Gráfico de accesos del usuario
        const ctx = document.getElementById('accessChart').getContext('2d');
        const accessChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
                datasets: [{
                    label: 'Mis Accesos',
                    data: [3, 4, 2, 5, 1],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>
