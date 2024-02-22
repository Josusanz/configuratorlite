<?php
/**
 * Flyin logo template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2.5
 * @version  3.4.11
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$flyin_logo = get_option( 'wpc_flyin_logo', '' );
$flyin_logo = str_replace( '\\', '', $flyin_logo );
$flyin_logo = ! empty( $flyin_logo ) ? json_decode( $flyin_logo ) : '';

if ( empty( $flyin_logo ) ) {
	echo '<a href="' . esc_url( get_home_url() ) . '" class="logo-white"><img src="' . WPC_ASSETS_URL . '/frontend/img/white-logo.png" alt=""></a>';
} else {
	$flyin_logo_url = ( null != $flyin_logo[0]->itemId ) ? wp_get_attachment_image_src( $flyin_logo[0]->itemId, 'full' ) : '';
	if ( ! empty( $flyin_logo_url[0] ) ) {
		echo '<a href="' . esc_url( get_home_url() ) . '" class="logo-white"><img src="' . esc_url( $flyin_logo_url[0] ) . '" alt=""></a>';
	}
}
