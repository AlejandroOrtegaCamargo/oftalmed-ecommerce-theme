<?php

/**
 * Cart totals
 * @version 2.3.6
 */
defined('ABSPATH') || exit;
?>

<!-- Contenedor Principal -->
<!-- REFACTOR: bg-surface-default, rounded-bento, border-surface-line, shadow-bento -->
<div class="cart_totals w-full p-8 lg:p-10 bg-surface-default rounded-bento border border-surface-line shadow-bento overflow-hidden <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?>">

	<?php do_action('woocommerce_before_cart_totals'); ?>

	<!-- REFACTOR: text-text-heading -->
	<h2 class="resumen-title text-xl font-bold mb-8 text-text-heading tracking-tight block">Resumen del pedido</h2>

	<!-- Tabla de totales -->
	<table cellspacing="0" class="shop_table shop_table_responsive w-full border-none p-0 m-0 bg-transparent">

		<!-- REFACTOR: border-surface-line -->
		<tr class="cart-subtotal flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
			<!-- REFACTOR: text-text-muted -->
			<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
			<!-- REFACTOR: text-text-heading -->
			<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<!-- REFACTOR: border-surface-line -->
			<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?> flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
				<!-- REFACTOR: text-text-muted -->
				<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php wc_cart_totals_coupon_label($coupon); ?></th>
				<!-- REFACTOR: text-brand-primary -->
				<td class="text-base font-bold text-brand-primary p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr(wc_cart_totals_coupon_label($coupon, false)); ?>"><?php wc_cart_totals_coupon_html($coupon); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
			<?php do_action('woocommerce_cart_totals_before_shipping'); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action('woocommerce_cart_totals_after_shipping'); ?>
		<?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>
			<!-- REFACTOR: border-surface-line -->
			<tr class="shipping flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
				<!-- REFACTOR: text-text-muted -->
				<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php esc_html_e('Shipping', 'woocommerce'); ?></th>
				<!-- REFACTOR: text-text-heading -->
				<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php esc_attr_e('Shipping', 'woocommerce'); ?>"><?php woocommerce_shipping_calculator(); ?></td>
			</tr>
		<?php endif; ?>

		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<!-- REFACTOR: border-surface-line -->
			<tr class="fee flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
				<!-- REFACTOR: text-text-muted -->
				<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php echo esc_html($fee->name); ?></th>
				<!-- REFACTOR: text-text-heading -->
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
				foreach (WC()->cart->get_tax_totals() as $code => $tax) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		?>
					<!-- REFACTOR: border-surface-line -->
					<tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?> flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
						<!-- REFACTOR: text-text-muted -->
						<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php echo esc_html($tax->label) . $estimated_text; ?></th>
						<!-- REFACTOR: text-text-heading -->
						<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr($tax->label); ?>"><?php echo wp_kses_post($tax->formatted_amount); ?></td>
					</tr>
				<?php
				}
			} else {
				?>
				<!-- REFACTOR: border-surface-line -->
				<tr class="tax-total flex items-center justify-between mb-4 pb-4 border-b border-surface-line">
					<!-- REFACTOR: text-text-muted -->
					<th class="text-base font-medium text-text-muted p-0 text-left border-none bg-transparent"><?php echo esc_html(WC()->countries->tax_or_vat()) . $estimated_text; ?></th>
					<!-- REFACTOR: text-text-heading -->
					<td class="text-base font-bold text-text-heading p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr(WC()->countries->tax_or_vat()); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
		<?php
			}
		}
		?>

		<?php do_action('woocommerce_cart_totals_before_order_total'); ?>

		<!-- FILA DE TOTAL (Destacada) -->
		<!-- REFACTOR: border-surface-line -->
		<tr class="order-total flex flex-row items-center justify-between mt-8 pt-8 border-t border-surface-line">
			<!-- REFACTOR: text-text-heading -->
			<th class="text-xl font-bold text-text-heading uppercase tracking-wide border-none bg-transparent p-0 text-left"><?php esc_html_e('Total', 'woocommerce'); ?></th>
			<!-- REFACTOR: text-text-heading -->
			<td class="text-4xl font-black text-text-heading tracking-tight border-none bg-transparent p-0 text-right" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action('woocommerce_cart_totals_after_order_total'); ?>

	</table>

	<div class="wc-proceed-to-checkout mt-8">
		<?php do_action('woocommerce_proceed_to_checkout'); ?>
	</div>

	<!-- Acciones Secundarias -->
	<div class="bento-actions flex flex-col w-full mt-3">
		<!-- REFACTOR: border-surface-line, bg-surface-default, text-text-body, rounded-btn, hover:bg-surface-muted, hover:text-text-heading -->
		<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-continue-shopping w-full">
			Seguir comprando
		</a>
	</div>

	<!-- Trust Signals -->
	<!-- REFACTOR: border-surface-line -->
	<div class="trust-signals mt-8 pt-8 border-t border-surface-line flex flex-col gap-4">
		<!-- REFACTOR: text-text-muted -->
		<div class="trust-item flex items-center gap-3 text-[13px] font-medium text-text-muted">
			<!-- REFACTOR: text-brand-primary -->
			<svg aria-hidden="true" class="w-4 h-4 text-brand-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
			</svg>
			<span>Pago 100% seguro con cifrado SSL</span>
		</div>
		<!-- REFACTOR: text-text-muted -->
		<div class="trust-item flex items-center gap-3 text-[13px] font-medium text-text-muted">
			<!-- REFACTOR: text-brand-primary -->
			<svg aria-hidden="true" class="w-4 h-4 text-brand-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
			</svg>
			<span>Factura fiscal disponible</span>
		</div>
	</div>

	<?php do_action('woocommerce_after_cart_totals'); ?>

</div>