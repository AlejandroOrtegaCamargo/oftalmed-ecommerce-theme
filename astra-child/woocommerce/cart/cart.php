<?php

/**
 * Cart Page - Astra Child Redesign para Oftalmed
 * @package AstraChild
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="woocommerce max-w-6xl mx-auto py-8 lg:py-12 px-4">

    <div class="woocommerce-notices-wrapper mb-8">
        <?php wc_print_notices(); ?>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 mb-12 pb-6 border-b border-surface-line">

        <h2 class="text-4xl font-bold text-brand-primary tracking-tight m-0">
            Mi carrito
        </h2>

        <nav class="flex w-full max-w-md items-center pt-2 pb-8 mt-4 md:mt-0" aria-label="Progreso del pedido">
            <div class="relative flex flex-col items-center justify-center">
                <div class="w-6 h-6 rounded-full bg-brand-light flex items-center justify-center z-10">
                    <div class="w-2.5 h-2.5 bg-brand-primary rounded-full"></div>
                </div>
                <span class="absolute top-8 left-1/2 -translate-x-1/2 text-sm font-bold text-brand-primary whitespace-nowrap">Mi carrito</span>
            </div>
            <div class="flex-1 h-[2px] bg-surface-line flex">
                <div class="w-1/3 h-full bg-brand-primary"></div>
            </div>
            <div class="relative flex flex-col items-center justify-center">
                <div class="w-6 h-6 flex items-center justify-center z-10">
                    <div class="w-3 h-3 bg-surface-line rounded-full"></div>
                </div>
                <span class="absolute top-8 left-1/2 -translate-x-1/2 text-sm font-medium text-text-muted whitespace-nowrap">Comprobar</span>
            </div>
            <div class="flex-1 h-[2px] bg-surface-line"></div>
            <div class="relative flex flex-col items-center justify-center">
                <div class="w-6 h-6 flex items-center justify-center z-10">
                    <div class="w-3 h-3 bg-surface-line rounded-full"></div>
                </div>
                <span class="absolute top-8 left-1/2 -translate-x-1/2 text-sm font-medium text-text-muted whitespace-nowrap">Pagar</span>
            </div>
        </nav>
    </div>

    <div class="flex flex-col lg:flex-row gap-12">
        <div class="lg:w-7/12">
            <form id="oftalmed-cart-form" class="woocommerce-cart-form h-fit bg-transparent lg:bg-surface-default lg:rounded-bento lg:border lg:border-surface-line lg:shadow-bento overflow-visible lg:overflow-hidden" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

                <div class="px-0 lg:px-10 py-6 border-b border-surface-line flex justify-between items-center bg-transparent lg:bg-surface-default">
                    <span class="text-[13px] font-bold text-text-muted tracking-normal">Productos en tu pedido</span>
                    <span class="text-[13px] font-bold text-text-muted tracking-normal">
                        <?php echo sprintf(_n('%d unidad', '%d unidades', WC()->cart->get_cart_contents_count(), 'woocommerce'), WC()->cart->get_cart_contents_count()); ?>
                    </span>
                </div>

                <div class="px-0 lg:px-10">
                    <?php
                    $cart_items = WC()->cart->get_cart();
                    $last_item_key = array_key_last($cart_items);

                    foreach ($cart_items as $cart_item_key => $cart_item) :
                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0):
                            $product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
                            $border_class = ($cart_item_key !== $last_item_key) ? 'border-b border-surface-line' : '';
                            $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                            $product_subtotal = apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                    ?>
                            <div class="cart_item flex flex-row py-8 lg:py-12 gap-4 lg:gap-10 items-start <?php echo $border_class; ?>">
                                <div class="h-20 w-20 lg:h-32 lg:w-32 flex-shrink-0 overflow-hidden bg-transparent">
                                    <?php
                                    $thumbnail = $_product->get_image('woocommerce_thumbnail', array('class' => 'object-contain w-full h-full mix-blend-multiply bg-transparent'));
                                    echo apply_filters('woocommerce_cart_item_thumbnail', $thumbnail, $cart_item, $cart_item_key);
                                    ?>
                                </div>

                                <div class="flex flex-1 flex-col justify-start">
                                    <div class="flex justify-between items-start gap-2 w-full">
                                        <div class="w-[60%] lg:flex-1 pr-2 lg:pr-4">
                                            <h3 class="text-sm lg:text-base font-bold text-text-heading leading-snug tracking-tight">
                                                <a href="<?php echo esc_url($product_permalink); ?>" class="hover:text-brand-primary transition-colors">
                                                    <?php echo $_product->get_name(); ?>
                                                </a>
                                            </h3>
                                        </div>

                                        <div class="text-right flex-shrink-0 flex flex-col justify-start items-end">
                                            <p class="text-base lg:text-lg font-black text-text-heading tracking-tighter !mb-0 line-height-none">
                                                <?php echo $product_subtotal; ?>
                                            </p>
                                            <?php if ($cart_item['quantity'] > 1) : ?>
                                                <span class="text-[11px] lg:text-xs font-medium text-text-muted mt-1 block tracking-tight">
                                                    c/u: <?php echo $product_price; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-5 lg:mt-8 w-full gap-4 sm:gap-0">
                                        <div class="flex items-center gap-4">
                                            <span class="text-[11px] lg:text-[13px] text-text-body tracking-normal">Cantidad</span>
                                            <div class="flex items-center border border-surface-line rounded-input h-[34px] bg-surface-default overflow-hidden w-[90px]">
                                                <button type="button" class="qty-btn w-8 h-full flex items-center justify-center text-text-muted hover:text-brand-primary transition-colors text-lg" data-step="-1">&minus;</button>
                                                <div class="flex-1 custom-qty-styles h-full flex items-center justify-center">
                                                    <?php
                                                    echo woocommerce_quantity_input(array(
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'min_value'    => 1,
                                                        'classes'      => ['qty-input-field', '!w-full', '!h-full', '!p-0', '!border-0', '!ring-0', '!outline-none', '!shadow-none', 'text-center', 'text-xs', 'font-bold', 'text-text-heading', 'bg-transparent'],
                                                    ), $_product, false);
                                                    ?>
                                                </div>
                                                <button type="button" class="qty-btn w-8 h-full flex items-center justify-center text-text-muted hover:text-brand-primary transition-colors text-lg" data-step="1">+</button>
                                            </div>
                                        </div>

                                        <div class="product-remove">
                                            <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="btn-pill-remove action-remove-item">
                                                Eliminar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endif;
                    endforeach; ?>
                </div>

                <button type="submit" class="hidden" name="update_cart" value="Actualizar">Actualizar</button>
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const cartForm = document.getElementById('oftalmed-cart-form');

                        function updateBtnState() {
                            document.querySelectorAll('.cart_item').forEach(item => {
                                const input = item.querySelector('.qty-input-field');
                                const minusBtn = item.querySelector('.qty-btn[data-step="-1"]');
                                const plusBtn = item.querySelector('.qty-btn[data-step="1"]');
                                if (input) {
                                    const currentVal = parseInt(input.value) || 1;
                                    const maxVal = input.hasAttribute('max') && input.getAttribute('max') !== '' ? parseInt(input.getAttribute('max')) : Infinity;
                                    if (minusBtn) {
                                        if (currentVal <= 1) {
                                            minusBtn.classList.add('pointer-events-none', 'opacity-20');
                                        } else {
                                            minusBtn.classList.remove('pointer-events-none', 'opacity-20');
                                        }
                                    }
                                    if (plusBtn) {
                                        if (currentVal >= maxVal) {
                                            plusBtn.classList.add('pointer-events-none', 'opacity-20');
                                        } else {
                                            plusBtn.classList.remove('pointer-events-none', 'opacity-20');
                                        }
                                    }
                                }
                            });
                        }
                        if (cartForm) {
                            updateBtnState();
                            cartForm.addEventListener('click', function(e) {
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
                                const btn = e.target.closest('.qty-btn');
                                if (btn) {
                                    e.preventDefault();
                                    const input = btn.parentElement.querySelector('.qty-input-field');
                                    const step = parseInt(btn.dataset.step);
                                    let currentValue = parseInt(input.value) || 1;
                                    let newValue = currentValue + step;
                                    const maxVal = input.hasAttribute('max') && input.getAttribute('max') !== '' ? parseInt(input.getAttribute('max')) : Infinity;
                                    if (newValue >= 1 && newValue <= maxVal) {
                                        input.value = newValue;
                                        updateBtnState();
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

            <div class="flex justify-end mt-8 mb-4 px-4 lg:px-0">
                <button type="button" id="btn-fake-cotizacion"
                    class="group flex items-center gap-3 px-6 py-3 bg-surface-muted hover:bg-white border-0 rounded-btn transition-all duration-300 cursor-pointer outline-none ring-0">
                    <span class="text-[13px] font-bold text-text-heading leading-none group-hover:underline decoration-1 underline-offset-2">
                        Descargar Cotización (PDF)
                    </span>
                    <div class="p-1.5 bg-brand-light rounded-full group-hover:bg-brand-primary transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-brand-primary group-hover:text-white transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                </button>
            </div>

            <script>
                (function() {
                    const btn = document.getElementById('btn-fake-cotizacion');
                    if (btn) {
                        btn.onclick = function(e) {
                            e.preventDefault();
                            console.log('%c [OFTALMED VALIDATION] Click en botón Cotización PDF ', 'background: #145BC4; color: #fff; font-weight: bold; padding: 4px;');
                            alert('¡Gracias por tu interés! Estamos habilitando el generador de Cotizaciones Formales con Folio para compras institucionales. Estará disponible muy pronto.');
                            btn.blur();
                        };
                    }
                })();
            </script>
        </div>

        <div class="lg:w-5/12 h-fit">
            <?php woocommerce_cart_totals(); ?>
        </div>
    </div>
    <div class="w-full mt-24 border-t border-surface-ash pt-4">
        <?php woocommerce_cross_sell_display(4, 4); ?>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>