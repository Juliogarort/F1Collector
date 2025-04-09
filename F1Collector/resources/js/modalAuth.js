document.addEventListener('DOMContentLoaded', function () {
    const loginModalElement = document.getElementById('loginModal');
    const registerModalElement = document.getElementById('registerModal');

    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (loginModalElement) {
        const loginModal = new bootstrap.Modal(loginModalElement);

        document.getElementById('openLoginModal')?.addEventListener('click', () => {
            loginModal.show();
        });

        loginForm?.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(loginForm);

            try {
                const response = await fetch("/login", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (response.ok) {
                    location.reload();
                } else {
                    const result = await response.json();
                    alert(result.message || "Error al iniciar sesión.");
                }
            } catch (error) {
                alert("Error de conexión al iniciar sesión.");
            }
        });
    }

    if (registerModalElement) {
        const registerModal = new bootstrap.Modal(registerModalElement);

        document.getElementById('openRegisterModal')?.addEventListener('click', () => {
            registerModal.show();
        });

        registerForm?.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(registerForm);

            try {
                const response = await fetch("/register", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (response.ok) {
                    Toastify({
                        text: "Registro exitoso. ¡Bienvenido!",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#198754"
                    }).showToast();

                    setTimeout(() => location.reload(), 1500);
                } else {
                    const result = await response.json();
                    alert(result.message || "Error al registrarse.");
                }
            } catch (error) {
                alert("Error de conexión al registrarse.");
            }
        });
    }
});
