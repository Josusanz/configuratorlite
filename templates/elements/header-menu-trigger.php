<?php
/**
 * Header mobile menu trigger template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2.5
 * @version  3.4.6
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$single_menu = get_option( 'wpc_menu', 'none' );

if ( ! empty( $single_menu ) && 'none' !== $single_menu ) {
	?>
	<a href="#" class="wpc-menu-trigger js-wpc-menu-trigger">
		<span class="icon wpc-mobile-menu <?php echo esc_attr( apply_filters( 'wpc_header_menu_trigger_icon', WPC_Utils::icon( 'menu' ) ) ); ?>"></span>
	</a>
	<?php
}
