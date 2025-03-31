@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Datos del ESP32</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Último RFID</th>
                <th>Mensaje de Acceso</th>
                <th>Movimiento Detectado</th>
                <th>Mensaje de Movimiento</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $datos['lastRFID'] }}</td>
                <td>{{ $datos['accessMessage'] }}</td>
                <td>{{ $datos['motionDetected'] ? 'Sí' : 'No' }}</td>
                <td>{{ $datos['motionMessage'] }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
