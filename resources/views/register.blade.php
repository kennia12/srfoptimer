<!DOCTYPE html>
<html lang="es">

<head>
    <title>Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f0e7f0, #e0c3e8); 
            color: #333; 
            font-family: 'Arial', sans-serif;
        }

        .register-card {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .register-card h2 {
            color: #6a1b9a; 
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ffcc00; 
            padding: 10px;
            transition: all 0.3s ease-in-out;
            background: rgba(255, 255, 255, 0.8); 
            color: #333;
        }

        .form-control:focus {
            border-color: #6a1b9a; 
            box-shadow: 0 0 5px rgba(106, 27, 154, 0.5); 
        }
        .btn-register {
            background: #6a1b9a;
            color: #fff; 
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            transition: all 0.3s ease-in-out;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-register:hover {
            background: #8e24aa; 
            transform: scale(1.05);
            box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.2);
        }
        .btn-link {
            color: #6a1b9a; 
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-link:hover {
            color: #8e24aa; 
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="register-card">
            <h2><i class="fas fa-user-plus"></i> Registro</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-register"><i class="fas fa-sign-in-alt"></i> Registrarse</button>
            </form>
            <br>
            <a href="{{ route('login') }}" class="btn-link"><i class="fas fa-arrow-left"></i> Volver a Iniciar Sesión</a>
        </div>
    </div>

</body>
</html>
