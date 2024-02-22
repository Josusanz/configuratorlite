<?php
/**
 * Admin View: License Page.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.2
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$license        = get_option( 'wpc_license_key' );
$license_status = get_option( 'wpc_license_status' );

$license_hide = ( $license ) ? substr( $license, 0, -24 ) . str_repeat( '*', 24 ) : '';

$addons_lists = apply_filters( 'wpc_addons_lists', array() );
$addons_lists = array_merge(
	array(
		'wp-configurator-pro' => esc_html__( 'WP Configurator Pro', 'wp-configurator-pro' ),
	),
	$addons_lists
);

$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'wp-configurator-pro';
?>

<div class="wpc-settings-wrap wpc-license-wrap page-tab-<?php echo esc_attr( $tab ); ?>">
	<h2 class="title"><?php esc_html_e( 'License Key', 'wp-configurator-pro' ); ?></h2>
	<p class="sub-title"><?php wp_kses( _e( 'Your key unlocks access to automatic updates, and support. You can find your key on the My Account page on the <a href="https://my.wpconfigurator.com/account/">WP Configurator Pro</a> site.', 'wp-configurator-pro' ), array( 'a' => array( 'href' => array() ) ) ); ?></p>

	<div class="wrap">
		<form method="post" action="options.php">
			<div class="wpc-options-wrap">

				<div class="fields-group active">
					<?php settings_fields( 'wpc_license' ); ?>
					<h3 class="title"><?php esc_html_e( 'WP Configurator Pro', 'wp-configurator-pro' ); ?><span class="wpc-angle-down"></span></h3>
					<div class="fields-group-inner">
						<div class="wpc-options" id="wpc_thumb_size">
							<div class="wpc-pull-left">
								<label for="wpc_thumb_size" class="wpc-sub-title"><?php esc_html_e( 'License Key', 'wp-configurator-pro' ); ?></label>
								<p class="description"><?php esc_html_e( 'Enter your license key', 'wp-configurator-pro' ); ?></p>
							</div>
							<div class="wpc-pull-right">
								<input id="wpc_license_key" name="wpc_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license_hide ); ?>" />
							</div>
						</div>

						<div class="wpc-options" id="wpc_thumb_size">
							<div class="wpc-pull-left">
								<?php if ( false !== $license_status && 'valid' === $license_status ) { ?>
									<span class="license-active-status"><?php esc_html_e( 'Active', 'wp-configurator-pro' ); ?></span>
									<?php wp_nonce_field( 'wpc_nonce', 'wpc_nonce' ); ?>
									<input type="submit" class="button-primary button-red" name="wpc_license_deactivate" value="<?php esc_html_e( 'Deactivate License', 'wp-configurator-pro' ); ?>" />
									<?php
								} else {
									wp_nonce_field( 'wpc_nonce', 'wpc_nonce' );
									?>
									<input type="submit" class="button-secondary" name="wpc_license_activate" value="<?php esc_html_e( 'Activate License', 'wp-configurator-pro' ); ?>" class="button-primary"/>
								<?php } ?>
							</div>
						</div>

						<div class="wpc-options" id="wpc_thumb_size">
							<div class="wpc-pull-left">
								<h3 class="sub-title"><?php esc_html_e( 'Buy License', 'wp-configurator-pro' ); ?></h3>
								<?php if ( false !== $license_status && 'valid' === $license_status ) : ?>
									<p><?php esc_html_e( 'If you need another license, Please purchase the license through below this link.', 'wp-configurator-pro' ); ?></p>
								<?php else : ?>
									<p><?php esc_html_e( 'Please purchase the license through below this link.', 'wp-configurator-pro' ); ?></p>
								<?php endif; ?>
								<a href="https://my.wpconfigurator.com/downloads/configurator-plugin/" target="_blank" class="button-primary"><?php esc_html_e( 'Buy Product', 'wp-configurator-pro' ); ?></a>
							</div>
						</div>
					</div>

				</div>

				<?php
					do_action( 'wpc_addons_license' );
				?>

			</div>
		</form>
	</div>
</div>
