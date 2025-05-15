document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.getElementById('profileForm');
    const profileModal = document.getElementById('profileModal');
    const profilePassword = document.getElementById('profilePassword');
    const togglePassword = document.getElementById('togglePassword');

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
            const response = await fetch("/usuario-logueado");
            const user = await response.json();

            document.getElementById("profileName").value = user.name || "";
            document.getElementById("profileEmail").value = user.email || "";
            document.getElementById("profilePhone").value = user.phone || "";
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

document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.getElementById('profileForm');
    const profileModal = document.getElementById('profileModal');
    const profilePassword = document.getElementById('profilePassword');
    const togglePassword = document.getElementById('togglePassword');

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
            const response = await fetch("/usuario-logueado");
            const user = await response.json();

            document.getElementById("profileName").value = user.name || "";
            document.getElementById("profileEmail").value = user.email || "";
            document.getElementById("profilePhone").value = user.phone || "";
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