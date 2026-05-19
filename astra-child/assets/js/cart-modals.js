document.addEventListener('DOMContentLoaded', function() {
    
    /**
     * Captura de clic con Fase de Captura (true) para ganar a WooCommerce
     */
    const handleRemoveClick = function(e) {
        const removeBtn = e.target.closest('a.remove, .btn-pill-remove');
        
        if (removeBtn) {
            e.preventDefault(); 
            e.stopImmediatePropagation(); 
            
            const removeUrl = removeBtn.getAttribute('href');
            crearModalEliminar(removeUrl);
        }
    };

    document.body.addEventListener('click', handleRemoveClick, true);

    function crearModalEliminar(confirmUrl) {
        if (document.getElementById('oftalmed-remove-modal')) return;

        // El contenedor inicia en opacity-0 y la tarjeta inicia en scale-95 para la animación
        const modalHTML = `
            <div id="oftalmed-remove-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-text-heading/40 backdrop-blur-sm p-4 opacity-0 transition-opacity duration-300 ease-out">
                <div id="oftalmed-modal-card" class="bg-surface-default rounded-bento p-8 max-w-sm w-full shadow-bento border border-surface-line relative transform scale-95 transition-transform duration-300 ease-out">
                    
                    <button id="modal-close-x" class="absolute top-4 right-4 p-2 text-text-muted hover:text-text-body transition-all bg-surface-line hover:bg-surface-ash rounded-full border-0 shadow-none outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <div class="text-center mt-8 mb-8">
                        <p class="text-text-heading font-bold text-lg tracking-tight">¿Quitar este producto del carrito?</p>
                        <p class="text-text-body text-sm mt-2 font-medium">Puedes volver a añadirlo desde la tienda.</p>
                    </div>

                    <div class="flex gap-4 w-full">
                        
                        <button id="modal-btn-no" class="flex-1 py-3 bg-brand-accent text-white font-bold rounded-btn hover:bg-brand-hover transition-all active:scale-95 shadow-btn border-0">
                            Mantener
                        </button>
                        
                        <button id="modal-btn-si" class="flex-1 py-3 border border-surface-ash bg-surface-default text-text-body font-bold rounded-btn transition-all duration-200 hover:bg-surface-muted hover:border-text-heading hover:text-text-heading active:scale-95 shadow-none hover:shadow-sm">
                            Quitar
                        </button>

                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        const modal = document.getElementById('oftalmed-remove-modal');
        const card = document.getElementById('oftalmed-modal-card');
        const btnSi = document.getElementById('modal-btn-si');
        const btnNo = document.getElementById('modal-btn-no');
        const btnClose = document.getElementById('modal-close-x');

        // ANIMACIÓN DE ENTRADA: Activamos el fundido y escalado un milisegundo después de inyectarlo
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);

        // ANIMACIÓN DE SALIDA: Suave desaparición antes de eliminar el nodo del DOM
        const cerrarModal = () => {
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
            setTimeout(() => modal.remove(), 300); // 300ms idénticos a la duración de la transición
        };

        btnNo.addEventListener('click', cerrarModal);
        btnClose.addEventListener('click', cerrarModal);
        
        btnSi.addEventListener('click', function() {
            this.innerHTML = '<span class="opacity-50 text-xs font-bold">Eliminando...</span>';
            this.disabled = true;
            window.location.href = confirmUrl;
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) cerrarModal();
        });
    }
});