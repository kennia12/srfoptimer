@extends('layouts.app')

@section('title', 'Bienvenido al Sistema de Control de Acceso')

@section('content')

<!-- Barra de Navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Control de Acceso</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">Sobre Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sección Principal -->
<div class="container-fluid d-flex flex-column align-items-center justify-content-center vh-100 text-center bg-dark text-white w-100" id="home">
    <h1 class="display-3 fw-bold text-light">¡Bienvenido!</h1>
    <p class="lead text-light">Controla accesos con la mejor tecnología.</p>

    <!-- Imágenes Estáticas en Fila -->
    <div class="d-flex justify-content-center flex-wrap my-4" style="gap: 20px; max-width: 1200px;">
        <img src="https://th.bing.com/th/id/OIP.mye2m0uxBqImuMkuBbd7BAHaGx?w=1148&h=1049&rs=1&pid=ImgDetMain" 
             class="rounded shadow-lg" 
             style="width: 300px; height: 300px; object-fit: cover;" 
             alt="Control de Acceso 1">

        <img src="https://gacetadental.com/wp-content/uploads/2020/04/Reconocimiento-facial-y-temperatura_sp.jpeg" 
             class="rounded shadow-lg" 
             style="width: 300px; height: 300px; object-fit: cover;" 
             alt="Control de Acceso 2">

        <img src="https://economizadores.net/wcontenido/uploads/2020/09/710292-980x982.jpg" 
             class="rounded shadow-lg" 
             style="width: 300px; height: 300px; object-fit: cover;" 
             alt="Control de Acceso 3">
    </div>

    <p class="mt-3 text-light">Seguridad avanzada con reconocimiento facial y RFID.</p>
    
    <a href="{{ route('login') }}" class="btn btn-secondary btn-lg fw-bold shadow">Iniciar Sesión</a>
</div>

<!-- Sección de Beneficios -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-3 text-center">
            <img src="https://www.atempi.co/wp-content/uploads/2019/07/control-de-acceso-2.jpg" 
                 class="rounded-circle mb-3" 
                 width="150" 
                 height="150" 
                 alt="Seguridad">
            <h5 class="text-secondary fw-bold">Máxima Seguridad</h5>
            <p class="text-muted">Protección con autenticación biométrica y RFID.</p>
        </div>
        <div class="col-md-3 text-center">
            <img src="https://gecsa.com.mx/wp-content/uploads/2022/06/e0a70f72bdae9885bfc32d7cd19a26a1_XL-1-768x469.jpg" 
                 class="rounded-circle mb-3" 
                 width="150" 
                 height="150" 
                 alt="Automatización">
            <h5 class="text-secondary fw-bold">Acceso Inteligente</h5>
            <p class="text-muted">Automatiza accesos sin contacto físico.</p>
        </div>
        <div class="col-md-3 text-center">
            <img src="https://th.bing.com/th/id/OIP.c3CW_nXPKhmB3zQh6eJCfQHaDf?rs=1&pid=ImgDetMain" 
                 class="rounded-circle mb-3" 
                 width="150" 
                 height="150" 
                 alt="Reportes">
            <h5 class="text-secondary fw-bold">Reportes en Tiempo Real</h5>
            <p class="text-muted">Consulta accesos y actividades al instante.</p>
        </div>
    </div>
</div>

<!-- Estilos Adicionales -->
<style>
    /* Corrección de la Barra Azul */
    .navbar {
        background-color: #343a40 !important; /* Oscuro */
    }

    /* Ajuste para eliminar cualquier color azul no deseado */
    .bg-dark {
        background-color: #343a40 !important; 
    }

    /* Asegurar color blanco en los enlaces */
    .navbar a {
        color: #ffffff !important;
    }

    .text-secondary {
        color: #6c757d !important;
    }

    .text-info {
        color: #17a2b8 !important;
    }

    footer {
        background-color: #232F3E;
        color: white;
        padding: 20px;
        text-align: center;
    }
</style>

<!-- Bootstrap 5.3.2 y Bootstrap Icons Actualizado -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

<!-- Bootstrap Bundle con Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
