<?php

/**
 * Checkout Form - Oftalmed Redesign
 */

if (! defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// Si el carrito está vacío, no mostrar checkout
if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<div class="woocommerce max-w-6xl mx-auto pt-0 pb-8 lg:pt-0 lg:pb-12 px-4">

    <div class="woocommerce-notices-wrapper mb-8">
        <?php wc_print_notices(); ?>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 mb-12 pb-6 border-b border-surface-line">
        <h2 class="text-4xl font-bold text-brand-primary tracking-tight m-0">Finalizar compra</h2>

        <nav class="flex w-full max-w-md items-center pt-2 pb-8 mt-4 md:mt-0">
            <div class="relative flex flex-col items-center justify-center cursor-pointer" onclick="window.location='<?php echo esc_url(wc_get_cart_url()); ?>'">
                <div class="w-6 h-6 rounded-full bg-brand-primary flex items-center justify-center z-10">
                    <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="absolute top-8 left-1/2 -translate-x-1/2 text-sm font-medium text-brand-primary whitespace-nowrap">Mi carrito</span>
            </div>
            <div class="flex-1 h-[2px] bg-brand-primary"></div>
            <div class="relative flex flex-col items-center justify-center">
                <div class="w-6 h-6 rounded-full bg-brand-light flex items-center justify-center z-10">
                    <div class="w-2.5 h-2.5 bg-brand-primary rounded-full"></div>
                </div>
                <span class="absolute top-8 left-1/2 -translate-x-1/2 text-sm font-bold text-brand-primary whitespace-nowrap">Comprobar</span>
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

    <div class="w-full mb-8 custom-checkout-coupon">
        <?php woocommerce_checkout_coupon_form(); ?>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <div class="w-full lg:col-span-7 flex flex-col gap-6" id="customer_details">
            <div class="bento-box p-6 lg:p-10">
                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                <?php do_action('woocommerce_checkout_billing'); ?>
                <?php do_action('woocommerce_checkout_shipping'); ?>

                <?php do_action('woocommerce_checkout_after_customer_details'); ?>
            </div>
        </div>

        <div class="w-full lg:col-span-5">
            <div class="bento-box p-6 lg:p-10">
                <h3 id="order_review_heading" class="resumen-title"><?php esc_html_e('Tu pedido', 'woocommerce'); ?></h3>

                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>
        </div>

    </form>

    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
</div>