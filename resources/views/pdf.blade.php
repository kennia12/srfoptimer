<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        color: #333;
    }

    h1 {
        text-align: center;
        color: #1F4E79;
        margin-bottom: 20px;
        font-size: 24px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        color: #1F4E79;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        color: #777;
    }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ is_array($usuario) ? $usuario['usuarios_id'] : $usuario->usuarios_id }}</td>
                <td>{{ is_array($usuario) ? $usuario['nombre'] : $usuario->nombre }}</td>
                <td>{{ is_array($usuario) ? $usuario['apellido'] : $usuario->apellido }}</td>
                <td>{{ is_array($usuario) ? $usuario['correo'] : $usuario->correo }}</td>
                <td>{{ is_array($usuario) ? $usuario['telefono'] : $usuario->telefono }}</td>
                <td>{{ is_array($usuario) ? $usuario['rol'] : $usuario->rol }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y') }}.
    </div>
</body>

</html>