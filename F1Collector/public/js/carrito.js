// Archivo: public/js/carrito.js
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si Bootstrap está disponible
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap JS no está disponible. El modal del carrito no funcionará correctamente.');
    }
    
    // No necesitamos manejar los botones de cantidad aquí, ya que ahora son enlaces directos
    
    // Mostrar notificaciones de operaciones del carrito
    function showNotification(message, type = 'success') {
        if (!message) return;
        
        // Eliminar notificaciones existentes
        const existingNotifications = document.querySelectorAll('.cart-notification');
        existingNotifications.forEach(notification => notification.remove());
        
        // Crear la notificación
        const notification = document.createElement('div');
        notification.className = `cart-notification alert alert-${type} position-fixed top-0 end-0 m-3 shadow-lg`;
        notification.style.zIndex = '9999';
        notification.style.maxWidth = '300px';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle'} me-2"></i>
                <div>${message}</div>
            </div>
            <div class="progress mt-2" style="height: 3px;">
                <div class="progress-bar bg-${type}" style="width: 100%"></div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animación de la barra de progreso y desaparición automática
        let progress = notification.querySelector('.progress-bar');
        let width = 100;
        const interval = setInterval(() => {
            width -= 1;
            if (progress) progress.style.width = width + '%';
            
            if (width <= 0) {
                clearInterval(interval);
                notification.remove();
            }
        }, 30); // 3 segundos en total
    }
    
    // Comprobar si hay mensajes flash de sesión
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');
    
    if (successMessage && successMessage.textContent.trim()) {
        showNotification(successMessage.textContent, 'success');
    }
    
    if (errorMessage && errorMessage.textContent.trim()) {
        showNotification(errorMessage.textContent, 'danger');
    }
    
    // Añadir estilo para enlaces desactivados
    const disabledLinks = document.querySelectorAll('a[disabled]');
    disabledLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevenir la navegación
        });
        link.style.opacity = '0.65';
        link.style.pointerEvents = 'none';
    });
});