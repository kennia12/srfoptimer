//====================================
// MANEJO DE MODALES
//====================================
document.addEventListener('DOMContentLoaded', function () {
    const viewRegistroAccesoModal = document.getElementById('viewRegistroAccesoModal');
    const editRegistroAccesoModal = document.getElementById('editRegistroAccesoModal');
    const deleteRegistroAccesoModal = document.getElementById('deleteRegistroAccesoModal');

    // Para ver el registro de acceso
    if (viewRegistroAccesoModal) {
        viewRegistroAccesoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botón que activó el modal

            if (button) {
                // Extraer datos del botón
                const usuariosId = button.getAttribute('data-usuarios_id') || 'N/A';
                const puntosAccesoId = button.getAttribute('data-puntos_acceso_id') || 'N/A';
                const metodo = button.getAttribute('data-metodo') || 'N/A';
                const fechaHora = button.getAttribute('data-fecha_hora') || '';
                const resultado = button.getAttribute('data-resultado') || 'N/A';

                // Asignar valores a los campos del modal
                document.getElementById('viewUsuariosId').value = usuariosId;
                document.getElementById('viewPuntosAccesoId').value = puntosAccesoId;
                document.getElementById('viewMetodo').value = metodo;
                document.getElementById('viewFechaHora').value = fechaHora ? new Date(fechaHora).toISOString().slice(0, 16) : '';
                document.getElementById('viewResultado').value = resultado;
            } else {
                console.error('No se encontró el botón que activó el modal de "Ver".');
            }
        });
    }

    // Para editar el registro de acceso
    if (editRegistroAccesoModal) {
        editRegistroAccesoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            if (button) {
                const registroId = button.getAttribute('data-id') || '';
                const usuariosId = button.getAttribute('data-usuarios_id') || '';
                const puntosAccesoId = button.getAttribute('data-puntos_acceso_id') || '';
                const metodo = button.getAttribute('data-metodo') || '';
                const fechaHora = button.getAttribute('data-fecha_hora') || '';
                const resultado = button.getAttribute('data-resultado') || '';

                // Obtener el formulario dentro del modal y actualizar su acción
                const form = document.getElementById('editRegistroAccesoForm');
                form.action = `/registros_acceso/${registroId}`;

                // Asignar valores al formulario
                document.getElementById('editUsuariosId').value = usuariosId;
                document.getElementById('editPuntosAccesoId').value = puntosAccesoId;
                document.getElementById('editMetodo').value = metodo;
                document.getElementById('editFechaHora').value = fechaHora ? new Date(fechaHora).toISOString().slice(0, 16) : '';
                document.getElementById('editResultado').value = resultado;
            } else {
                console.error('No se encontró el botón que activó el modal de "Editar".');
            }
        });
    }

    // Para eliminar el registro de acceso
    if (deleteRegistroAccesoModal) {
        deleteRegistroAccesoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            if (button) {
                const registroId = button.getAttribute('data-id') || '';
                const form = document.getElementById('deleteRegistroAccesoForm');
                form.action = `/registros_acceso/${registroId}`;
                document.getElementById('deleteRegistroAccesoId').value = registroId;
            } else {
                console.error('No se encontró el botón que activó el modal de "Eliminar".');
            }
        });
    }
});

//====================================
// GENERACION DE GRAFOICOS
//====================================
document.addEventListener('DOMContentLoaded', function () {
    // Gráfico por Método
    const ctxMetodo = document.getElementById('registrosChartMetodo');
    if (ctxMetodo) {
        const metodosLabels = ['Método 1', 'Método 2', 'Método 3']; // Simular etiquetas dinámicas
        const metodosData = [30, 40, 20]; // Simular datos dinámicos

        const dataMetodo = {
            labels: metodosLabels,
            datasets: [{
                label: 'Cantidad de Registros',
                data: metodosData,
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

        const configMetodo = {
            type: 'pie',
            data: dataMetodo,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Distribución de Registros por Método' }
                }
            }
        };

        new Chart(ctxMetodo, configMetodo);
    }

    // Gráfico por Resultado
    const ctxResultado = document.getElementById('registrosChartResultado');
    if (ctxResultado) {
        const resultadosLabels = ['Aceptado', 'Rechazado']; // Simular etiquetas dinámicas
        const resultadosData = [60, 40]; // Simular datos dinámicos

        const dataResultado = {
            labels: resultadosLabels,
            datasets: [{
                label: 'Cantidad de Registros',
                data: resultadosData,
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        };

        const configResultado = {
            type: 'bar',
            data: dataResultado,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Distribución de Registros por Resultado' }
                }
            }
        };

        new Chart(ctxResultado, configResultado);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Referencia al formulario por su ID
    const form = document.getElementById('importRegistrosAccesoForm');
    const resultadoModalElement = document.getElementById('resultadoImportacionModal');

    // Verificar que el formulario y el modal existan
    if (form && resultadoModalElement) {
        const resultadoModal = new bootstrap.Modal(resultadoModalElement); // Inicializar el modal

        // Referencias a los elementos dentro del modal
        const mensajeResultado = document.getElementById('mensajeResultado');
        const detallesResultado = document.getElementById('detallesResultado');

        // Manejar el envío del formulario
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(form);

            // Limpiar contenido previo del modal
            mensajeResultado.textContent = '';
            detallesResultado.innerHTML = '';

            // Realizar la solicitud POST
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.error) {
                        // Mostrar mensaje de error
                        mensajeResultado.innerHTML = `<span class="text-danger">${data.error}</span>`;
                    } else {
                        // Mostrar mensaje de éxito
                        mensajeResultado.innerHTML = `<span class="text-success">${data.success}</span>`;
                        detallesResultado.innerHTML = `
                            <li><strong>Nuevos registros:</strong> ${data.nuevos_registros || 0}</li>
                            <li><strong>Registros omitidos:</strong> ${data.registros_omitidos || 0}</li>
                        `;
                    }

                    // Mostrar el modal de resultados
                    resultadoModal.show();
                })
                .catch((error) => {
                    console.error('Error inesperado:', error);
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