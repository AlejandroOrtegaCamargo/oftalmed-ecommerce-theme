<?php

/**
 * Cart totals
 * @version 2.3.6
 */
defined('ABSPATH') || exit;
?>

<!-- Contenedor Principal -->
<div class="cart_totals w-full p-8 lg:p-10 bg-white rounded-3xl border border-gray-100 shadow-[0_20px_40px_rgba(0,0,0,0.1)] overflow-hidden <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?>">

	<?php do_action('woocommerce_before_cart_totals'); ?>

	<h2 class="text-xl font-bold mb-8 text-gray-900 tracking-tight block">Resumen del pedido</h2>

	<!-- Tabla de totales -->
	<table cellspacing="0" class="shop_table shop_table_responsive w-full border-none p-0 m-0 bg-transparent">

		<tr class="cart-subtotal flex items-center justify-between mb-4 pb-4 border-b border-gray-50">
			<th class="text-base font-medium text-gray-500 p-0 text-left border-none bg-transparent"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
			<td class="text-base font-bold text-gray-900 p-0 text-right border-none bg-transparent" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?> flex items-center justify-between mb-4 pb-4 border-b border-gray-50">
				<th class="text-base font-medium text-gray-500 p-0 text-left border-none bg-transparent"><?php wc_cart_totals_coupon_label($coupon); ?></th>
				<td class="text-base font-bold text-[#019DFB] p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr(wc_cart_totals_coupon_label($coupon, false)); ?>"><?php wc_cart_totals_coupon_html($coupon); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
			<?php do_action('woocommerce_cart_totals_before_shipping'); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action('woocommerce_cart_totals_after_shipping'); ?>
		<?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>
			<tr class="shipping flex items-center justify-between mb-4 pb-4 border-b border-gray-50">
				<th class="text-base font-medium text-gray-500 p-0 text-left border-none bg-transparent"><?php esc_html_e('Shipping', 'woocommerce'); ?></th>
				<td class="text-base font-bold text-gray-900 p-0 text-right border-none bg-transparent" data-title="<?php esc_attr_e('Shipping', 'woocommerce'); ?>"><?php woocommerce_shipping_calculator(); ?></td>
			</tr>
		<?php endif; ?>

		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<tr class="fee flex items-center justify-between mb-4 pb-4 border-b border-gray-50">
				<th class="text-base font-medium text-gray-500 p-0 text-left border-none bg-transparent"><?php echo esc_html($fee->name); ?></th>
				<td class="text-base font-bold text-gray-900 p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr($fee->name); ?>"><?php wc_cart_totals_fee_html($fee); ?></td>
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
					<tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?> flex items-center justify-between mb-4 pb-4 border-b border-gray-50">
						<th class="text-base font-medium text-gray-500 p-0 text-left border-none bg-transparent"><?php echo esc_html($tax->label) . $estimated_text; ?></th>
						<td class="text-base font-bold text-gray-900 p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr($tax->label); ?>"><?php echo wp_kses_post($tax->formatted_amount); ?></td>
					</tr>
				<?php
				}
			} else {
				?>
				<tr class="tax-total flex items-center justify-between mb-4 pb-4 border-b border-gray-50">
					<th class="text-base font-medium text-gray-500 p-0 text-left border-none bg-transparent"><?php echo esc_html(WC()->countries->tax_or_vat()) . $estimated_text; ?></th>
					<td class="text-base font-bold text-gray-900 p-0 text-right border-none bg-transparent" data-title="<?php echo esc_attr(WC()->countries->tax_or_vat()); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
		<?php
			}
		}
		?>

		<?php do_action('woocommerce_cart_totals_before_order_total'); ?>

		<!-- FILA DE TOTAL (Destacada) -->
		<tr class="order-total flex flex-row items-center justify-between mt-8 pt-8 border-t border-gray-100">
			<th class="text-xl font-bold text-gray-900 uppercase tracking-wide border-none bg-transparent p-0 text-left"><?php esc_html_e('Total', 'woocommerce'); ?></th>
			<td class="text-4xl font-black text-gray-900 tracking-tight border-none bg-transparent p-0 text-right" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action('woocommerce_cart_totals_after_order_total'); ?>

	</table>

	<!-- Botón Principal (Con clases directas en PHP si tu tema lo permite, o dejándolo en CSS si el Action lo inyecta oculto) -->
	<div class="wc-proceed-to-checkout mt-8">
		<?php do_action('woocommerce_proceed_to_checkout'); ?>
	</div>

	<!-- Acciones Secundarias -->
	<div class="bento-actions flex flex-col w-full mt-3">
		<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="flex items-center justify-center w-full h-[52px] border border-gray-200 bg-white text-gray-600 text-sm font-bold rounded-xl no-underline transition-all duration-200 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900">
			Seguir comprando
		</a>
	</div>

	<!-- Trust Signals -->
	<div class="trust-signals mt-8 pt-8 border-t border-gray-100 flex flex-col gap-4">
		<div class="trust-item flex items-center gap-3 text-[13px] font-medium text-gray-500">
			<svg aria-hidden="true" class="w-4 h-4 text-[#019DFB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
			</svg>
			<span>Pago 100% seguro con cifrado SSL</span>
		</div>
		<div class="trust-item flex items-center gap-3 text-[13px] font-medium text-gray-500">
			<svg aria-hidden="true" class="w-4 h-4 text-[#019DFB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
			</svg>
			<span>Factura fiscal disponible</span>
		</div>
	</div>

	<?php do_action('woocommerce_after_cart_totals'); ?>

</div>