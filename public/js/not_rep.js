// Escuchar cuando el DOM está completamente cargado para garantizar que todos los elementos estén disponibles
document.addEventListener('DOMContentLoaded', function () {
    // ==============================================
    // MANEJO DE MODALES PARA NOTIFICACIONES/REPORTES
    // ==============================================

    // Referencias a los modales específicos
    var viewNotificacionReporteModal = document.getElementById('viewNotificacionReporteModal'); // Modal de "Ver"
    var editNotificacionReporteModal = document.getElementById('editNotificacionReporteModal'); // Modal de "Editar"
    var deleteNotificacionReporteModal = document.getElementById('deleteNotificacionReporteModal'); // Modal de "Eliminar"

    // Modal: Ver notificación/reporte
    if (viewNotificacionReporteModal) {
        viewNotificacionReporteModal.addEventListener('show.bs.modal', function (event) {
            // Extraer datos del botón que disparó el evento (relacionado con el modal)
            var button = event.relatedTarget; // Botón que abre el modal
            try {
                // Obtener atributos del botón
                const usuariosId = button.getAttribute('data-usuarios_id') || 'N/A';
                const tipo = button.getAttribute('data-tipo') || 'N/A';
                const mensaje = button.getAttribute('data-mensaje') || 'N/A';
                const fecha = button.getAttribute('data-fecha') || 'N/A';
                const leido = button.getAttribute('data-leido') === 'true' ? 'Sí' : 'No';

                // Asignar datos a los elementos correspondientes dentro del modal
                document.getElementById('viewUsuariosId').textContent = usuariosId;
                document.getElementById('viewTipo').textContent = tipo;
                document.getElementById('viewMensaje').textContent = mensaje;
                document.getElementById('viewFecha').textContent = fecha;
                document.getElementById('viewLeido').textContent = leido;
            } catch (err) {
                console.error('Error al mostrar los datos en el modal de "Ver":', err);
            }
        });
    }

    // Modal: Editar notificación/reporte
    if (editNotificacionReporteModal) {
        editNotificacionReporteModal.addEventListener('show.bs.modal', function (event) {
            // Extraer datos del botón que disparó el evento (relacionado con el modal)
            var button = event.relatedTarget;
            try {
                var form = document.getElementById('editNotificacionReporteForm');
                form.action = `/notificaciones_reportes/${button.getAttribute('data-id')}`; // Actualiza el destino del formulario

                // Completar los campos del formulario con los datos del elemento seleccionado
                document.getElementById('editUsuariosId').value = button.getAttribute('data-usuarios_id');
                document.getElementById('editTipo').value = button.getAttribute('data-tipo');
                document.getElementById('editMensaje').value = button.getAttribute('data-mensaje');
                document.getElementById('editFecha').value = new Date(button.getAttribute('data-fecha')).toISOString().slice(0, 16); // Ajustar formato de fecha para input datetime-local
                document.getElementById('editLeido').value = button.getAttribute('data-leido') === 'true' ? 'true' : 'false'; // Convertir "true/false" a texto
            } catch (err) {
                console.error('Error al mostrar los datos en el modal de "Editar":', err);
            }
        });
    }

    // Modal: Eliminar notificación/reporte
    if (deleteNotificacionReporteModal) {
        deleteNotificacionReporteModal.addEventListener('show.bs.modal', function (event) {
            // Extraer datos del botón que disparó el evento (relacionado con el modal)
            var button = event.relatedTarget;
            try {
                var form = document.getElementById('deleteNotificacionReporteForm');
                form.action = `/notificaciones_reportes/${button.getAttribute('data-id')}`; // Actualiza el destino del formulario
                document.getElementById('deleteNotificacionReporteId').value = button.getAttribute('data-id'); // Muestra el ID del registro a eliminar
            } catch (err) {
                console.error('Error al preparar el modal de "Eliminar":', err);
            }
        });
    }

    // ============================
    // GENERACIÓN DE GRÁFICOS
    // ============================

    // Referencias al lienzo de los gráficos en la página
    var ctxTipo = document.getElementById('notificationsChartTipo'); // Lienzo del gráfico por "Tipo"
    var ctxEstado = document.getElementById('notificationsChartEstado'); // Lienzo del gráfico por "Estado"

    // Gráfico: Distribución por tipo
    if (ctxTipo) {
        // Datos dinámicos para el gráfico, cargados desde etiquetas en el HTML (seguras)
        const tiposLabels = JSON.parse(document.getElementById('tiposLabels').textContent || '[]'); // Etiquetas de tipos
        const tiposData = JSON.parse(document.getElementById('tiposData').textContent || '[]'); // Datos de cantidades por tipo

        // Configuración del gráfico de pastel
        const configTipo = {
            type: 'pie',
            data: {
                labels: tiposLabels, // Etiquetas (ejemplo: Notificación, Reporte)
                datasets: [{
                    label: 'Cantidad de Notificaciones',
                    data: tiposData, // Cantidades por cada tipo
                    backgroundColor: [ // Colores para cada sección
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [ // Bordes de cada sección
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Ajustar tamaño dinámicamente
                plugins: {
                    legend: { position: 'top' }, // Ubicación de la leyenda
                    title: { display: true, text: 'Distribución de Notificaciones por Tipo' } // Título del gráfico
                }
            }
        };
        new Chart(ctxTipo, configTipo); // Crear el gráfico de pastel
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // ============================
    // GRÁFICOS POR ESTADO DE LECTURA
    // ============================

    // Referencia al lienzo del gráfico "Estado de Lectura"
    const ctxEstado = document.getElementById('notificationsChartEstado');

    if (ctxEstado) {
        try {
            // Datos cargados dinámicamente desde el HTML
            const leidosData = JSON.parse(
                document.getElementById('leidosData')?.textContent || '[0, 0]'
            );

            // Configuración del gráfico
            const configEstado = {
                type: 'bar',
                data: {
                    labels: ['Leído', 'No Leído'], // Etiquetas del eje X
                    datasets: [{
                        label: 'Cantidad de Notificaciones',
                        data: leidosData, // Datos de las notificaciones leídas/no leídas
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)', // Color para "Leído"
                            'rgba(255, 99, 132, 0.2)', // Color para "No Leído"
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)', // Borde para "Leído"
                            'rgba(255, 99, 132, 1)', // Borde para "No Leído"
                        ],
                        borderWidth: 1, // Ancho del borde
                    }],
                },
                options: {
                    responsive: true, // Ajuste automático del tamaño
                    plugins: {
                        legend: { position: 'top' }, // Posición de la leyenda
                        title: { display: true, text: 'Distribución de Notificaciones por Estado' }, // Título del gráfico
                    },
                },
            };

            // Inicializar el gráfico
            new Chart(ctxEstado, configEstado);
        } catch (error) {
            console.error('Error al cargar el gráfico:', error);
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // ========================================
    // MANEJO DE IMPORTACIÓN DE NOTIFICACIONES/REPORTES
    // ========================================

    // Referencia al formulario de importación y al modal de resultados
    const form = document.getElementById('importNotificacionesForm');
    const resultModalElement = document.getElementById('importResultModal');

    if (form && resultModalElement) {
        const resultModal = new bootstrap.Modal(resultModalElement); // Inicializar el modal

        // Referencias a los elementos dentro del modal de resultados
        const successMessage = document.getElementById('importSuccessMessage');
        const errorMessage = document.getElementById('importErrorMessage');
        const addedRecordsCount = document.getElementById('importedCount');
        const skippedRecordsCount = document.getElementById('skippedCount');
        const errorDetail = document.getElementById('errorDetail');

        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevenir el comportamiento estándar del formulario

            const formData = new FormData(form); // Crear objeto FormData con los datos del formulario

            // Limpiar mensajes previos
            successMessage.classList.add('d-none');
            errorMessage.classList.add('d-none');

            // Enviar solicitud HTTP POST
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }, // Asegurar encabezado para solicitud AJAX
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }

                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('El servidor devolvió una respuesta no válida.');
                    }

                    return response.json(); // Convertir la respuesta a JSON
                })
                .then((data) => {
                    if (data.error) {
                        // Mostrar mensaje de error
                        errorMessage.classList.remove('d-none');
                        errorDetail.textContent = data.error;
                        successMessage.classList.add('d-none');
                    } else {
                        // Mostrar mensaje de éxito
                        successMessage.classList.remove('d-none');
                        addedRecordsCount.textContent = data.nuevos_registros || 0;
                        skippedRecordsCount.textContent = data.registros_omitidos || 0;
                        errorMessage.classList.add('d-none');
                    }

                    // Mostrar el modal de resultados
                    resultModal.show();
                })
                .catch((error) => {
                    console.error('Error inesperado:', error);
                    // Mostrar mensaje de error
                    errorMessage.classList.remove('d-none');
                    errorDetail.textContent = error.message;
                    successMessage.classList.add('d-none');
                    resultModal.show();
                });
        });
    } else {
        if (!form) {
            console.error('No se encontró el formulario de importación.');
        }
        if (!resultModalElement) {
            console.error('No se encontró el modal de resultados.');
        }
    }
});