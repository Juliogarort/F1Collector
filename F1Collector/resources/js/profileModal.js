// JavaScript para el modal de perfil
document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.getElementById('profileForm');
    const profileModal = document.getElementById('profileModal');
    const profilePassword = document.getElementById('profilePassword');
    const togglePassword = document.getElementById('togglePassword');

    // Evitar registrar eventos múltiples veces
    // Esto es crítico para evitar los alerts duplicados
    if (window.profileEventsInitialized) return;
    window.profileEventsInitialized = true;

    // Funcionalidad para mostrar/ocultar contraseña
    if (togglePassword && profilePassword) {
        togglePassword.addEventListener('click', function () {
            // Cambiar el tipo de input
            const type = profilePassword.getAttribute('type') === 'password' ? 'text' : 'password';
            profilePassword.setAttribute('type', type);
            
            // Cambiar el icono
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
                
                // Verificar si hay un mensaje de alerta que mostrar en caso de que
                // estemos abriendo el modal para cambiar contraseña tras registro Google
                const focusPasswordField = document.getElementById('focus-password-field');
                if (focusPasswordField && 
                    !document.getElementById('password-alert')) {
                    const passwordInput = document.getElementById('profilePassword');
                    if (passwordInput) {
                        passwordInput.focus();
                        passwordInput.classList.add('border-danger');
                        
                        const parentDiv = passwordInput.closest('.col-md-6');
                        if (parentDiv) {
                            const alertDiv = document.createElement('div');
                            alertDiv.id = 'password-alert';
                            alertDiv.className = 'alert alert-info mt-2';
                            alertDiv.innerHTML = '<i class="bi bi-info-circle-fill me-2"></i>Para mejorar la seguridad de tu cuenta, establece una contraseña personalizada.';
                            parentDiv.appendChild(alertDiv);
                        }
                    }
                }
            } catch (error) {
                console.error('Error al cargar datos del usuario:', error);
            }
        });

        profileForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(profileForm);

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
                        duration: 3000,
                        position: "center"
                    }).showToast();
                    
                    // Eliminar elementos de sesión si existen
                    const openProfileModal = document.getElementById('open-profile-modal');
                    const focusPasswordField = document.getElementById('focus-password-field');
                    const passwordAlert = document.getElementById('password-alert');
                    
                    if (openProfileModal) openProfileModal.remove();
                    if (focusPasswordField) focusPasswordField.remove();
                    if (passwordAlert) passwordAlert.remove();
                    
                    bootstrap.Modal.getInstance(profileModal).hide();
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
});