// ============================================
// MANEJO DE MODALES PARA PUNTOS DE ACCESO
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    // Referencias a los modales
    const viewPuntoAccesoModal = document.getElementById('viewPuntoAccesoModal');
    const editPuntoAccesoModal = document.getElementById('editPuntoAccesoModal');
    const deletePuntoAccesoModal = document.getElementById('deletePuntoAccesoModal');

    // Evento para mostrar datos en el modal de "Ver Punto de Acceso"
    if (viewPuntoAccesoModal) {
        viewPuntoAccesoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botón que activó el modal

            // Obtener atributos del botón
            const nombre = button.getAttribute('data-nombre');
            const ubicacion = button.getAttribute('data-ubicacion');
            const tipo = button.getAttribute('data-tipo');

            // Asignar valores a los campos del modal
            document.getElementById('viewNombre').value = nombre || 'N/A';
            document.getElementById('viewUbicacion').value = ubicacion || 'N/A';
            document.getElementById('viewTipo').value = tipo || 'N/A';
        });
    }

    // Evento para mostrar datos en el modal de "Editar Punto de Acceso"
    if (editPuntoAccesoModal) {
        editPuntoAccesoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botón que activó el modal

            // Obtener atributos del botón
            const puntoId = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            const ubicacion = button.getAttribute('data-ubicacion');
            const tipo = button.getAttribute('data-tipo');

            // Actualizar la acción del formulario dentro del modal
            const form = document.getElementById('editPuntoAccesoForm');
            form.action = `/puntos_acceso/${puntoId}`;

            // Asignar valores a los campos del formulario
            document.getElementById('editNombre').value = nombre || '';
            document.getElementById('editUbicacion').value = ubicacion || '';
            document.getElementById('editTipo').value = tipo || '';
        });
    }

    // Evento para mostrar datos en el modal de "Eliminar Punto de Acceso"
    if (deletePuntoAccesoModal) {
        deletePuntoAccesoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botón que activó el modal

            // Obtener atributos del botón
            const puntoId = button.getAttribute('data-id');

            // Actualizar la acción del formulario dentro del modal
            const form = document.getElementById('deletePuntoAccesoForm');
            form.action = `/puntos_acceso/${puntoId}`;
            document.getElementById('deletePuntoAccesoId').value = puntoId || '';
        });
    }
});

// ====================================================
// GRÁFICO DE DISTRIBUCIÓN DE PUNTOS DE ACCESO POR TIPO
// ====================================================
document.addEventListener('DOMContentLoaded', function () {
    const ctxTipo = document.getElementById('puntosAccesoChartTipo');
    if (ctxTipo) {
        // Simulación de datos dinámicos (reemplaza con datos reales)
        const tiposLabels = ['Entrada', 'Salida', 'Ambos']; // Etiquetas de los tipos
        const tiposData = [10, 5, 8]; // Datos de puntos de acceso por cada tipo

        // Configuración de datos del gráfico
        const dataTipo = {
            labels: tiposLabels,
            datasets: [{
                label: 'Cantidad de Puntos de Acceso',
                data: tiposData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuración del gráfico de pastel
        const configTipo = {
            type: 'pie',
            data: dataTipo,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Distribución de Puntos de Acceso por Tipo' }
                }
            }
        };

        // Renderizar el gráfico
        new Chart(ctxTipo, configTipo);
    }
});

// ============================================================
// MANEJO DEL MODAL DE RESULTADO PARA LA IMPORTACIÓN DE DATOS
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
    // Seleccionar el formulario y el modal de resultados
    const form = document.getElementById('importPuntosAccesoForm'); // Formulario con ID "importPuntosAccesoForm"
    const resultadoModalElement = document.getElementById('resultadoImportacionModal'); // Modal con ID "resultadoImportacionModal"

    // Verificar que el formulario y el modal existan
    if (form && resultadoModalElement) {
        const resultadoModal = new bootstrap.Modal(resultadoModalElement); // Inicializar el modal

        // Referencias a los elementos dentro del modal
        const mensajeResultado = document.getElementById('mensajeResultado');
        const detallesResultado = document.getElementById('detallesResultado');

        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevenir el comportamiento estándar del formulario

            const formData = new FormData(form); // Crear objeto FormData con los datos del formulario

            // Limpiar el contenido previo del modal
            mensajeResultado.textContent = '';
            detallesResultado.innerHTML = '';

            // Realizar la solicitud POST
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }, // Encabezado para solicitudes AJAX
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json(); // Convertir la respuesta a JSON
                })
                .then((data) => {
                    if (data.error) {
                        // Mostrar mensaje de error en el modal
                        mensajeResultado.innerHTML = `<span class="text-danger">${data.error}</span>`;
                    } else {
                        // Mostrar mensaje de éxito y detalles en el modal
                        mensajeResultado.innerHTML = `<span class="text-success">${data.success}</span>`;
                        detallesResultado.innerHTML = `
                            <li><strong>Nuevos registros:</strong> ${data.nuevos_registros || 0}</li>
                            <li><strong>Registros omitidos (duplicados):</strong> ${data.registros_omitidos || 0}</li>
                        `;
                    }

                    // Mostrar el modal de resultados
                    resultadoModal.show();
                })
                .catch((error) => {
                    console.error('Error inesperado:', error);
                    // Mostrar mensaje de error en el modal
                    mensajeResultado.innerHTML = `<span class="text-danger">Error durante la importación: ${error.message}</span>`;
                    resultadoModal.show();
                });
        });
    } else {
        if (!form) {
            console.error('No se encontró el formulario de importación.');
        }
        if (!resultadoModalElement) {
            console.error('No se encontró el modal de resultados.');
        }
    }
});