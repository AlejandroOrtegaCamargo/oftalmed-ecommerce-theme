<?php

/**
 * Cart Page - Astra Child Redesign
 * * @package AstraChild
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="woocommerce max-w-6xl mx-auto py-12 px-4">
    <div class="flex flex-col lg:flex-row gap-8">

        <form class="woocommerce-cart-form lg:w-7/12" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <h1 class="text-3xl font-bold text-gray-900 mb-8 tracking-tight">
                Tu carrito
            </h1>

            <div class="divide-y divide-gray-200 border-t-2 border-gray-200">
                <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                        <div class="cart_item flex py-8 gap-6">

                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-gray-50">
                                <?php echo apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key); ?>
                            </div>

                            <div class="flex flex-1 flex-col justify-between">
                                <div class="flex justify-between items-start gap-4">
                                    <h3 class="text-lg font-bold text-gray-900 leading-snug">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_name',
                                            sprintf(
                                                '<a href="%s" class="text-gray-900 hover:text-blue-600 no-underline transition-colors">%s</a>',
                                                esc_url($product_permalink),
                                                $_product->get_name()
                                            ),
                                            $cart_item,
                                            $cart_item_key
                                        );
                                        ?>
                                    </h3>
                                    <p class="text-lg font-bold text-gray-900 whitespace-nowrap">
                                        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                    </p>
                                </div>

                                <div class="flex items-end justify-between mt-4">
                                    <div class="product-quantity">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_quantity', woocommerce_quantity_input(array(
                                            'input_name'  => "cart[{$cart_item_key}][qty]",
                                            'input_value' => $cart_item['quantity'],
                                            'max_value'   => $_product->get_max_purchase_quantity(),
                                            'min_value'   => '0',
                                            'product_name' => $_product->get_name(),
                                            'classes'     => ['qty-input'],
                                        ), $_product, false), $cart_item_key, $cart_item);
                                        ?>
                                    </div>

                                    <div class="product-remove">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="btn-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">Eliminar</a>',
                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                esc_html__('Remove this item', 'woocommerce'),
                                                esc_attr($product_id),
                                                esc_attr($_product->get_sku())
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    endif;
                endforeach; ?>
            </div>

            <button type="submit" class="hidden" name="update_cart" value="Actualizar">
                <?php esc_html_e('Update cart', 'woocommerce'); ?>
            </button>
            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
        </form>

        <div class="cart-collaterals lg:w-5/12">
            <?php woocommerce_cart_totals(); ?>
        </div>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>