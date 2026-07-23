<?php

/**
 * Astra Child - Functions
 * Estrategia: Tailwind + E-commerce Auditor OS
 */

if (! defined('ABSPATH')) {
    exit;
}

// =============================================
// 1. CARGAR TAILWIND COMPILADO (Con Cache-Busting)
// =============================================
add_action('wp_enqueue_scripts', 'astra_child_enqueue_tailwind', 25);
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

    if (function_exists('is_cart') && is_cart() && file_exists($js_file_path)) {
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
// 3. QUITAR ESTILOS DE WOOCOMMERCE (Solo en el carrito)
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

// Evitamos SOLO el molesto banner de "Carrito actualizado"
add_filter('woocommerce_add_message', function ($message) {
    if (strpos($message, 'Carrito actualizado') !== false) {
        return false;
    }
    return $message;
});

// Apagamos el aviso nativo de "Producto eliminado" (El modal JS toma el control)
add_filter('woocommerce_cart_item_removed_notice_type', '__return_empty_string');

// Eliminar el mensaje nativo de "Producto añadido al carrito"
add_filter('wc_add_to_cart_message_html', '__return_false');

// =============================================
// 5. UBICACIÓN DEL CUPÓN EN CHECKOUT
// =============================================

// Desenganchar el formulario del cupón de la parte superior del checkout
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);

// =============================================
// 6. PERSONALIZACIÓN DE TEXTOS CTA
// =============================================

// Cambia el texto del botón "Finalizar Compra" específicamente en el Checkout
add_filter('woocommerce_order_button_text', function () {
    return 'Revisar y pagar';
});

// Cambia el texto del botón en la página del Carrito (Bento Box de Resumen)
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

// =============================================
// 7. PERSONALIZACIÓN DE MÉTODOS DE PAGO (BENTO UI)
// =============================================

// Modificar la descripción redundante de PayPal
add_filter('woocommerce_gateway_description', 'oftalmed_custom_paypal_description', 10, 2);
function oftalmed_custom_paypal_description($description, $gateway_id)
{
    // ACTUALIZADO: El identificador real de tu plugin es 'ppcp-gateway'
    if ('ppcp-gateway' === $gateway_id) {
        $description = '<p class="text-text-muted text-[13px] leading-relaxed mt-1">Serás redirigido de forma segura a la plataforma de PayPal para completar tu transacción.</p>';
    }
    return $description;
}

// Inyectar el logotipo oficial junto al título de PayPal
add_filter('woocommerce_gateway_icon', 'oftalmed_custom_paypal_icon', 10, 2);
function oftalmed_custom_paypal_icon($icon, $gateway_id)
{
    // ACTUALIZADO: El identificador real de tu plugin es 'ppcp-gateway'
    if ('ppcp-gateway' === $gateway_id) {
        $logo_url = get_stylesheet_directory_uri() . '/assets/img/paypal-logo.svg';
        $icon = '<img src="' . esc_url($logo_url) . '" alt="Logo de PayPal" class="inline-block h-5 ml-4 object-contain relative -top-[1px]" />';
    }
    return $icon;
}

// =============================================
// 8. VALIDACIÓN SILENCIOSA PARA OPENPAY (JS INLINE)
// =============================================
add_action('wp_footer', 'oftalmed_openpay_inline_validation', 99);
function oftalmed_openpay_inline_validation()
{
    // Solo cargamos este script en la página de checkout
    if (! function_exists('is_checkout') || ! is_checkout()) return;
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Escuchamos los clics para delegar eventos, ya que los métodos de pago se cargan por AJAX
            document.body.addEventListener('blur', function(e) {

                // Verificamos si el elemento que perdió el foco pertenece a Openpay
                if (e.target.matches('#payment_form_openpay_cards input[type="text"], #payment_form_openpay_cards input[type="number"], select#openpay_selected_card')) {

                    // Encontramos el contenedor padre (.form-row)
                    const parentRow = e.target.closest('.form-row');
                    if (!parentRow) return;

                    // Si está vacío, aplicamos clase de error. Si tiene texto, la quitamos.
                    if (e.target.value.trim() === '') {
                        parentRow.classList.add('woocommerce-invalid');
                        parentRow.classList.remove('woocommerce-validated');
                    } else {
                        parentRow.classList.remove('woocommerce-invalid');
                        parentRow.classList.add('woocommerce-validated');
                    }
                }
            }, true); // El 'true' es importante para capturar el evento blur (fase de captura)
        });
    </script>
<?php
}

// =============================================
// 10. REEMPLAZAR MENSAJES DE ERROR DE OPENPAY (JS)
// =============================================
add_action('wp_footer', 'oftalmed_custom_openpay_error_text', 99);
function oftalmed_custom_openpay_error_text()
{
    if (! function_exists('is_checkout') || ! is_checkout()) return;
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Creamos un observador que vigile cuando el contenedor de errores cambie o aparezca
            const observer = new MutationObserver(function(mutations) {
                // Usamos un selector más amplio para atrapar ambas clases del inspector
                const errorContainer = document.querySelector('#wc_openpay_gateway ul.woocommerce-error, #wc_openpay_gateway ul.woocommerce_error');

                if (errorContainer) {
                    // Buscamos una coincidencia amplia ('ERROR 1') para asegurar que atrape la cadena
                    if (errorContainer.textContent.includes('ERROR 1') || errorContainer.textContent.includes('El nombre del titular')) {
                        // Lo reemplazamos por el texto limpio y corporativo
                        errorContainer.innerHTML = '<li>Por favor, verifica que el nombre del titular coincida exactamente con el de tu tarjeta.</li>';
                    }
                }
            });

            // LA CLAVE: Vigilar TODO el body para sobrevivir a las recargas AJAX de WooCommerce
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>
<?php
}
