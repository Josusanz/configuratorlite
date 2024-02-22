<?php
/**
 * Admin View: Config Mail Request Details.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.2.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$request_id = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_request_id', '' );
$name       = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_name', '' );
$email      = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_email', '' );
$phone      = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_phone', '' );
$message    = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_message', '' );
$status     = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_status', 'processing' );
$post_date  = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_date_created', '' );

wp_nonce_field( 'wpc_user_config_save_data', 'wpc_user_config_meta_nonce' );
?>
<style type="text/css">
	#post-body-content, #titlediv, #wpc-user-config-request-details .postbox-header { display:none }
</style>
<div class="wpc-user-config-request-details-panel-wrap">
	<h2 class="wpc-user-config-request-details-heading"><?php echo sprintf( esc_html__( 'Request #%s Details', 'wp-configurator-pro' ), esc_html( $request_id ) ); ?></h2>
	<div class="wpc-user-config-information-wrap">
		<div class="wpc-user-config-general-info">
			<h3><?php esc_html_e( 'General', 'wp-configurator-pro' ); ?></h3>
			<p>
				<label><?php esc_html_e( 'Date Created', 'wp-configurator-pro' ); ?></label>
				<span>
					<input type="text" class="date-picker" name="_wpc_user_config_request_date" maxlength="10" value="<?php echo esc_attr( date_i18n( 'Y-m-d', strtotime( $post_date ) ) ); ?>" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01]" />@
					&lrm;
					<input type="number" class="hour" placeholder="<?php esc_attr_e( 'h', 'wp-configurator-pro' ); ?>" name="_wpc_user_config_request_date_hour" min="0" max="23" step="1" value="<?php echo esc_attr( date_i18n( 'H', strtotime( $post_date ) ) ); ?>" pattern="([01]?[0-9]{1}|2[0-3]{1})" />:
					<input type="number" class="minute" placeholder="<?php esc_attr_e( 'm', 'wp-configurator-pro' ); ?>" name="_wpc_user_config_request_date_minute" min="0" max="59" step="1" value="<?php echo esc_attr( date_i18n( 'i', strtotime( $post_date ) ) ); ?>" pattern="[0-5]{1}[0-9]{1}" />
					<input type="hidden" name="_wpc_user_config_request_date_second" value="<?php echo esc_attr( date_i18n( 's', strtotime( $post_date ) ) ); ?>" />
				</span>
			</p>
			<p>
				<label><?php esc_html_e( 'Status', 'wp-configurator-pro' ); ?></label>
				<select name="_wpc_user_config_status">
					<?php foreach ( WPC_Utils::get_email_status_lists() as $key => $value ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $status, $key ); ?>><?php echo esc_html( $value ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
		</div>

		<div class="wpc-user-config-customer-details">
			<h3><?php esc_html_e( 'Customer Details', 'wp-configurator-pro' ); ?></h3>

			<p>
				<span><?php echo esc_html( $name ); ?></span>
				<?php
				$billing_fields = get_option( 'wpc_get_quote_billing_fields', 'disable' );

				if ( 'enable' === $billing_fields ) {
					$country = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_country', '' );
					$address = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_address', '' );
					$city    = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_city', '' );
					$state   = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_state', '' );
					$zip     = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_zip', '' );
					?>

					<?php if ( ! empty( $address ) ) : ?>
						<span><?php echo esc_html( $address ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $city ) && ! empty( $zip ) ) : ?>
						<span><?php echo esc_html( $city ); ?> <?php echo esc_html( $zip ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $state ) && ! empty( $country ) ) : ?>
						<span><?php echo esc_html( $state ); ?>&comma; <?php echo esc_html( $country ); ?></span>
					<?php endif; ?>
					<?php
				}
				?>
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
		</div>

		<div class="wpc-user-config-customer-notes">
			<h3><?php esc_html_e( 'Notes', 'wp-configurator-pro' ); ?></h3>
			<p><?php echo esc_html( $message ); ?></p>
		</div>
	</div>
</div>
