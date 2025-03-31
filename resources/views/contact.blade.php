@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
<style>
    /* Estilos generales */
    body {
        background-color: #181818; /* Fondo más oscuro */
        color: #f0f0f0; /* Texto más claro */
        min-height: 100vh;
    }

    .contact-container {
        background-color: rgba(30, 30, 30, 0.95); /* Fondo con ligera transparencia */
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
    }

    /* Barra superior */
    .navbar {
        background-color: rgba(0, 0, 0, 0.8) !important; /* Más oscura */
    }

    /* Formulario */
    .form-control {
        background-color: #252525; /* Inputs más oscuros */
        color: #f0f0f0; /* Texto claro */
        border: 1px solid #444;
    }

    .form-control:focus {
        background-color: #303030; /* Cambio en focus */
        border-color: #007bff; /* Azul brillante */
        color: #fff;
    }

    /* Botón */
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px;
        font-size: 16px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Links */
    .text-link {
        color: #00aaff;
        text-decoration: none;
    }

    .text-link:hover {
        color: #0088cc;
        text-decoration: underline;
    }
</style>

<div class="container py-5">
    <div class="contact-container mx-auto">
        <h1 class="text-center text-info fw-bold mb-4">Contáctanos</h1>
        <p class="text-center" style="color: #d0d0d0; font-size: 1.1rem; text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">

            Estamos aquí para ayudarte. Comunícate con nosotros a través del siguiente formulario o mediante nuestros datos de contacto.
        </p>
        
        <div class="row">
            <!-- Formulario de Contacto -->
            <div class="col-md-6">
                <h4 class="text-secondary mb-4">Envíanos un mensaje</h4>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Asunto</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Enviar Mensaje</button>
                </form>
            </div>

            <!-- Información de Contacto -->
            <div class="col-md-6">
                <h4 class="text-secondary mb-4">Información de Contacto</h4>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="bi bi-envelope-fill text-info"></i> 
                        <strong>Correo Electrónico:</strong> 
                        <a href="mailto:soporte@srfOptimer.com" class="text-link">soporte@tusistema.com</a>
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-telephone-fill text-info"></i> 
                        <strong>Teléfono:</strong> 
                        +52 55 1234 5678
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-geo-alt-fill text-info"></i> 
                        <strong>Dirección:</strong> 
                        Av. Reforma 123, Ciudad de México, México
                    </li>
                </ul>

                <!-- Mapa de Ubicación -->
                <h4 class="text-secondary mt-4">Nuestra Ubicación</h4>
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.406098697451!2d-99.1417!3d19.4326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1f92a11223344%3A0xabc123efgh5678!2sMonumento%20a%20la%20Revoluci%C3%B3n!5e0!3m2!1ses!2smx!4v1234567890"
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
