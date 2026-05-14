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
    // filemtime asegura que si cambias un color en el config, el navegador descargue el nuevo CSS
    $version = file_exists($css_file_path) ? filemtime($css_file_path) : '1.0.0';

    wp_enqueue_style(
        'astra-child-tailwind',
        get_stylesheet_directory_uri() . '/output.css',
        array('astra-theme-css'), // Declaramos que dependemos de Astra para cargar después
        $version
    );
}

// =============================================
// 2. QUITAR ESTILOS DE WOOCOMMERCE (Limpieza de Auditoría)
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
// 3. SILENCIAR AVISO ESPECÍFICO
// =============================================
add_filter('woocommerce_add_message', function ($message) {
    // Evitamos el molesto banner de "Carrito actualizado" cada que mueves el stepper
    if (strpos($message, 'Carrito actualizado') !== false) {
        return false;
    }
    return $message;
});

// NOTA: La sección de "Bento Box" vía hooks se eliminó 
// porque ya la integramos directamente en los templates (cart-totals.php) 
// para tener un código más limpio y eficiente.