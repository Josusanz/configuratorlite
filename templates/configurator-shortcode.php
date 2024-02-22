<?php
/**
 * Configurator shortcode template.
 *
 * @package  wp-configurator-pro/templates/
 * @since  2.0
 * @version  3.0
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( ! is_singular( 'amz_configurator' ) && ! is_singular( 'product' ) ) {
	return;
}

if ( is_singular( 'amz_configurator' ) ) {
	$config_id = get_the_ID();
} else {
	$product_id = get_the_ID();
	$config_id  = WPC_Utils::get_meta_value( $product_id, '_wpc_config_id', 0 );
}

echo do_shortcode( '[wpc_config id="' . esc_attr( $config_id ) . '"]' );
