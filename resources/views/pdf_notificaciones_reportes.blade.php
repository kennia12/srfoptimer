<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Notificaciones de Reportes</title>
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
                <th>Tipo</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Leído</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notificaciones_reportes as $reporte)
            <tr>
                <td>{{ is_array($reporte) ? $reporte['notificaciones_reportes_id'] : $reporte->notificaciones_reportes_id }}
                </td>
                <td>{{ is_array($reporte) ? $reporte['usuarios_id'] : $reporte->usuarios_id }}</td>
                <td>{{ is_array($reporte) ? $reporte['tipo'] : $reporte->tipo }}</td>
                <td>{{ is_array($reporte) ? $reporte['mensaje'] : $reporte->mensaje }}</td>
                <td>{{ is_array($reporte) ? $reporte['fecha'] : $reporte->fecha }}</td>
                <td>{{ is_array($reporte) ? ($reporte['leido'] ? 'Sí' : 'No') : ($reporte->leido ? 'Sí' : 'No') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y') }}.
    </div>
</body>

</html>