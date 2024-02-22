<?php
/**
 * Header mobile menu template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2.5
 * @version  3.4.6
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$single_menu = get_option( 'wpc_menu', 'none' );

if ( ! empty( $single_menu ) && 'none' != $single_menu ) {
	?>
	<nav class="wpc-single-menu js-wpc-single-menu">
		<?php
		wp_nav_menu(
			array(
				'menu'            => $single_menu,
				'container'       => false,
				'container_class' => 'menu clearfix',
				'menu_class'      => 'menu clearfix',
				'theme_location'  => 'main-nav',
				'link_before'     => '',
				'link_after'      => '',
				'before'          => '',
				'after'           => '<span class="wpc-menu-toggle js-wpc-menu-toggle ' . esc_attr( apply_filters( 'wpc_header_submenu_toggle_icon', WPC_Utils::icon( 'angle-down' ) ) ) . '"></span>',
				'depth'           => 2,
			)
		);
		?>
	</nav>
	<?php
}
