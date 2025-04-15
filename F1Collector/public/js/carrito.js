// Archivo: public/js/carrito.js
document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencias a elementos del DOM
    const cartButton = document.querySelector('.btn-cart');
    const cartModal = document.getElementById('cartModal');
    
    // Si existe el botón del carrito, añadir event listener
    if (cartButton) {
        cartButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Comprobar si Bootstrap está disponible
            if (typeof bootstrap !== 'undefined') {
                // Usar Bootstrap 5 para mostrar el modal
                const cartModalInstance = new bootstrap.Modal(cartModal);
                cartModalInstance.show();
                
                // Cargar contenido del carrito
                loadCartContents();
            } else {
                console.error('Bootstrap no está disponible. Asegúrate de incluir Bootstrap JS.');
                // Alternativa: usar jQuery si está disponible
                if (typeof $ !== 'undefined' && typeof $('#cartModal').modal === 'function') {
                    $('#cartModal').modal('show');
                    loadCartContents();
                } else {
                    console.error('Ni Bootstrap ni jQuery están disponibles para mostrar el modal.');
                }
            }
        });
    } else {
        console.error('No se encontró el botón del carrito en el DOM');
    }
    
    // Resto del código para manejar el carrito
    const cartItems = document.getElementById('cartItems');
    const emptyCartMessage = document.getElementById('emptyCartMessage');
    const cartSummary = document.getElementById('cartSummary');
    const checkoutButton = document.getElementById('checkoutButton');
    
    // Función para cargar los contenidos del carrito
    function loadCartContents() {
        // Simulación: verificar si hay elementos en el carrito (esto se reemplazaría con tu lógica real)
        const hasItems = false; // Cambiar a true para probar con items
        
        if (hasItems) {
            // Mostrar los items y el resumen
            cartItems.classList.remove('d-none');
            cartSummary.classList.remove('d-none');
            emptyCartMessage.classList.add('d-none');
            checkoutButton.removeAttribute('disabled');
        } else {
            // Mostrar mensaje de carrito vacío
            cartItems.classList.add('d-none');
            cartSummary.classList.add('d-none');
            emptyCartMessage.classList.remove('d-none');
            checkoutButton.setAttribute('disabled', 'disabled');
        }
    }
    
    // Eventos para los botones de incrementar/decrementar cantidad
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('increase-qty')) {
            const input = e.target.parentElement.querySelector('.item-qty');
            input.value = parseInt(input.value) + 1;
            updateItemTotal(input);
        } else if (e.target.classList.contains('decrease-qty')) {
            const input = e.target.parentElement.querySelector('.item-qty');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateItemTotal(input);
            }
        } else if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
            // Lógica para eliminar item
            const item = e.target.closest('.cart-item');
            if (item) {
                item.remove();
                // Verificar si quedan items en el carrito
                if (cartItems.children.length === 0) {
                    loadCartContents(); // Recargar vista (mostrará el mensaje vacío)
                } else {
                    updateCartTotals(); // Actualizar los totales
                }
            }
        }
    });
    
    // Función para actualizar el total de un item específico
    function updateItemTotal(input) {
        // Implementar cuando tengas la estructura real de tus datos
        console.log('Actualizar total para item con cantidad:', input.value);
    }
    
    // Función para actualizar los totales del carrito
    function updateCartTotals() {
        // Implementar cuando tengas la estructura real de tus datos
        console.log('Actualizando totales del carrito');
    }
});