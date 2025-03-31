@extends('layouts.app')

@section('title', 'Sobre Nosotros')

@section('content')
<style>
    /* Estilo general */
    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: #121212;
        color: #ffffff;
    }

    /* Encabezado */
    .header {
        background: linear-gradient(135deg, #1DB954, #121212);
        padding: 20px;
        text-align: center;
        font-size: 2.5rem;
        font-weight: bold;
        color: #ffffff;
        border-radius: 8px;
    }

    /* Contenedor principal */
    .about-container {
        max-width: 1100px;
        margin: 50px auto;
        padding: 40px;
        background: #181818;
        border-radius: 12px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.5);
    }

    .about-text h1 {
        font-size: 2.8rem;
        margin-bottom: 20px;
        border-left: 6px solid #1DB954;
        padding-left: 12px;
    }

    .about-text p {
        font-size: 1.3rem;
        line-height: 1.8;
        color: #b3b3b3;
        text-align: justify;
    }

    /* Imágenes */
    .about-images {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
    }

    .about-images img {
        width: 100%;
        max-width: 400px;
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .about-images img:hover {
        transform: scale(1.07);
        box-shadow: 0px 0px 20px rgba(29, 185, 84, 0.5);
    }

    /* Sección de valores */
    .values-section {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-top: 40px;
    }

    .value-card {
        background: #242424;
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        width: 48%;
        margin-bottom: 20px;
        transition: 0.3s ease;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        border-left: 5px solid #1DB954;
        position: relative;
        overflow: hidden;
    }

    .value-card:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 15px rgba(29, 185, 84, 0.3);
    }

    .value-card i {
        font-size: 3rem;
        color: #1DB954;
        margin-bottom: 15px;
    }

    .value-card p {
        font-size: 1.1rem;
        color: #dcdcdc;
        margin-top: 10px;
    }

    .value-card::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 5px;
        background: #1DB954;
        top: 0;
        left: 0;
    }

    /* Beneficios adicionales */
    .benefits-section {
        margin-top: 50px;
        padding: 20px;
        background: #1a1a1a;
        border-radius: 12px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .benefits-section h2 {
        font-size: 2.5rem;
        color: #1DB954;
        margin-bottom: 20px;
    }

    .benefits-list {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .benefit-item {
        width: 30%;
        padding: 15px;
        background: #242424;
        border-radius: 10px;
        font-size: 1.1rem;
        color: #b3b3b3;
        text-align: center;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
    }

    /* Botón */
    .btn-custom {
        display: block;
        margin: 40px auto;
        padding: 15px 30px;
        font-size: 1.3rem;
        color: #fff;
        background: #1DB954;
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        transition: 0.3s ease;
        width: fit-content;
        box-shadow: 0px 4px 10px rgba(29, 185, 84, 0.5);
    }

    .btn-custom:hover {
        background: #1ed760;
        transform: scale(1.08);
        box-shadow: 0px 6px 15px rgba(29, 185, 84, 0.7);
    }
</style>

<!-- Sección de Encabezado -->
<div class="header">Sobre Nosotros</div>

<div class="about-container">
    <div class="about-text">
        <h1>¿Quiénes Somos?</h1>
        <p>
            Somos una empresa especializada en <strong>control de acceso inteligente</strong>, combinando <strong>reconocimiento facial</strong> y <strong>RFID</strong> para maximizar la seguridad y eficiencia en cualquier tipo de instalación.
        </p>
    </div>

    <div class="about-images">
        <img src="https://revistaseguridad360.com/wp-content/uploads/2021/07/control-de-acceso-tarjeta-2048x1365.jpg" alt="Control de acceso">
        <img src="https://th.bing.com/th/id/OIP.NRIQ3RRGCUnhGE24Pn8c6gHaFi?rs=1&pid=ImgDetMain" alt="Sistema de reconocimiento facial">
    </div>

    <div class="values-section">
        <div class="value-card">
            <i class="bi bi-shield-lock"></i>
            <h3>Seguridad Avanzada</h3>
            <p>Detectamos y prevenimos accesos no autorizados mediante tecnología biométrica de última generación.</p>
        </div>

        <div class="value-card">
            <i class="bi bi-cpu"></i>
            <h3>Automatización</h3>
            <p>Integramos algoritmos inteligentes para controlar accesos de manera eficiente y sin contacto.</p>
        </div>

        <div class="value-card">
            <i class="bi bi-person-check"></i>
            <h3>Identificación Única</h3>
            <p>Cada usuario es registrado con autenticación biométrica para un acceso personalizado y seguro.</p>
        </div>

        <div class="value-card">
            <i class="bi bi-graph-up"></i>
            <h3>Optimización de Recursos</h3>
            <p>Nuestros sistemas reducen costos operativos y aumentan la productividad.</p>
        </div>
    </div>

    <div class="benefits-section">
        <h2>¿Por qué elegirnos?</h2>
        <div class="benefits-list">
            <div class="benefit-item">✔ Acceso 100% seguro</div>
            <div class="benefit-item">✔ Soporte 24/7</div>
            <div class="benefit-item">✔ Integración con sistemas IoT</div>
        </div>
    </div>

    <a href="{{ route('contact') }}" class="btn-custom">Más Información</a>
</div>

@endsection
