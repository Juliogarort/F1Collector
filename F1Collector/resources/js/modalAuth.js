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

            const formData = {
                email: document.getElementById('loginEmail').value,
                password: document.getElementById('loginPassword').value,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            };
            

            try {
                const response = await fetch("/login", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': formData._token
                    },
                    body: JSON.stringify(formData),
                });
                
                if (response.ok) {
                    const userResponse = await fetch("/usuario-logueado", {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                
                    const user = await userResponse.json();
                
                    // Mostrar toast
                    Toastify({
                        text: `Bienvenido, ${user.user_type === 'Admin' ? 'Admin 👑' : user.name}`,
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#dc3545",
                        stopOnFocus: true
                    }).showToast();
                
                    // Redirección
                    setTimeout(() => {
                        if (user.user_type === 'Admin') {
                            window.location.href = "/admin/products";
                        } else {
                            window.location.href = "/catalogo";
                        }
                    }, 1500); // Tiempo para que dé tiempo a leer el toast
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
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'alert alert-success mt-3';
                    messageDiv.innerHTML = `
                        Se ha enviado un enlace de verificación a tu correo. <br>
                        Por favor, verifica tu cuenta antes de continuar.
                    `;
                    registerForm.replaceWith(messageDiv);
                } else {
                    const result = await response.json();
                    alert(result.message || "Error al registrarse.");
                }
            } catch (error) {
                alert("Error de conexión al registrarse.");
            }
        });
    }

    // 🔐 Cerrar el modal automáticamente si ya está verificado
    const isVerified = document.body.dataset.verified === 'true';
    if (isVerified && registerModalElement) {
        const registerModal = bootstrap.Modal.getInstance(registerModalElement);
        if (registerModal) {
            registerModal.hide();
        }
    }
});
