<?php
/**
 * Quote Form Summary template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.1
 * @version  3.2.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$popup_wrap_classes[] = 'wpc-popup-wrap';
$popup_wrap_classes[] = 'wpc-config-element';
$popup_wrap_classes[] = WPC_Utils::str_to_bool( $wpc->summary_popup ) ? 'wpc-has-summary' : '';
?>

<div class="<?php echo esc_attr( implode( ' ', $popup_wrap_classes ) ); ?>" data-popup data-config-id="<?php echo esc_attr( $wpc->id ); ?>">
	<div class="wpc-popup wpc-quote-form-summary-popup" data-popup-id="<?php echo esc_attr( $wpc->form . '-summary' ); ?>">

		<div class="overlay"></div>

		<div class="wpc-popup-inner">

			<a href="#" class="wpc-close-btn" data-close-popup><span class="<?php echo esc_attr( WPC_Utils::icon( 'close' ) ); ?>"></span></a>

			<?php
			/**
			 * Hook: After summary header.
			 *
			 * @hooked wpc_summary_header_html - 10
			 * @hooked wpc_summary_content_html - 20
			 *
			 * * @since 3.4
			 *
			 * @param WPCSE $wpc WPCSE Class.
			 */
			do_action( 'wpc_summary_content', $wpc );
			?>

		</div> <!-- .wpc-popup-inner -->

	</div> <!-- .wpc-popup -->	
</div> <!-- .wpc-popup-wrap -->

