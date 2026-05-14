<?php

/**
 * Cart Page - Astra Child Redesign para Oftalmed
 * @package AstraChild
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<!-- El wrapper maestro .woocommerce es crucial para el AJAX -->
<div class="woocommerce max-w-6xl mx-auto py-12 px-4">

    <!-- INYECTADO: Contenedor para Avisos de WooCommerce -->
    <div class="woocommerce-notices-wrapper mb-8">
        <?php wc_print_notices(); ?>
    </div>

    <!-- BARRA DE PROGRESO DE COMPRA -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 mb-12 pb-6 border-b border-surface-line">

        <h2 class="text-4xl font-bold text-brand-primary tracking-tight m-0">
            Mi carrito
        </h2>

        <nav class="flex w-full max-w-md items-center pt-2 pb-8 mt-4 md:mt-0" aria-label="Progreso del pedido">

            <div class="relative flex flex-col items-center justify-center">
                <!-- REFACTOR: bg-brand-light -->
                <div class="w-6 h-6 rounded-full bg-brand-light flex items-center justify-center z-10">
                    <div class="w-2.5 h-2.5 bg-brand-primary rounded-full"></div>
                </div>
                <span class="absolute top-8 left-1/2 -translate-x-1/2 text-sm font-bold text-brand-primary whitespace-nowrap">Mi carrito</span>
            </div>

            <!-- REFACTOR: bg-surface-line -->
            <div class="flex-1 h-[2px] bg-surface-line flex">
                <div class="w-1/3 h-full bg-brand-primary"></div>
            </div>

            <div class="relative flex flex-col items-center justify-center">
                <div class="w-6 h-6 flex items-center justify-center z-10">
                    <!-- REFACTOR: bg-surface-line -->
                    <div class="w-3 h-3 bg-surface-line rounded-full"></div>
                </div>
                <!-- REFACTOR: text-text-muted -->
                <span class="absolute top-8 left-1/2 -translate-x-1/2 text-sm font-medium text-text-muted whitespace-nowrap">Comprobar</span>
            </div>

            <!-- REFACTOR: bg-surface-line -->
            <div class="flex-1 h-[2px] bg-surface-line"></div>

            <div class="relative flex flex-col items-center justify-center">
                <div class="w-6 h-6 flex items-center justify-center z-10">
                    <!-- REFACTOR: bg-surface-line -->
                    <div class="w-3 h-3 bg-surface-line rounded-full"></div>
                </div>
                <!-- REFACTOR: text-text-muted -->
                <span class="absolute top-8 left-1/2 -translate-x-1/2 text-sm font-medium text-text-muted whitespace-nowrap">Pagar</span>
            </div>

        </nav>
    </div>

    <!-- ESTRUCTURA A DOS COLUMNAS -->
    <div class="flex flex-col lg:flex-row gap-12">

        <!-- FASE 2: LISTADO DE PRODUCTOS -->
        <!-- REFACTOR: bg-surface-default, rounded-bento, border-surface-line, shadow-bento -->
        <form id="oftalmed-cart-form" class="woocommerce-cart-form lg:w-7/12 h-fit bg-surface-default rounded-bento border border-surface-line shadow-bento overflow-hidden" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

            <!-- Cabecera interna del Carrito -->
            <!-- REFACTOR: border-surface-line, bg-surface-default -->
            <div class="px-10 py-6 border-b border-surface-line flex justify-between items-center bg-surface-default">
                <!-- REFACTOR: text-text-muted -->
                <span class="text-[13px] font-bold text-text-muted tracking-widest-xl">Su Selección</span>
                <span class="text-[13px] font-bold text-text-muted tracking-widest">
                    <?php echo sprintf(_n('%d unidad', '%d unidades', WC()->cart->get_cart_contents_count(), 'woocommerce'), WC()->cart->get_cart_contents_count()); ?>
                </span>
            </div>

            <div class="px-10">
                <?php
                $cart_items = WC()->cart->get_cart();
                $last_item_key = array_key_last($cart_items);

                foreach ($cart_items as $cart_item_key => $cart_item) :
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0):
                        $product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';

                        // REFACTOR: border-surface-line
                        $border_class = ($cart_item_key !== $last_item_key) ? 'border-b border-surface-line' : '';

                        $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                        $product_subtotal = apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                ?>
                        <div class="cart_item flex flex-col sm:flex-row py-12 gap-10 items-start <?php echo $border_class; ?>">

                            <div class="h-32 w-32 flex-shrink-0 overflow-hidden bg-transparent">
                                <?php
                                $thumbnail = $_product->get_image('woocommerce_thumbnail', array('class' => 'object-contain w-full h-full mix-blend-multiply bg-transparent'));
                                echo apply_filters('woocommerce_cart_item_thumbnail', $thumbnail, $cart_item, $cart_item_key);
                                ?>
                            </div>

                            <div class="flex flex-1 flex-col justify-start">

                                <div class="flex justify-between items-start gap-8 w-full">
                                    <div class="flex-1">
                                        <!-- REFACTOR: text-text-heading -->
                                        <h3 class="text-base font-bold text-text-heading leading-snug tracking-tight">
                                            <a href="<?php echo esc_url($product_permalink); ?>" class="hover:text-brand-primary transition-colors">
                                                <?php echo $_product->get_name(); ?>
                                            </a>
                                        </h3>
                                    </div>

                                    <div class="text-right">
                                        <!-- REFACTOR: text-text-heading -->
                                        <p class="text-lg font-black text-text-heading tracking-tighter !mb-0 line-height-none">
                                            <?php echo $product_subtotal; ?>
                                        </p>
                                        <?php if ($cart_item['quantity'] > 1) : ?>
                                            <!-- REFACTOR: text-text-muted -->
                                            <p class="text-[11px] font-medium text-text-muted !mb-0 mt-0.5">
                                                <?php echo $product_price; ?> c/u
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mt-8 w-full">

                                    <div class="flex items-center gap-4">
                                        <!-- REFACTOR: text-text-muted, tracking-widest-xl -->
                                        <span class="text-[12px] font-black text-text-muted tracking-widest-xl">Cantidad</span>

                                        <!-- REFACTOR: border-surface-line, bg-surface-default, rounded-input -->
                                        <div class="flex items-center border border-surface-line rounded-input h-[34px] bg-surface-default overflow-hidden w-[90px]">
                                            <!-- REFACTOR: text-text-muted -->
                                            <button type="button" class="qty-btn w-8 h-full flex items-center justify-center text-text-muted hover:text-brand-primary transition-colors text-lg" data-step="-1">&minus;</button>

                                            <div class="flex-1 custom-qty-styles h-full flex items-center justify-center">
                                                <?php
                                                echo woocommerce_quantity_input(array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'min_value'    => 1,
                                                    'classes'      => [
                                                        'qty-input-field',
                                                        '!w-full',
                                                        '!h-full',
                                                        '!p-0',
                                                        '!border-0',
                                                        '!ring-0',
                                                        '!outline-none',
                                                        '!shadow-none',
                                                        'text-center',
                                                        'text-xs',
                                                        'font-bold',
                                                        'text-text-heading', // REFACTOR
                                                        'bg-transparent'
                                                    ],
                                                ), $_product, false);
                                                ?>
                                            </div>

                                            <!-- REFACTOR: text-text-muted -->
                                            <button type="button" class="qty-btn w-8 h-full flex items-center justify-center text-text-muted hover:text-brand-primary transition-colors text-lg" data-step="1">+</button>
                                        </div>
                                    </div>

                                    <div class="product-remove">
                                        <!-- Utiliza la clase abstraída en el CSS: btn-pill-remove -->
                                        <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
                                            class="btn-pill-remove action-remove-item">
                                            Eliminar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php endif;
                endforeach; ?>
            </div>

            <!-- BOTÓN OCULTO PARA AUTO-ACTUALIZACIÓN -->
            <button type="submit" class="hidden" name="update_cart" value="Actualizar">Actualizar</button>
            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

            <!-- LÓGICA INTERACTIVA DEL STEPPER Y ELIMINACIÓN -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const cartForm = document.getElementById('oftalmed-cart-form');

                    function updateBtnState() {
                        document.querySelectorAll('.cart_item').forEach(item => {
                            const input = item.querySelector('.qty-input-field');
                            const minusBtn = item.querySelector('.qty-btn[data-step="-1"]');
                            if (input && minusBtn) {
                                if (parseInt(input.value) <= 1) {
                                    minusBtn.classList.add('pointer-events-none', 'opacity-20');
                                } else {
                                    minusBtn.classList.remove('pointer-events-none', 'opacity-20');
                                }
                            }
                        });
                    }

                    if (cartForm) {
                        updateBtnState();

                        cartForm.addEventListener('click', function(e) {

                            // ==========================================
                            // 1. LÓGICA DE ELIMINACIÓN HÍBRIDA
                            // ==========================================
                            const removeBtn = e.target.closest('.action-remove-item');
                            if (removeBtn) {
                                e.preventDefault();

                                const currentItems = document.querySelectorAll('.cart_item');

                                if (currentItems.length <= 1) {
                                    window.location.href = removeBtn.href;
                                    return;
                                }

                                const cartItem = removeBtn.closest('.cart_item');
                                cartItem.style.opacity = '0.4';
                                cartItem.style.pointerEvents = 'none';

                                const input = cartItem.querySelector('.qty-input-field');
                                if (input) {
                                    input.removeAttribute('min');
                                    cartForm.noValidate = true;

                                    input.value = 0;
                                    input.dispatchEvent(new Event('change', {
                                        bubbles: true
                                    }));

                                    setTimeout(() => {
                                        const updateBtn = document.querySelector('[name="update_cart"]');
                                        if (updateBtn) {
                                            updateBtn.disabled = false;
                                            updateBtn.click();
                                        }
                                    }, 100);
                                }
                                return;
                            }

                            // ==========================================
                            // 2. LÓGICA DE STEPPER (+ y -)
                            // ==========================================
                            const btn = e.target.closest('.qty-btn');
                            if (btn) {
                                e.preventDefault();
                                const input = btn.parentElement.querySelector('.qty-input-field');
                                const step = parseInt(btn.dataset.step);
                                let currentValue = parseInt(input.value) || 1;
                                let newValue = currentValue + step;

                                if (newValue >= 1) {
                                    input.value = newValue;
                                    input.dispatchEvent(new Event('change', {
                                        bubbles: true
                                    }));

                                    setTimeout(() => {
                                        const updateBtn = document.querySelector('[name="update_cart"]');
                                        if (updateBtn) {
                                            updateBtn.disabled = false;
                                            updateBtn.click();
                                        }
                                    }, 400);
                                }
                            }
                        });
                    }
                });
            </script>
        </form>

        <!-- FASE 3: BENTO BOX RESUMEN -->
        <div class="lg:w-5/12 h-fit">
            <?php woocommerce_cart_totals(); ?>
        </div>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>