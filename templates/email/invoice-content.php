<?php
/**
 * Invoice content
 *
 * @package  wp-configurator-pro/templates/email/
 * @version  3.2.3
 * @version  3.2.4
 */


defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$billing_fields = get_option( 'wpc_get_quote_billing_fields', 'disable' );

$invoice_content = WPC_Utils::get_meta_value( $id, '_wpc_invoice_raw_content', '' );

if ( $invoice_content ) {
	echo wp_kses_post( $invoice_content );
} else {
	$request_id   = WPC_Utils::get_meta_value( $id, '_wpc_user_config_request_id', '' );
	$requested_at = WPC_Utils::get_meta_value( $id, '_wpc_user_config_date_created', '' );
	$encoded      = WPC_Utils::get_meta_value( $id, '_wpc_user_config_encoded', '' );
	$summary      = WPC_Utils::get_meta_value( $id, '_wpc_user_config_summary', '' );
	$name         = WPC_Utils::get_meta_value( $id, '_wpc_user_config_name', '' );
	$email        = WPC_Utils::get_meta_value( $id, '_wpc_user_config_email', '' );
	$phone        = WPC_Utils::get_meta_value( $id, '_wpc_user_config_phone', '' );
	$message      = WPC_Utils::get_meta_value( $id, '_wpc_user_config_message', '' );
	$country      = WPC_Utils::get_meta_value( $id, '_wpc_user_config_country', '' );
	$address      = WPC_Utils::get_meta_value( $id, '_wpc_user_config_address', '' );
	$city         = WPC_Utils::get_meta_value( $id, '_wpc_user_config_city', '' );
	$state        = WPC_Utils::get_meta_value( $id, '_wpc_user_config_state', '' );
	$zip          = WPC_Utils::get_meta_value( $id, '_wpc_user_config_zip', '' );
	$config_id    = WPC_Utils::get_meta_value( $id, '_wpc_user_config_id', '' );
	$product_id   = WPC_Utils::get_meta_value( $id, '_wpc_user_config_product_id', '' );
	?>
	<div id="wpc-mail-request-details">
		<h2><?php esc_html_e( 'Request Details:', 'wp-configurator-pro' ); ?></h2>
		<table width="100%">
			<tbody>
				<tr>
					<th><?php esc_html_e( 'Request ID:', 'wp-configurator-pro' ); ?></th>
					<td><?php echo esc_html( $request_id ); ?></td>
				</tr>
				<tr>
					<th><?php esc_html_e( 'Request at:', 'wp-configurator-pro' ); ?></th>
					<td>
						<?php
						echo sprintf(
							/* translators: 1: Post date, 2: Post time. */
							esc_html__( '%1$s at %2$s' ),
							esc_html( date_i18n( 'Y/m/d', strtotime( $requested_at ) ) ),
							esc_html( date_i18n( 'g:i a', strtotime( $requested_at ) ) ),
						);
						?>
					</td>
				</tr>
				<?php if ( ! isset( $product_id ) || empty( $product_id ) ) : ?>
					<tr>
						<th><?php esc_html_e( 'Configurator', 'wp-configurator-pro' ); ?></th>
						<td><?php echo esc_html( get_the_title( $config_id ) ); ?></td>
					</tr>
				<?php else : ?>
					<tr>
						<th><?php esc_html_e( 'Product', 'wp-configurator-pro' ); ?></th>
						<td><?php echo esc_html( get_the_title( $product_id ) ); ?></td>
					</tr>
				<?php endif; ?>
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

		echo wp_kses( $summary, $allowed_html );

		$permalink = ! empty( $product_id ) ? get_permalink( $product_id ) : get_permalink( $config_id );

		$share_link = add_query_arg(
			array(
				'key' => $encoded,
			),
			$permalink
		);

		echo '<a href="' . esc_url( $share_link ) . '" class="wpc-btn">' . esc_html( get_option( 'wpc_view_configuration_btn_text', esc_html__( 'View Configuration', 'wp-configurator-pro' ) ) ) . '</a>';
		?>
	</div>

	<?php if ( ! empty( $name ) && ! empty( $email ) ) : ?>
		<div id="wpc-mail-other-info">
			<h2><?php esc_html_e( 'Billing Details:', 'wp-configurator-pro' ); ?></h2>
			<table width="100%">
				<tbody>
					<tr>
						<td>
							<p>
								<span><?php echo esc_html( $name ); ?></span>
								<?php if ( ! empty( $address ) ) : ?>
									<span><?php echo esc_html( $address ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $city ) && ! empty( $zip ) ) : ?>
									<span><?php echo esc_html( $city ); ?> <?php echo esc_html( $zip ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $state ) && ! empty( $country ) ) : ?>
									<span><?php echo esc_html( $state ); ?>&comma; <?php echo esc_html( $country ); ?></span>
								<?php endif; ?>
							</p>

							<?php if ( ! empty( $email ) ) : ?>
								<p>
									<span><strong><?php esc_html_e( 'Email', 'wp-configurator-pro' ); ?></strong></span>
									<span><a href="mailto:<?php echo esc_attr( sanitize_email( $email ) ); ?>"><?php echo esc_html( sanitize_email( $email ) ); ?></a></span>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( $phone ) ) : ?>
								<p>
									<span><strong><?php esc_html_e( 'Phone', 'wp-configurator-pro' ); ?></strong></span>
									<span><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></span>
								</p>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	endif;

	/**
	 * Hook: After billing details.
	 *
	 * * @since 3.2.3
	 *
	 * @param integer $id Post ID.
	 */
	do_action( 'wpc_invoice_after_billing_details', $id );
}


