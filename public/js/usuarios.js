document.addEventListener('DOMContentLoaded', function () {
    // 1. Manejo de Modales para Ver Usuario
    const viewUserModal = document.getElementById('viewUserModal');
    if (viewUserModal) {
        viewUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const nombre = button.getAttribute('data-nombre');
            const apellido = button.getAttribute('data-apellido');
            const correo = button.getAttribute('data-correo');
            const telefono = button.getAttribute('data-telefono');
            const rol = button.getAttribute('data-rol');

            document.getElementById('viewNombre').value = nombre;
            document.getElementById('viewApellido').value = apellido;
            document.getElementById('viewCorreo').value = correo;
            document.getElementById('viewTelefono').value = telefono;
            document.getElementById('viewRol').value = rol;
        });
    }

    // 2. Manejo de Modales para Editar Usuario
    const editUserModal = document.getElementById('editUserModal');
    if (editUserModal) {
        editUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            const apellido = button.getAttribute('data-apellido');
            const correo = button.getAttribute('data-correo');
            const telefono = button.getAttribute('data-telefono');
            const rol = button.getAttribute('data-rol');
            const password = button.getAttribute('data-password');

            const form = document.getElementById('editUserForm');
            form.action = `/usuarios/${userId}`;

            document.getElementById('editNombre').value = nombre;
            document.getElementById('editApellido').value = apellido;
            document.getElementById('editCorreo').value = correo;
            document.getElementById('editTelefono').value = telefono;
            document.getElementById('editRol').value = rol;
            document.getElementById('editPassword').value = password;
        });
    }

    // 3. Manejo de Modales para Eliminar Usuario
    const deleteUserModal = document.getElementById('deleteUserModal');
    if (deleteUserModal) {
        deleteUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-id');
            const form = document.getElementById('deleteUserForm');
            form.action = `/usuarios/${userId}`;
            document.getElementById('deleteUserId').value = userId;
        });
    }

    // 4. Generación de Gráfico usando Chart.js
    const ctx = document.getElementById('usersRoleChart')?.getContext('2d');
    if (ctx) {
        // Datos estáticos de ejemplo (actualiza con datos dinámicos si es necesario)
        const rolesLabels = ['Admin', 'Usuario', 'Guardia'];
        const rolesData = [10, 25, 15];

        const data = {
            labels: rolesLabels,
            datasets: [{
                label: 'Cantidad de Usuarios',
                data: rolesData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1,
            }],
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribución de Usuarios por Rol',
                    },
                },
            },
        };

        new Chart(ctx, config);
    }

    // 5. Mostrar el Modal de Importación
    const importButton = document.getElementById('importReportesButton');
    const modalElement = document.getElementById('importReportesModal');
    if (importButton && modalElement) {
        importButton.addEventListener('click', function (event) {
            event.preventDefault();
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    }

    // 6. Manejar el Formulario de Importación
    const form = document.getElementById('importReportesForm');
    const successMessage = document.getElementById('importSuccessMessage');
    const errorMessage = document.getElementById('importErrorMessage');
    const importedCount = document.getElementById('importedCount');
    const skippedCount = document.getElementById('skippedCount');
    const errorDetail = document.getElementById('errorDetail');

    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP status ${response.status}`);
                    }
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('El servidor devolvió una respuesta no válida.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    // Mostrar éxito
                    successMessage.classList.remove('d-none');
                    importedCount.textContent = data.nuevos_registros || 0;
                    skippedCount.textContent = data.registros_omitidos || 0;
                    errorMessage.classList.add('d-none');
                })
                .catch(error => {
                    console.error('Error inesperado:', error);
                    // Mostrar error
                    errorMessage.classList.remove('d-none');
                    errorDetail.textContent = error.message;
                    successMessage.classList.add('d-none');
                })
                .finally(() => {
                    // Mostrar modal de resultados
                    const resultModal = new bootstrap.Modal(document.getElementById('importResultModal'));
                    resultModal.show();
                });
        });
    }
});