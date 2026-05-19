<?php

/**
 * Astra Child - Functions
 * Estrategia: Tailwind + E-commerce Auditor OS
 */

// =============================================
// 1. CARGAR TAILWIND COMPILADO (Con Cache-Busting)
// =============================================
add_action('wp_enqueue_scripts', 'astra_child_enqueue_tailwind', 25); // Prioridad 25 para entrar justo después de Astra
function astra_child_enqueue_tailwind()
{
    $css_file_path = get_stylesheet_directory() . '/output.css';
    $version = file_exists($css_file_path) ? filemtime($css_file_path) : '1.0.0';

    wp_enqueue_style(
        'astra-child-tailwind',
        get_stylesheet_directory_uri() . '/output.css',
        array('astra-theme-css'),
        $version
    );
}

// =============================================
// 2. CARGAR SCRIPTS DE MODALES (Carrito)
// =============================================
add_action('wp_enqueue_scripts', 'oftalmed_enqueue_custom_cart_scripts');
function oftalmed_enqueue_custom_cart_scripts()
{
    // Solo cargamos el JS si estamos en el carrito y el archivo existe
    $js_file_path = get_stylesheet_directory() . '/assets/js/cart-modals.js';

    if (is_cart() && file_exists($js_file_path)) {
        wp_enqueue_script(
            'oftalmed-cart-modals',
            get_stylesheet_directory_uri() . '/assets/js/cart-modals.js',
            array(),
            filemtime($js_file_path),
            true // En el footer
        );
    }
}

// =============================================
// 3. QUITAR ESTILOS DE WOOCOMMERCE (Limpieza de Auditoría)
// =============================================
add_action('wp_enqueue_scripts', 'astra_child_clean_cart_css', 999);
function astra_child_clean_cart_css()
{
    if (!function_exists('is_cart') || !is_cart()) return;

    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
}

// =============================================
// 4. GESTIÓN DE AVISOS Y NOTIFICACIONES
// =============================================

// Evitamos el molesto banner de "Carrito actualizado"
add_filter('woocommerce_add_message', function ($message) {
    if (strpos($message, 'Carrito actualizado') !== false) {
        return false;
    }
    return $message;
});

// Apagamos el aviso nativo de "Producto eliminado" (El modal JS toma el control)
add_filter('woocommerce_cart_item_removed_notice_type', '__return_empty_string');

/**
 * Oftalmed: Eliminar el mensaje nativo de "Producto añadido al carrito"
 */
add_filter('wc_add_to_cart_message_html', '__return_false');
// =============================================
// 5. PERSONALIZACIÓN DE TEXTOS CTA
// =============================================

/**
 * Cambia el texto del botón "Finalizar Compra" específicamente en el Checkout
 */
add_filter('woocommerce_order_button_text', function () {
    return 'Revisar y pagar';
});

/**
 * Cambia el texto del botón en la página del Carrito (Bento Box de Resumen)
 */
remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
add_action('woocommerce_proceed_to_checkout', 'oftalmed_custom_checkout_button_text', 20);

function oftalmed_custom_checkout_button_text()
{
?>
    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-button button alt wc-forward">
        <?php esc_html_e('Revisar y pagar', 'woocommerce'); ?>
    </a>
<?php
}
