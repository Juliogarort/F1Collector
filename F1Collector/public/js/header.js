// JavaScript para el header premium de F1Collector
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos DOM
    const header = document.querySelector('.racing-header .navbar');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    const cartModal = document.getElementById('cartModal');
    
    // Verificar si hay que abrir el modal del carrito automáticamente
    checkAutoOpenCartModal();
    
    // Verificar si hay que abrir el modal de perfil
    checkOpenProfileModal();
    
    // Efecto scroll para el header
    function handleScroll() {
        const scrollTop = window.scrollY;
        
        if (scrollTop > 50) {
            header.classList.add('navbar-scrolled');
        } else {
            header.classList.remove('navbar-scrolled');
        }
    }
    
    if (header) {
        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Aplicar estado inicial
    }
    
    // Inicializar modales - CAMBIO AQUÍ PARA MANEJAR TODOS LOS BOTONES DE LOGIN
    // Seleccionar todos los botones con clase 'open-login-modal' o ID 'openLoginModal'
    const loginButtons = document.querySelectorAll('.open-login-modal, #openLoginModal');
    
    loginButtons.forEach(button => {
        button.addEventListener('click', () => {
            const bsLoginModal = new bootstrap.Modal(loginModal);
            bsLoginModal.show();
            
            // Añadir clase para la animación de entrada (solo una vez)
            const onShownHandler = function () {
                loginModal.querySelector('.modal-content').classList.add('modal-animated');
                loginModal.removeEventListener('shown.bs.modal', onShownHandler);
            };
            
            // Remover clase cuando se cierra (solo una vez)
            const onHiddenHandler = function () {
                loginModal.querySelector('.modal-content').classList.remove('modal-animated');
                loginModal.removeEventListener('hidden.bs.modal', onHiddenHandler);
            };
            
            loginModal.addEventListener('shown.bs.modal', onShownHandler);
            loginModal.addEventListener('hidden.bs.modal', onHiddenHandler);
        });
    });
    
    const openRegisterBtn = document.getElementById('openRegisterModal');
    if (openRegisterBtn) {
        openRegisterBtn.addEventListener('click', () => {
            const bsRegisterModal = new bootstrap.Modal(registerModal);
            bsRegisterModal.show();
            
            // Añadir clase para la animación de entrada
            registerModal.addEventListener('shown.bs.modal', function () {
                registerModal.querySelector('.modal-content').classList.add('modal-animated');
            });
            
            // Remover clase cuando se cierra
            registerModal.addEventListener('hidden.bs.modal', function () {
                registerModal.querySelector('.modal-content').classList.remove('modal-animated');
            });
        });
    }
    
    // Resaltar enlace activo con efecto avanzado
    const currentLocation = window.location.pathname;
    
    if (navLinks) {
        navLinks.forEach(link => {
            const linkPath = link.getAttribute('href');
            
            // Comprobar si el enlace corresponde a la ubicación actual
            if (linkPath === currentLocation || 
                (currentLocation === '/' && linkPath === '/') ||
                (currentLocation.includes(linkPath) && linkPath !== '/')) {
                
                // Aplicar estilo activo con un efecto visual
                link.classList.add('active-link');
                link.style.color = 'white';
                link.style.fontWeight = '600';
                
                // Crear elemento para el indicador activo
                const indicator = document.createElement('div');
                indicator.classList.add('active-indicator');
                indicator.style.position = 'absolute';
                indicator.style.bottom = '0';
                indicator.style.left = '0';
                indicator.style.width = '100%';
                indicator.style.height = '2px';
                indicator.style.backgroundColor = '#e10600';
                indicator.style.transform = 'scaleX(0.8)';
                indicator.style.transition = 'transform 0.3s ease';
                
                // Añadir indicador al enlace
                link.appendChild(indicator);
                
                // Animar el indicador
                setTimeout(() => {
                    indicator.style.transform = 'scaleX(1)';
                }, 100);
            }
        });
    }
    
    // Validación mejorada de formularios con feedback visual
    if (loginForm) {
        const loginEmail = document.getElementById('loginEmail');
        const loginPassword = document.getElementById('loginPassword');
        
        // Validación en tiempo real
        loginEmail.addEventListener('input', () => validateField(loginEmail, isValidEmail));
        loginPassword.addEventListener('input', () => validateField(loginPassword, isValidPassword));
        
        loginForm.addEventListener('submit', function(event) {
            let valid = true;
            
            if (!validateField(loginEmail, isValidEmail)) valid = false;
            if (!validateField(loginPassword, isValidPassword)) valid = false;
            
            if (!valid) {
                event.preventDefault();
                showFormError(loginForm, "Por favor, corrige los errores en el formulario.");
            }
        });
    }
    
    if (registerForm) {
        const registerName = document.getElementById('registerName');
        const registerEmail = document.getElementById('registerEmail');
        const registerPassword = document.getElementById('registerPassword');
        const passwordConfirm = document.querySelector('input[name="password_confirmation"]');
        
        // Validación en tiempo real
        registerName.addEventListener('input', () => validateField(registerName, isValidName));
        registerEmail.addEventListener('input', () => validateField(registerEmail, isValidEmail));
        registerPassword.addEventListener('input', () => {
            validateField(registerPassword, isValidPassword);
            if (passwordConfirm.value) validateField(passwordConfirm, value => value === registerPassword.value);
        });
        passwordConfirm.addEventListener('input', () => validateField(passwordConfirm, value => value === registerPassword.value));
        
        registerForm.addEventListener('submit', function(event) {
            let valid = true;
            
            if (!validateField(registerName, isValidName)) valid = false;
            if (!validateField(registerEmail, isValidEmail)) valid = false;
            if (!validateField(registerPassword, isValidPassword)) valid = false;
            if (!validateField(passwordConfirm, value => value === registerPassword.value)) valid = false;
            
            if (!valid) {
                event.preventDefault();
                showFormError(registerForm, "Por favor, corrige los errores en el formulario.");
            }
        });
    }
    
    // ========================================
    // FUNCIONALIDAD TOGGLE CONTRASEÑA (OJO)
    // ========================================

    // Toggle para contraseña de login
    const toggleLoginPassword = document.getElementById('toggleLoginPassword');
    if (toggleLoginPassword) {
        toggleLoginPassword.addEventListener('click', function() {
            const passwordInput = document.getElementById('loginPassword');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
                this.setAttribute('title', 'Ocultar contraseña');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
                this.setAttribute('title', 'Mostrar contraseña');
            }
        });
    }

    // Toggle para contraseña de perfil
    const toggleProfilePassword = document.getElementById('togglePassword');
    if (toggleProfilePassword) {
        toggleProfilePassword.addEventListener('click', function() {
            const passwordInput = document.getElementById('profilePassword');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
                this.setAttribute('title', 'Ocultar contraseña');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
                this.setAttribute('title', 'Mostrar contraseña');
            }
        });
    }

    // Preview de avatar cuando se selecciona un archivo
    const profileAvatar = document.getElementById('profileAvatar');
    const avatarPreview = document.getElementById('avatarPreview');

    if (profileAvatar && avatarPreview) {
        profileAvatar.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                // Validar tipo de archivo
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Por favor, selecciona un archivo de imagen válido (JPG, PNG, GIF, WEBP)');
                    this.value = '';
                    return;
                }
                
                // Validar tamaño (5MB máximo)
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('El archivo es demasiado grande. Tamaño máximo: 5MB');
                    this.value = '';
                    return;
                }
                
                // Crear URL temporal para mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    
                    // Añadir efecto visual
                    avatarPreview.style.transform = 'scale(0.8)';
                    avatarPreview.style.transition = 'transform 0.3s ease';
                    
                    setTimeout(() => {
                        avatarPreview.style.transform = 'scale(1)';
                    }, 100);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Función para manejar el envío del formulario de perfil
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData();
            
            // Obtener datos del formulario
            const name = document.getElementById('profileName').value;
            const phone = document.getElementById('profilePhone').value;
            const password = document.getElementById('profilePassword').value;
            const street = document.getElementById('profileStreet').value;
            const city = document.getElementById('profileCity').value;
            const state = document.getElementById('profileState').value;
            const postalCode = document.getElementById('profilePostalCode').value;
            const country = document.getElementById('profileCountry').value;
            const avatarFile = document.getElementById('profileAvatar').files[0];
            
            // Añadir datos al FormData
            formData.append('name', name);
            formData.append('phone', phone || '');
            if (password) formData.append('password', password);
            formData.append('street', street || '');
            formData.append('city', city || '');
            formData.append('state', state || '');
            formData.append('postal_code', postalCode || '');
            formData.append('country', country || '');
            if (avatarFile) formData.append('avatar', avatarFile);
            
            // Token CSRF
            const csrfToken = document.querySelector('input[name="_token"]').value;
            formData.append('_token', csrfToken);
            
            // Mostrar indicador de carga
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.textContent = 'Guardando...';
            submitButton.disabled = true;
            
            // Enviar datos
            fetch('/profile/update', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    showToast('Perfil actualizado correctamente', 'success');
                    
                    // Cerrar modal después de un momento
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));
                        if (modal) modal.hide();
                        
                        // Recargar página para mostrar cambios
                        window.location.reload();
                    }, 1500);
                } else {
                    showToast(data.message || 'Error al actualizar el perfil', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error de conexión', 'error');
            })
            .finally(() => {
                // Restaurar botón
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            });
        });
    }

    // Cargar datos del usuario en el modal de perfil cuando se abre
    const profileModal = document.getElementById('profileModal');
    if (profileModal) {
        profileModal.addEventListener('show.bs.modal', function() {
            // Cargar datos del usuario actual
            fetch('/profile/data', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const user = data.user;
                    
                    // Llenar campos del formulario
                    document.getElementById('profileName').value = user.name || '';
                    document.getElementById('profileEmail').value = user.email || '';
                    document.getElementById('profilePhone').value = user.phone || '';
                    document.getElementById('profileStreet').value = user.address?.street || '';
                    document.getElementById('profileCity').value = user.address?.city || '';
                    document.getElementById('profileState').value = user.address?.state || '';
                    document.getElementById('profilePostalCode').value = user.address?.postal_code || '';
                    document.getElementById('profileCountry').value = user.address?.country || '';
                    
                    // Actualizar avatar preview si existe
                    if (user.avatar) {
                        document.getElementById('avatarPreview').src = user.avatar;
                    }
                }
            })
            .catch(error => {
                console.error('Error cargando datos del perfil:', error);
            });
        });
    }
    
    // Animar los iconos de los botones en hover
    const actionButtons = document.querySelectorAll('.btn-cart, .btn-wishlist, .btn-profile, .btn-logout');
    
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    icon.style.transform = 'scale(1)';
                }, 200);
            }
        });
    });
    
    // Añadir efecto de partículas en el navbar (opcional)
    if (header) {
        addParticleEffect(header);
    }
    
    // Funciones auxiliares
    function validateField(field, validationFn) {
        const value = field.value.trim();
        const isValid = validationFn(value);
        
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            
            // Eliminar mensaje de error si existe
            const errorMessage = field.parentNode.querySelector('.invalid-feedback');
            if (errorMessage) errorMessage.remove();
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            
            // Añadir mensaje de error si no existe
            let errorMessage = field.parentNode.querySelector('.invalid-feedback');
            if (!errorMessage) {
                errorMessage = document.createElement('div');
                errorMessage.classList.add('invalid-feedback');
                field.parentNode.appendChild(errorMessage);
            }
            
            // Establecer mensaje de error apropiado
            if (field.type === 'email') {
                errorMessage.textContent = 'Introduce un correo electrónico válido.';
            } else if (field.type === 'password') {
                if (field.name === 'password_confirmation') {
                    errorMessage.textContent = 'Las contraseñas no coinciden.';
                } else {
                    errorMessage.textContent = 'La contraseña debe tener al menos 6 caracteres.';
                }
            } else {
                errorMessage.textContent = 'Este campo es requerido.';
            }
        }
        
        return isValid;
    }
    
    function showFormError(form, message) {
        // Comprobar si ya existe un mensaje de error
        let errorAlert = form.querySelector('.alert');
        
        if (!errorAlert) {
            errorAlert = document.createElement('div');
            errorAlert.classList.add('alert', 'alert-danger', 'mt-3');
            errorAlert.textContent = message;
            form.appendChild(errorAlert);
            
            // Animación de entrada
            errorAlert.style.opacity = '0';
            errorAlert.style.transform = 'translateY(-10px)';
            errorAlert.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                errorAlert.style.opacity = '1';
                errorAlert.style.transform = 'translateY(0)';
            }, 10);
            
            // Quitar mensaje después de 5 segundos
            setTimeout(() => {
                errorAlert.style.opacity = '0';
                errorAlert.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    errorAlert.remove();
                }, 300);
            }, 5000);
        }
    }
    
    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    
    function isValidPassword(password) {
        return password.length >= 6;
    }
    
    function isValidName(name) {
        return name.length >= 2;
    }
    
    // Función para mostrar toast notifications
    function showToast(message, type = 'info') {
        // Crear elemento toast
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        // Añadir al DOM
        document.body.appendChild(toast);
        
        // Inicializar y mostrar toast
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 5000
        });
        bsToast.show();
        
        // Remover del DOM cuando se oculte
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
    
    function addParticleEffect(container) {
        // Crear canvas para las partículas
        const canvas = document.createElement('canvas');
        canvas.style.position = 'absolute';
        canvas.style.top = '0';
        canvas.style.left = '0';
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.pointerEvents = 'none';
        canvas.style.zIndex = '-1';
        canvas.style.opacity = '0.2';
        
        container.style.position = 'relative';
        container.appendChild(canvas);
        
        // Configurar canvas y contexto
        let width = canvas.width = container.offsetWidth;
        let height = canvas.height = container.offsetHeight;
        
        // Partículas
        const particleCount = 15;
        const particles = [];
        
        // Inicializar partículas
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * width,
                y: Math.random() * height,
                radius: Math.random() * 1.5 + 0.5,
                color: '#e10600',
                speedX: Math.random() * 0.5 - 0.25,
                speedY: Math.random() * 0.5 - 0.25
            });
        }
        
        // Animar partículas
        const ctx = canvas.getContext('2d');
        function animateParticles() {
            ctx.clearRect(0, 0, width, height);
            particles.forEach(particle => {
                particle.x += particle.speedX;
                particle.y += particle.speedY;

                if (particle.x < 0 || particle.x > width) particle.speedX *= -1;
                if (particle.y < 0 || particle.y > height) particle.speedY *= -1;

                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
                ctx.fillStyle = particle.color;
                ctx.fill();
            });
            requestAnimationFrame(animateParticles);
        }
        animateParticles();

        // Ajustar tamaño del canvas al cambiar el tamaño de la ventana
        window.addEventListener('resize', () => {
            width = canvas.width = container.offsetWidth;
            height = canvas.height = container.offsetHeight;
        });
    }
    
    // Verificar si hay que abrir el modal del carrito automáticamente
    function checkAutoOpenCartModal() {
        // Verificar si existe el elemento con ID 'auto-open-cart-modal'
        const autoOpenElement = document.getElementById('auto-open-cart-modal');
        if (autoOpenElement) {
            try {
                // Usar setTimeout para asegurar que todos los componentes estén cargados
                setTimeout(function() {
                    const bsCartModal = new bootstrap.Modal(document.getElementById('cartModal'));
                    bsCartModal.show();
                }, 500);
            } catch (error) {
                console.error('Error al abrir automáticamente el modal del carrito:', error);
            }
        }
    }
    
    // Función para verificar si debe abrirse el modal de perfil
    function checkOpenProfileModal() {
        // Verificar si existe el elemento que indica que debe abrirse el modal de perfil
        const openProfileModal = document.getElementById('open-profile-modal');
        if (!openProfileModal) return; // Si no existe el elemento, salir de la función
        
        try {
            // Usar setTimeout para asegurar que todos los componentes estén cargados
            setTimeout(function() {
                // Verificamos que el modal exista
                const profileModalElement = document.getElementById('profileModal');
                if (!profileModalElement) {
                    console.error('Modal de perfil no encontrado');
                    return;
                }
                
                const profileModal = new bootstrap.Modal(profileModalElement);
                profileModal.show();
                
                // Si debemos enfocar el campo de contraseña
                const focusPasswordField = document.getElementById('focus-password-field');
                if (focusPasswordField) {
                    setTimeout(function() {
                        const passwordInput = document.getElementById('profilePassword');
                        if (passwordInput) {
                            passwordInput.focus();
                            // Añadir clase para resaltar el campo
                            passwordInput.classList.add('border-danger');
                            
                            // Scroll hasta el campo
                            passwordInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            
                            // Agregar mensaje de alerta sobre la contraseña si no existe
                            const parentDiv = passwordInput.closest('.col-md-6');
                            if (parentDiv && !document.getElementById('password-alert')) {
                                const alertDiv = document.createElement('div');
                                alertDiv.id = 'password-alert';
                                alertDiv.className = 'alert alert-info mt-2';
                                alertDiv.innerHTML = '<i class="bi bi-info-circle-fill me-2"></i>Para mejorar la seguridad de tu cuenta, establece una contraseña personalizada.';
                                parentDiv.appendChild(alertDiv);
                            }
                        }
                    }, 500);
                }
            }, 500);
        } catch (error) {
            console.error('Error al abrir el modal de perfil:', error);
        }
    }
    
    // Manejar dinámicamente cualquier botón de login añadido después de cargar la página
    document.addEventListener('click', function(event) {
        // Comprobar si el elemento clicado o alguno de sus padres tiene la clase 'open-login-modal'
        let target = event.target;
        while (target && target !== document) {
            if (target.classList && target.classList.contains('open-login-modal')) {
                event.preventDefault();
                const bsLoginModal = new bootstrap.Modal(loginModal);
                bsLoginModal.show();
                break;
            }
            target = target.parentNode;
        }
    });
    
    // 🔄 Limpieza forzada de backdrop y scroll cuando se cierra cualquier modal
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', () => {
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
            document.body.style.removeProperty('overflow');
            document.body.removeAttribute('aria-hidden');

            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(b => b.remove());
        });
    });

});