<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Registros de Acceso</title>
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
                <th>Usuario ID</th>
                <th>Punto de Acceso ID</th>
                <th>Método</th>
                <th>Fecha y Hora</th>
                <th>Resultado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros_acceso as $registro)
            <tr>
                <td>{{ is_array($registro) ? $registro['registros_acceso_id'] : $registro->registros_acceso_id }}</td>
                <td>{{ is_array($registro) ? $registro['usuarios_id'] : $registro->usuarios_id }}</td>
                <td>{{ is_array($registro) ? $registro['puntos_acceso_id'] : $registro->puntos_acceso_id }}</td>
                <td>{{ is_array($registro) ? $registro['metodo'] : $registro->metodo }}</td>
                <td>{{ is_array($registro) ? $registro['fecha_hora'] : $registro->fecha_hora }}</td>
                <td>{{ is_array($registro) ? $registro['resultado'] : $registro->resultado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y') }}.
    </div>
</body>

</html>