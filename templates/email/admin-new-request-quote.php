<?php
/**
 * Admin new request a quote email
 *
 * @package  wp-configurator-pro/templates/
 * @since  2.5
 * @version  3.4.12
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$billing_fields = get_option( 'wpc_get_quote_billing_fields', 'disable' );

WPC_Utils::get_template(
	'email/email-header.php',
	array(
		'email_heading' => esc_html__( 'Request Received', 'wp-configurator-pro' ),
		'config_id'     => $values['config_id'],
	)
);
?>

<?php /* translators: %s: Customer name */ ?>
<p id="wpc-mail-info"><?php printf( esc_html__( 'You\'ve received the following request from %s.', 'wp-configurator-pro' ), esc_html( $values['name'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

<?php
if ( isset( $values['message'] ) && apply_filters( 'wpc_allow_message_field_on_quote_form', true ) ) {
	?>
	<p id="wpc-user-message"><?php echo esc_html( $values['message'] ); ?></p>
	<?php
}
?>

<div id="wpc-mail-request-details">
<h2><?php esc_html_e( 'Request Details:', 'wp-configurator-pro' ); ?></h2>
<table width="100%">
	<tbody>
		<tr>
			<th><?php esc_html_e( 'Request ID', 'wp-configurator-pro' ); ?></th>
			<td><?php echo esc_html( $values['request_id'] ); ?></td>
		</tr>
		<?php if ( ! isset( $values['product_id'] ) || empty( $values['product_id'] ) ) : ?>
			<tr>
				<th><?php esc_html_e( 'Configurator', 'wp-configurator-pro' ); ?></th>
				<td><?php echo esc_html( get_the_title( $values['config_id'] ) ); ?></td>
			</tr>
		<?php else : ?>
			<tr>
				<th><?php esc_html_e( 'Product', 'wp-configurator-pro' ); ?></th>
				<td><?php echo esc_html( get_the_title( $values['product_id'] ) ); ?></td>
			</tr>
		<?php endif; ?>
		<?php

		/**
		 * Hook: Request details.
		 *
		 * * @since 2.6
		 *
		 * @param array $values Form details.
		 */
		do_action( 'wpc_admin_request_quote_request_details', $values );
		?>
	</tbody>
</table>
</div>

<div id="wpc-mail-configured-options">
<h3><?php esc_html_e( 'User Selections:', 'wp-configurator-pro' ); ?></h3>
<?php
$allowed_html = array(
	'div'  => array(
		'class' => array(),
	),
	'span' => array(
		'class' => array(),
	),
	'ul'   => array(
		'class' => array(),
	),
	'li'   => array(
		'class' => array(),
	),
);

echo wp_kses( $values['summary'], $allowed_html );

/**
 * Hook: After summary.
 *
 * * @since 3.0
 *
 * @param array $values Form details.
 */
do_action( 'wpc_admin_request_quote_after_summary', $values );

if( isset( $values['redirect'] ) ) {
	$permalink = $values['redirect'];
} elseif( ! empty( $values['product_id'] ) ) {	
	$permalink = get_permalink( $values['product_id'] );
} else {
	$permalink = get_permalink( $values['config_id'] );
}


$share_link = add_query_arg(
	array(
		'key' => $values['encoded'],
	),
	$permalink
);

echo '<a href="' . esc_url( $share_link ) . '" class="wpc-btn">' . esc_html( get_option( 'wpc_view_configuration_btn_text', esc_html__( 'View Configuration', 'wp-configurator-pro' ) ) ) . '</a>';

/**
 * Hook: Before customer details.
 *
 * * @since 3.0
 *
 * @param array $values Form details.
 */
do_action( 'wpc_admin_request_quote_before_customer_details', $values );
?>

</div>
<div id="wpc-mail-other-info">
	<h2><?php esc_html_e( 'Customer Details:', 'wp-configurator-pro' ); ?></h2>
	<table width="100%">
		<tbody>
			<tr>
				<td>
					<p>
						<span><?php echo esc_html( $values['name'] ); ?></span>
						<?php if ( 'enable' === $billing_fields ) : ?>
							<span><?php echo esc_html( $values['address'] ); ?></span>
							<span><?php echo esc_html( $values['city'] ); ?> <?php echo esc_html( $values['zip'] ); ?></span>
							<span><?php echo esc_html( $values['state'] ); ?>&comma; <?php echo esc_html( $values['country'] ); ?></span>
						<?php endif; ?>
					</p>

					<p>
						<span><strong><?php esc_html_e( 'Email', 'wp-configurator-pro' ); ?></strong></span>
						<span><a href="mailto:<?php echo esc_attr( sanitize_email( $values['email'] ) ); ?>"><?php echo esc_html( sanitize_email( $values['email'] ) ); ?></a></span>
					</p>
					<p>
						<span><strong><?php esc_html_e( 'Phone', 'wp-configurator-pro' ); ?></strong></span>
						<span><a href="tel:<?php echo esc_attr( $values['phone'] ); ?>"><?php echo esc_html( $values['phone'] ); ?></a></span>
					</p>
					<?php
					/**
					 * Hook: Customer details.
					 *
					 * * @since 2.6
					 *
					 * @param array $values Form details.
					 */
					do_action( 'wpc_admin_request_quote_customer_details', $values );
					?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?php

/**
 * Hook: After customer details.
 *
 * * @since 2.6
 *
 * @param array $values Form details.
 */
do_action( 'wpc_admin_request_quote_after_customer_details', $values );

WPC_Utils::get_template( 'email/email-footer.php' );
