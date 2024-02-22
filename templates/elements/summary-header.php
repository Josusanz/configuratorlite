<?php
/**
 * Cart Form Summary Header template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.4
 * @version  3.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

?>
<div class="wpc-config-title-wrap">
	<div class="wpc-config-title-inner">
		<p class="wpc-config-title"><?php echo esc_html( $wpc->title ); ?></p>

		<?php
		/**
		 * Hook: After summary header title.
		 *
		 * @hooked wpc_cart_summary_cart_btn_html - 10
		 * 
		 * * @since 3.4
		 *
		 * @param WPCSE $wpc WPCSE Class.
		 */
		do_action( 'wpc_after_summary_header_title', $wpc );
		?>
	</div>
</div>
