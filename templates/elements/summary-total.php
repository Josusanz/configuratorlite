<?php
/**
 * Summary Total template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @version  3.4.11
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$total_price_text = get_option( 'wpc_total_price_text', esc_html__( 'Total Price', 'wp-configurator-pro' ) );

if ( WPC_Utils::str_to_bool( $wpc->total_price ) ) {
	?>
	<div x-data class="wpc-summary-total-wrap">
		<h4 class="wpc-summary-total">
			<span class="wpc-summary-list-title"><?php echo esc_html( $total_price_text ); ?></span>
			<span class="wpc-sign"> - </span>
			<p class="wpc-summary-list-total-inner">
				<template x-data x-if="<?php echo esc_attr( $wpc->store . '.isSalePriceAvailable()' ); ?>">
					<span class="wpc-summary-list-regular-price" x-text="<?php echo esc_attr( $wpc->store . '.regularPriceHtml' ); ?>"></span>
				</template>
				
				<span class="wpc-summary-list-total-price" x-text="<?php echo esc_attr( $wpc->store . '.totalPriceHtml' ); ?>"></span>
			</p>
		</h4>
	</div>
	<?php
}
