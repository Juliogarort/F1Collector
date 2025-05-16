document.addEventListener("DOMContentLoaded", function () {
    const loginModalElement = document.getElementById("loginModal");
    const registerModalElement = document.getElementById("registerModal");

    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    if (loginModalElement) {
        const loginModal = new bootstrap.Modal(loginModalElement);

        document
            .getElementById("openLoginModal")
            ?.addEventListener("click", () => {
                loginModal.show();
            });

        // 🔄 Actualizar token CSRF dinámicamente al abrir el modal de login
        loginModalElement.addEventListener("show.bs.modal", () => {
            const newToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            const csrfInput = loginForm.querySelector('input[name="_token"]');
            if (csrfInput) csrfInput.value = newToken;
        });

        loginForm?.addEventListener("submit", async function (e) {
            e.preventDefault();

            const formData = new FormData(loginForm); // ✅ Enviar como formulario real

            try {
                const response = await fetch("/login", {
                    method: "POST",
                    headers: {
                        Accept: "application/json", // ✅ No pongas Content-Type manualmente
                    },
                    body: formData, // ✅ Laravel acepta esto con CSRF incluido
                });

                if (response.ok) {
                    const userResponse = await fetch("/usuario-logueado", {
                        headers: {
                            Accept: "application/json",
                        },
                    });

                    const user = await userResponse.json();

                    // Mostrar toast
                    Toastify({
                        text: `Bienvenido, ${
                            user.user_type === "Admin" ? "Admin 👑" : user.name
                        }`,
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#dc3545",
                        stopOnFocus: true,
                    }).showToast();

                    // Redirección
                    setTimeout(() => {
                        if (user.user_type === "Admin") {
                            window.location.href = "/admin/menu"; // Cambio de "/admin/products" a "/admin/menu"
                        } else {
                            window.location.replace("/catalogo");
                        }
                    }, 1500);
                } else {
                    const result = await response.json();
                    const friendlyMessage =
                        result.message === "auth.failed"
                            ? "Correo o contraseña incorrectos. Inténtalo de nuevo."
                            : result.message;

                    showLoginError(friendlyMessage);
                }
            } catch (error) {
                alert("Error de conexión al iniciar sesión.");
            }
        });
    }

    if (registerModalElement) {
        const registerModal = new bootstrap.Modal(registerModalElement);

        document
            .getElementById("openRegisterModal")
            ?.addEventListener("click", () => {
                registerModal.show();
            });

        registerForm?.addEventListener("submit", async function (e) {
            e.preventDefault();

            const formData = new FormData(registerForm);

            try {
                const response = await fetch("/register", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": formData.get("_token"),
                        Accept: "application/json",
                    },
                    body: formData,
                });

                if (response.ok) {
                    const messageDiv = document.createElement("div");
                    messageDiv.className = "alert alert-success mt-3";
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
    const isVerified = document.body.dataset.verified === "true";
    if (isVerified && registerModalElement) {
        const registerModal = bootstrap.Modal.getInstance(registerModalElement);
        if (registerModal) {
            registerModal.hide();
        }
    }

    // Mostrar errores dentro del modal de login
    function showLoginError(message) {
        if (message && message.toLowerCase().includes("csrf token mismatch")) {
            // ❌ No mostrar este error específico
            return;
        }
        const alertBox = document.getElementById("loginError");
        const alertText = document.getElementById("loginErrorText");
        if (alertText && alertBox) {
            alertText.innerText = message || "Error al iniciar sesión.";
            alertBox.style.display = "block";
        }
    }
});
