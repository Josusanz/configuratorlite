<?php
/**
 * Admin View: Config Mail Action.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.2.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$properties = $post->get_properties();

$user_config_tags = isset( $properties['user_config_tags'] ) ? $properties['user_config_tags'] : array();

$name    = isset( $user_config_tags['name'] ) ? $user_config_tags['name'] : '';
$email   = isset( $user_config_tags['email'] ) ? $user_config_tags['email'] : '';
$phone   = isset( $user_config_tags['phone'] ) ? $user_config_tags['phone'] : '';
$message = isset( $user_config_tags['message'] ) ? $user_config_tags['message'] : '';
$address = isset( $user_config_tags['address'] ) ? $user_config_tags['address'] : '';
$country = isset( $user_config_tags['country'] ) ? $user_config_tags['country'] : '';
$state   = isset( $user_config_tags['state'] ) ? $user_config_tags['state'] : '';
$city    = isset( $user_config_tags['city'] ) ? $user_config_tags['city'] : '';
$zip     = isset( $user_config_tags['zip'] ) ? $user_config_tags['zip'] : '';
$info    = isset( $user_config_tags['info'] ) ? $user_config_tags['info'] : '';

$collect_mail_tags = $post->collect_mail_tags();
?>
<h2><?php esc_html_e( 'Config Mail List Information', 'wp-configurator-pro' ); ?></h2>
<p><?php esc_html_e( 'Enter the respective field ID to add the details in Config Mail List and Invoices.', 'wp-configurator-pro' ); ?></p>
<p class="wpc-mail-tags">
	<?php
	unset( $collect_mail_tags['summary'] );
	unset( $collect_mail_tags['view-config-btn'] );

	foreach ( $collect_mail_tags as $key => $value ) {
		echo sprintf( '<span>[%s]</span>', esc_html( $value ) );
	}
	?>
</p>

<h3><?php esc_html_e( 'Billing and Invoices', 'wp-configurator-pro' ); ?></h3>
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'Name', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[name]" class="large-text code" size="70" value="<?php echo esc_attr( $name ); ?>">
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'Email', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[email]" class="large-text code" size="70" value="<?php echo esc_attr( $email ); ?>">
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'Phone', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[phone]" class="large-text code" size="70" value="<?php echo esc_attr( $phone ); ?>">
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'Message', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[message]" class="large-text code" size="70" value="<?php echo esc_attr( $message ); ?>">
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'Address', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[address]" class="large-text code" size="70" value="<?php echo esc_attr( $address ); ?>">
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'Country', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[country]" class="large-text code" size="70" value="<?php echo esc_attr( $country ); ?>">
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'State', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[state]" class="large-text code" size="70" value="<?php echo esc_attr( $state ); ?>">
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'City', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[city]" class="large-text code" size="70" value="<?php echo esc_attr( $city ); ?>">
			</td>
		</tr>

		<tr>
			<th scope="row">
				<label><?php esc_html_e( 'Postal Code', 'wp-configurator-pro' ); ?></label>
			</th>
			<td>
				<input type="text" name="wpc-user-config[zip]" class="large-text code" size="70" value="<?php echo esc_attr( $zip ); ?>">
			</td>
		</tr>
	</tbody>
</table>
<h3><?php esc_html_e( 'Additional Information', 'wp-configurator-pro' ); ?></h3>
<p><?php esc_html_e( 'It supports <p> <strong> <span> tags.' ); ?></p>
<table class="form-table">
	<tbody>
		<tr>
			<td>
				<textarea name="wpc-user-config[info]" cols="100" rows="12" class="large-text code" placeholder="<?php esc_attr_e( '<p><strong>Email:<strong> [your-email]<p>', 'wp-configurator-pro' ); ?>"><?php echo esc_html( $info ); ?></textarea>
			</td>
		</tr>
	</tbody>
</table>
