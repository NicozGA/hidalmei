document.addEventListener('DOMContentLoaded', () => {
    // Confirmación al vaciar el carrito o eliminar un producto
    const btnVaciar = document.querySelector('.btn-vaciar');
    if (btnVaciar) {
        btnVaciar.addEventListener('click', (e) => {
            if (!confirm('¿Estás seguro de que deseas vaciar el carrito?')) {
                e.preventDefault();
            }
        });
    }

    // Auto-ocultar alertas o mensajes de error después de 4 segundos
    const alertMessage = document.querySelector('.alert-message');
    if (alertMessage) {
        setTimeout(() => {
            alertMessage.style.transition = 'opacity 0.5s ease';
            alertMessage.style.opacity = '0';
            setTimeout(() => alertMessage.remove(), 500);
        }, 4000);
    }
});