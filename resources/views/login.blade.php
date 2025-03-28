<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Estilos Globales */
        body {
            background: #121212; /* Negro oscuro */
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Contenedor del Login */
        .login-box {
            background: #1e1e1e; /* Gris oscuro */
            padding: 35px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            color: #e0e0e0; /* Gris claro */
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.3);
            border-top: 3px solid #ffffff10; /* Sutil línea superior */
        }

        /* Título */
        h2 {
            font-size: 26px;
            font-weight: 600;
            color: #ffffff; /* Blanco puro */
            margin-bottom: 20px;
        }

        /* Campos de Entrada */
        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .form-control {
            background: #252525; /* Gris más oscuro */
            border: 1px solid #333; /* Borde sutil */
            padding: 12px;
            border-radius: 8px;
            font-size: 15px;
            color: #e0e0e0;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            background: #2e2e2e;
            border-color: #ffffff50;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        /* Botón de Enviar */
        .btn-primary {
            background: #ffffff10; /* Gris semitransparente */
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            color: #e0e0e0;
        }

        .btn-primary:hover {
            background: #ffffff20;
        }

        /* Enlace */
        .btn-link {
            color: #bbbbbb;
            text-decoration: none;
            display: block;
            margin-top: 12px;
            font-size: 14px;
        }

        .btn-link:hover {
            text-decoration: underline;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
        <a href="{{ route('register') }}" class="btn-link">Crear una cuenta</a>
    </div>
</body>

</html>
