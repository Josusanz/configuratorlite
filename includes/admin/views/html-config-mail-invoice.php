<?php
/**
 * Admin View: Config Mail Invoice.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @since  3.2.2
 * @version  3.4.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$request_id = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_request_id', '' );
$config_id  = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_id', '' );

WPC_Utils::get_template(
	'email/email-header.php',
	array(
		/* Translators: %s: Request ID */
		'email_heading' => sprintf( esc_html__( 'Invoice #%s', 'wp-configurator-pro' ), esc_html( $request_id ) ),
		'config_id'     => $config_id,
	)
);
?>
<div id="wpc-config-mail-invoice" contenteditable="false">
	<?php
	WPC_Utils::get_template(
		'email/invoice-content.php',
		array(
			'id' => $post->ID,
		)
	);
	?>
</div>

<?php
WPC_Utils::get_template( 'email/email-footer.php' );
?>
<div class="wpc-config-mail-invoice-footer">
	<button type="submit" id="wpc-config-mail-save-invoice" data-type="edit" class="button-primary" data-id="<?php echo esc_attr( $post->ID ); ?>"><?php esc_html_e( 'Edit Invoice', 'wp-configurator-pro' ); ?></button>
</div>
