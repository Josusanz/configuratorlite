<?php
/**
 * Invoice
 *
 * @package  wp-configurator-pro/templates/email/
 * @since  3.2.2
 * @version  3.4.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$request_id = WPC_Utils::get_meta_value( $id, '_wpc_user_config_request_id', '' );
$config_id  = WPC_Utils::get_meta_value( $id, '_wpc_user_config_id', '' );

WPC_Utils::get_template(
	'email/email-header.php',
	array(
		/* Translators: %s: Request ID */
		'email_heading' => sprintf( esc_html__( 'Invoice #%s', 'wp-configurator-pro' ), esc_html( $request_id ) ),
		'config_id'     => $config_id,
	)
);

WPC_Utils::get_template(
	'email/invoice-content.php',
	array(
		'id' => $id,
	)
);

WPC_Utils::get_template( 'email/email-footer.php' );
