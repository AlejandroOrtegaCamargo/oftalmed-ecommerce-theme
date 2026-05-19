<?php

/**
 * Cross-sells in cart
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (! defined('ABSPATH')) {
    exit;
}

if ($cross_sells) : ?>

    <div class="cross-sells mt-8 mb-8 lg:mt-8 w-full">

        <div class="mb-10 lg:mb-12 text-center flex flex-col items-center justify-center">
            <h2 class="text-2xl lg:text-3xl font-bold text-text-heading tracking-tight m-0">
                <?php esc_html_e('Frecuentemente comprados juntos', 'woocommerce'); ?>
            </h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">

            <?php foreach ($cross_sells as $cross_sell) : ?>

                <?php
                $post_object = get_post($cross_sell->get_id());
                setup_postdata($GLOBALS['post'] = &$post_object);

                $_product = wc_get_product($cross_sell->get_id());
                $product_permalink = $_product->is_visible() ? $_product->get_permalink() : '';
                $thumbnail = $_product->get_image('woocommerce_thumbnail', array('class' => 'object-contain w-full h-full mix-blend-multiply transition-transform duration-300 bg-transparent group-hover:scale-105'));
                ?>

                <div class="oftalmed-card group">

                    <div class="w-full aspect-square flex items-center justify-center bg-surface-muted rounded-btn overflow-hidden mb-5 select-none relative">
                        <?php if ($product_permalink) : ?>
                            <a href="<?php echo esc_url($product_permalink); ?>" class="w-full h-full p-4 flex items-center justify-center block">
                                <?php echo $thumbnail; ?>
                            </a>
                        <?php else : ?>
                            <div class="p-4 flex items-center justify-center w-full h-full"><?php echo $thumbnail; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="flex flex-col flex-grow">

                        <div class="mb-3">
                            <h3 class="text-xs lg:text-sm font-bold text-text-heading leading-snug tracking-tight line-clamp-2 h-10 overflow-hidden">
                                <?php if ($product_permalink) : ?>
                                    <a href="<?php echo esc_url($product_permalink); ?>" class="hover:text-brand-primary transition-colors">
                                        <?php echo $_product->get_name(); ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo $_product->get_name(); ?>
                                <?php endif; ?>
                            </h3>
                        </div>

                        <div class="mb-4 h-8 overflow-hidden">
                            <p class="text-[11px] lg:text-xs text-text-muted font-medium line-clamp-2 leading-normal">
                                <?php echo wp_strip_all_tags($_product->get_short_description() ? $_product->get_short_description() : 'Accesorio oficial compatible de alta precisión.'); ?>
                            </p>
                        </div>

                        <div class="mt-auto pt-2">

                            <div class="product-price text-base lg:text-lg font-black text-text-heading tracking-tight mb-4">
                                <?php echo $_product->get_price_html(); ?>
                            </div>

                            <div class="product-action-btn w-full">
                                <?php
                                echo sprintf(
                                    '<a href="%s" data-quantity="1" class="btn-oftalmed-secondary" %s>%s</a>',
                                    esc_url($_product->add_to_cart_url()),
                                    isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                                    esc_html($_product->single_add_to_cart_text())
                                );
                                ?>
                            </div>
                        </div>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>
    </div>

<?php
endif;

wp_reset_postdata();
