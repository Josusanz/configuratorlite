<?php
/**
 * Header total price template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2.5
 * @version  3.2.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;
?>
<div class="wpc-price-wrap" data-price-wrap data-config-id="<?php echo esc_attr( $wpc->id ); ?>">
	<p x-data class="wpc-calculation" x-text="<?php echo esc_attr( $wpc->store . '.totalPriceHtml' ); ?>"></p>
</div>
