document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.getElementById('profileForm');
    const profileModal = document.getElementById('profileModal');
    const profilePassword = document.getElementById('profilePassword');
    const togglePassword = document.getElementById('togglePassword');

    if (window.profileEventsInitialized) return;
    window.profileEventsInitialized = true;

    // Mostrar/ocultar contraseña
    if (togglePassword && profilePassword) {
        togglePassword.addEventListener('click', function () {
            const type = profilePassword.getAttribute('type') === 'password' ? 'text' : 'password';
            profilePassword.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    }

    if (profileModal && profileForm) {
        profileModal.addEventListener('show.bs.modal', async function () {
            try {
                const response = await fetch("/usuario-logueado");
                const user = await response.json();

                document.getElementById("profileName").value = user.name || "";
                document.getElementById("profileEmail").value = user.email || "";
                document.getElementById("profilePhone").value = user.phone || "";

                const force = document.getElementById("force-password-change");
                if (force && !document.getElementById('password-alert')) {
                    profilePassword.focus();
                    profilePassword.classList.add('border-danger');

                    const parentDiv = profilePassword.closest('.col-md-6');
                    if (parentDiv) {
                        const alertDiv = document.createElement('div');
                        alertDiv.id = 'password-alert';
                        alertDiv.className = 'alert alert-info mt-2';
                        alertDiv.innerHTML = '<i class="bi bi-info-circle-fill me-2"></i>Para mejorar la seguridad de tu cuenta, establece una contraseña personalizada.';
                        parentDiv.appendChild(alertDiv);
                    }

                    // Ocultar botón de cerrar y cerrar al fondo
                    const closeBtn = profileModal.querySelector('.btn-close');
                    const cancelBtn = profileModal.querySelector('button[data-bs-dismiss="modal"]');
                    if (closeBtn) closeBtn.classList.add('d-none');
                    if (cancelBtn) cancelBtn.classList.add('d-none');
                    // ❌ Desactivar manualmente el botón "Cerrar" si existe y el usuario debe cambiar contraseña
                    const footerCloseBtn = profileModal.querySelector('.modal-footer button[data-bs-dismiss="modal"]');
                    if (footerCloseBtn && force) {
                        footerCloseBtn.setAttribute('disabled', 'true');
                        footerCloseBtn.classList.add('disabled');
                        footerCloseBtn.addEventListener('click', function (e) {
                            e.preventDefault(); // prevenir cierre por si aún no está deshabilitado
                            e.stopPropagation();
                        });
                    }

                }
            } catch (error) {
                console.error('Error al cargar datos del usuario:', error);
            }
        });

    profileForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(profileForm);
        const mustChange = document.getElementById("force-password-change");
        const passwordValue = formData.get('password')?.trim();

        // Validar si hay que cambiar contraseña obligatoriamente
        if (mustChange && (!passwordValue || passwordValue.length < 6)) {
            Toastify({
                text: "Debes establecer una contraseña válida (mínimo 6 caracteres)",
                backgroundColor: "#dc3545",
                duration: 4000,
                position: "center"
            }).showToast();
            profilePassword.focus();
            return;
        }

        try {
            const response = await fetch("/profile/update", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                Toastify({
                    text: "Perfil actualizado correctamente",
                    backgroundColor: "#28a745",
                    duration: 2000,
                    position: "center"
                }).showToast();

                setTimeout(() => {
                    window.location.reload();
                }, 2000); // Espera a que el Toast se muestre antes de recargar
                return;
            } else {
                throw new Error(result.message || "Error al actualizar");
            }
        } catch (error) {
            Toastify({
                text: error.message,
                backgroundColor: "#dc3545",
                duration: 3000,
                position: "center"
            }).showToast();
        }
    });

    }

    // Forzar apertura automática si el usuario viene de Google
    const mustStay = document.getElementById("force-password-change");
    if (mustStay && profileModal) {
        const enforcedModal = new bootstrap.Modal(profileModal, {
            backdrop: 'static',
            keyboard: false
        });
        enforcedModal.show();
    }
});