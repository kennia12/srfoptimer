<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f0e7f0;
            color: #333;
            font-family: 'Cinzel', serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center; 
            padding: 40px;
            background-color: #ffffff; 
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); 
        }

        h1, h2 {
            color: #6a1b9a; 
        }

        h3 {
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 30px;
            line-height: 1.6; 
        }

        .social-icons {
            margin-top: 20px;
        }

        .social-icons a {
            color: #6a1b9a; 
            margin: 0 15px;
            font-size: 30px; 
            transition: color 0.3s, transform 0.3s; 
        }

        .social-icons a:hover {
            color: #ffd700; 
            transform: scale(1.2); 
        }

        .btn-custom {
            width: 100%; 
            margin-top: 20px; 
        }
    </style>
</head>

<body>
  
    <div class="header text-center mt-4">
        <h1><i class="fas fa-chart-line"></i> Dashboard</h1>
    </div>

    <div class="container mt-5">
      
        <div class="dashboard-card">
            <h2><i class="fas fa-user-circle"></i> Bienvenido!</h2>
            @if(Session::get('user_role') === 'Admin')
                <p>Has iniciado sesión como <strong>Administrador</strong>.</p>
                <a href="{{ route('usuarios.index') }}" class="btn btn-danger btn-custom"><i class="fas fa-users"></i> Gestionar Usuarios</a>
                <a href="{{ route('notificaciones_reportes.index') }}" class="btn btn-dark btn-custom"><i class="fas fa-bell"></i> Notificaciones/Reportes</a>
                <a href="{{ route('registros_acceso.index') }}" class="btn btn-warning btn-custom"><i class="fas fa-folder"></i> Registros de Acceso</a>
                <a href="{{ route('puntos_acceso.index') }}" class="btn btn-secondary btn-custom"><i class="fas fa-map-marker-alt"></i> Puntos de Acceso</a>
            @else
                <p>Has iniciado sesión como <strong>Usuario</strong>.</p>
            @endif
        </div>

        <div class="conocenos mt-4">
            <h3><i class="fas fa-info-circle"></i> Conócenos</h3>
            <p>Somos una plataforma innovadora para la gestión de accesos y notificaciones, pensando en nuestros principales clientes y en que su tiempo es muy importante como ustedes para nosotros. "BIENVENIDOS".</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
    
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-danger btn-custom"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
    