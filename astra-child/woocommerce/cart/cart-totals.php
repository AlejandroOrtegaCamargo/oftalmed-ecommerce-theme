<?php

/**
 * Cart totals
 * @version 2.3.6
 */
defined('ABSPATH') || exit;
?>

<div class="cart_totals w-full p-8 lg:p-10 bg-surface-default rounded-bento border border-surface-line shadow-bento overflow-visible lg:overflow-hidden <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?>">

	<?php do_action('woocommerce_before_cart_totals'); ?>

	<h2 class="resumen-title text-xl font-bold mb-8 text-text-heading tracking-tight block">Resumen del pedido</h2>

	<table cellspacing="0" class="shop_table shop_table_responsive w-full border-none p-0 m-0 bg-transparent">

		<tr class="cart-subtotal flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
			<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
			<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?> flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
				<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php wc_cart_totals_coupon_label($coupon); ?></th>
				<td class="text-base font-bold text-brand-primary p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr(wc_cart_totals_coupon_label($coupon, false)); ?>"><?php wc_cart_totals_coupon_html($coupon); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
			<?php do_action('woocommerce_cart_totals_before_shipping'); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action('woocommerce_cart_totals_after_shipping'); ?>
		<?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>
			<tr class="shipping flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
				<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php esc_html_e('Shipping', 'woocommerce'); ?></th>
				<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php esc_attr_e('Shipping', 'woocommerce'); ?>"><?php woocommerce_shipping_calculator(); ?></td>
			</tr>
		<?php endif; ?>

		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<tr class="fee flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
				<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php echo esc_html($fee->name); ?></th>
				<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr($fee->name); ?>"><?php wc_cart_totals_fee_html($fee); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php
		if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax()) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';
			if (WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()) {
				$estimated_text = sprintf(' <small>' . esc_html__('(estimated for %s)', 'woocommerce') . '</small>', WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]]);
			}
			if ('itemized' === get_option('woocommerce_tax_total_display')) {
				foreach (WC()->cart->get_tax_totals() as $code => $tax) { ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?> flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
						<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php echo esc_html($tax->label) . $estimated_text; ?></th>
						<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr($tax->label); ?>"><?php echo wp_kses_post($tax->formatted_amount); ?></td>
					</tr>
				<?php }
			} else { ?>
				<tr class="tax-total flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
					<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php echo esc_html(WC()->countries->tax_or_vat()) . $estimated_text; ?></th>
					<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr(WC()->countries->tax_or_vat()); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
		<?php }
		} ?>

		<?php do_action('woocommerce_cart_totals_before_order_total'); ?>

		<tr class="order-total flex flex-row items-center justify-between mt-8 pt-8 pb-8 border-t border-surface-line relative">
			<th class="text-xl font-bold text-text-heading uppercase tracking-wide border-none bg-transparent p-0 text-left"><?php esc_html_e('Total', 'woocommerce'); ?></th>

			<td class="relative flex flex-col items-end text-right border-none bg-transparent p-0" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>">
				<span class="text-3xl lg:text-4xl font-black text-text-heading tracking-tight leading-none block">
					<?php wc_cart_totals_order_total_html(); ?>
				</span>
				<span class="absolute top-full right-0 mt-1 text-[11px] font-bold text-text-muted tracking-widest uppercase whitespace-nowrap">
					+ IVA
				</span>
			</td>
		</tr>

		<?php do_action('woocommerce_cart_totals_after_order_total'); ?>

	</table>

	<div class="wc-proceed-to-checkout mt-8">
		<?php do_action('woocommerce_proceed_to_checkout'); ?>
	</div>

	<div class="bento-actions flex flex-col w-full mt-3">
		<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-continue-shopping w-full">
			Seguir comprando
		</a>
	</div>

	<div class="trust-signals mt-8 pt-8 border-t border-surface-line flex flex-col gap-4">
		<div class="trust-item flex items-center gap-3 text-[13px] font-medium text-text-muted">
			<svg aria-hidden="true" class="w-4 h-4 text-brand-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor">
				<path d="M320 64C324.6 64 329.2 65 333.4 66.9L521.8 146.8C543.8 156.1 560.2 177.8 560.1 204C559.6 303.2 518.8 484.7 346.5 567.2C329.8 575.2 310.4 575.2 293.7 567.2C121.3 484.7 80.6 303.2 80.1 204C80 177.8 96.4 156.1 118.4 146.8L306.7 66.9C310.9 65 315.4 64 320 64zM320 130.8L320 508.9C458 442.1 495.1 294.1 496 205.5L320 130.9L320 130.9z" />
			</svg>
			<span>Pago 100% seguro con cifrado SSL</span>
		</div>
		<div class="trust-item flex items-center gap-3 text-[13px] font-medium text-text-muted">
			<svg aria-hidden="true" class="w-4 h-4 text-brand-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor">
				<path d="M192 112L304 112L304 200C304 239.8 336.2 272 376 272L464 272L464 512C464 520.8 456.8 528 448 528L192 528C183.2 528 176 520.8 176 512L176 128C176 119.2 183.2 112 192 112zM352 131.9L444.1 224L376 224C362.7 224 352 213.3 352 200L352 131.9zM192 64C156.7 64 128 92.7 128 128L128 512C128 547.3 156.7 576 192 576L448 576C483.3 576 512 547.3 512 512L512 250.5C512 233.5 505.3 217.2 493.3 205.2L370.7 82.7C358.7 70.7 342.5 64 325.5 64L192 64zM248 320C234.7 320 224 330.7 224 344C224 357.3 234.7 368 248 368L392 368C405.3 368 416 357.3 416 344C416 330.7 405.3 320 392 320L248 320zM248 416C234.7 416 224 426.7 224 440C224 453.3 234.7 464 248 464L392 464C405.3 464 416 453.3 416 440C416 426.7 405.3 416 392 416L248 416z" />
			</svg>
			<span>Factura fiscal en 24hrs. hábiles</span>
		</div>
		<div class="trust-item flex items-center gap-3 text-[13px] font-medium text-text-muted">
			<svg aria-hidden="true" class="w-4 h-4 text-brand-primary flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor">
				<path d="M320 128C241 128 175.3 185.3 162.3 260.7C171.6 257.7 181.6 256 192 256L208 256C234.5 256 256 277.5 256 304L256 400C256 426.5 234.5 448 208 448L192 448C139 448 96 405 96 352L96 288C96 164.3 196.3 64 320 64C443.7 64 544 164.3 544 288L544 456.1C544 522.4 490.2 576.1 423.9 576.1L336 576L304 576C277.5 576 256 554.5 256 528C256 501.5 277.5 480 304 480L336 480C362.5 480 384 501.5 384 528L384 528L424 528C463.8 528 496 495.8 496 456L496 435.1C481.9 443.3 465.5 447.9 448 447.9L432 447.9C405.5 447.9 384 426.4 384 399.9L384 303.9C384 277.4 405.5 255.9 432 255.9L448 255.9C458.4 255.9 468.3 257.5 477.7 260.6C464.7 185.3 399.1 127.9 320 127.9z" />
			</svg>
			<span>
				Soporte especializado:
				<a href="tel:+525555753271" class="font-medium text-text-heading !underline decoration-1 underline-offset-2 hover:text-brand-primary transition-colors">
					55 5575 3271
				</a>
			</span>
		</div>
	</div>

	<?php do_action('woocommerce_after_cart_totals'); ?>

</div>