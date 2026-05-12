<?php

/**
 * Astra Child - Functions
 * Estrategia: Tailwind + E-commerce Auditor OS
 */

// =============================================
// 1. CARGAR TAILWIND COMPILADO (Con Cache-Busting)
// =============================================
add_action('wp_enqueue_scripts', 'astra_child_enqueue_tailwind', 20);
function astra_child_enqueue_tailwind()
{
    $css_file_path = get_stylesheet_directory() . '/output.css';
    $version = file_exists($css_file_path) ? filemtime($css_file_path) : '1.0.0';

    wp_enqueue_style(
        'astra-child-tailwind',
        get_stylesheet_directory_uri() . '/output.css',
        array(),
        $version
    );
}

// =============================================
// 2. QUITAR ESTILOS DE WOOCOMMERCE
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
    if (strpos($message, 'Carrito actualizado') !== false) {
        return false;
    }
    return $message;
});

// =============================================
// 4. BENTO BOX PARA TOTALES
// =============================================
add_action('woocommerce_before_cart_totals', 'astra_child_bento_box_open', 5);
function astra_child_bento_box_open()
{
    // Añadimos una clase extra para asegurar el look premium
    echo '<div class="bento-box shadow-xl transition-all duration-300">';
}

add_action('woocommerce_after_cart_totals', 'astra_child_bento_box_close', 15);
function astra_child_bento_box_close()
{
    echo '</div>';
}
