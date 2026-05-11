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
    // Obtiene la ruta física del archivo para leer su fecha de modificación
    $css_file_path = get_stylesheet_directory() . '/output.css';
    $version = file_exists($css_file_path) ? filemtime($css_file_path) : '1.0.0';

    wp_enqueue_style(
        'astra-child-tailwind',
        get_stylesheet_directory_uri() . '/output.css',
        array(),
        $version // Fuerza al navegador a recargar el CSS solo cuando detecta un cambio nuevo
    );
}

// =============================================
// 2. QUITAR ESTILOS DE WOOCOMMERCE
// =============================================
add_action('wp_enqueue_scripts', 'astra_child_clean_cart_css', 999);
function astra_child_clean_cart_css()
{
    if (!function_exists('is_cart') || !is_cart()) return;

    // Quitamos los estilos base porque Tailwind tiene el control absoluto
    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
}

// =============================================
// 3. BENTO BOX PARA TOTALES
// =============================================
add_action('woocommerce_before_cart_totals', 'astra_child_bento_box_open', 5);
function astra_child_bento_box_open()
{
    // Solo abrimos el contenedor, WooCommerce se encarga de imprimir los títulos
    echo '<div class="bento-box">';
}

add_action('woocommerce_after_cart_totals', 'astra_child_bento_box_close', 15);
function astra_child_bento_box_close()
{
    echo '</div>';
}
