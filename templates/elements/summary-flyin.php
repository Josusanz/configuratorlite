<?php
/**
 * Summary flyin template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.4
 * @version  3.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$classes[] = 'wpc-config-element';
$classes[] = WPC_Utils::str_to_bool( $wpc->summary_popup ) ? 'wpc-has-summary' : '';
$classes[] = 'wpc-flyin-wrap wpc-flyin-right wpc-flyin-small';
?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-flyin-id="summary" data-config-id="<?php echo esc_attr( $wpc->id ); ?>">
	<div class="wpc-flyin-inner wpc-<?php echo esc_attr( $wpc->form . '-summary' ); ?>-popup">

		<a href="#" class="wpc-close-btn" data-close-flyin><span class="<?php echo esc_attr( WPC_Utils::icon( 'close' ) ); ?>"></span></a>

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

	</div> <!-- .wpc-popup -->	
</div> <!-- .wpc-popup-wrap -->

