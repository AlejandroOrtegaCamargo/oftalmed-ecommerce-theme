<?php

/**
 * Empty cart page - Astra Child Redesign
 * @package AstraChild
 */

defined('ABSPATH') || exit;
?>

<!-- LA CLASE .woocommerce ES VITAL PARA QUE EL AJAX NO COLAPSE -->
<div class="woocommerce max-w-6xl mx-auto py-12 px-4">

    <!-- Avisos nativos interceptados (Éxito/Error) -->
    <div class="woocommerce-notices-wrapper mb-8 w-full">
        <?php wc_print_notices(); ?>
    </div>

    <h2 class="text-4xl font-bold text-brand-primary tracking-tight mb-12 text-center">
        Mi carrito
    </h2>

    <!-- REFACTOR: Uso de surface-default, rounded-bento, surface-line y shadow-bento -->
    <div class="bg-surface-default rounded-bento border border-surface-line shadow-bento p-8 md:p-12 text-center max-w-2xl mx-auto flex flex-col items-center">

        <!-- REFACTOR: Uso de brand-light para el fondo sutil -->
        <div class="w-24 h-24 bg-brand-light rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
        </div>

        <!-- REFACTOR: text-text-heading en lugar de gray-900 -->
        <p class="text-2xl font-black text-text-heading mb-2 tracking-tight">
            Tu carrito está vacío
        </p>

        <!-- REFACTOR: text-text-muted en lugar de gray-500 -->
        <p class="text-text-muted font-medium !mb-10">
            Parece que aún no has añadido productos a tu selección.
        </p>

        <?php if (wc_get_page_id('shop') > 0) : ?>
            <p class="return-to-shop w-full sm:w-auto m-0">
                <!-- REFACTOR: Botón pro blindado con tokens (brand-primary, rounded-btn, btn-hover) y protección de !text-white -->
                <a class="flex items-center justify-center w-full sm:w-[250px] h-[52px] bg-brand-accent !text-white text-base font-bold rounded-btn no-underline transition-all duration-300 hover:bg-brand-hover hover:-translate-y-0.5 hover:shadow-btn-hover hover:!text-white"
                    href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                    Volver a la tienda
                </a>
            </p>
        <?php endif; ?>
    </div>
</div>