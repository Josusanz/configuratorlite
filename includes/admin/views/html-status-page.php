<?php
/**
 * Admin View: License Page.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.4.10
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$active_tab = isset( $_GET['tab'] ) ? wp_unslash( $_GET['tab'] ) : 'status';
?>

<div class="wpc-settings-wrap wpc-status-wrap page-tab-status">

	<div class="wpc-options-wrap">
		<div class="fields-group active">
			<h3 class="title"><?php esc_html_e( 'WordPress environment', 'wp-configurator-pro' ); ?><span class="wpc-angle-down"></span></h3>
			<div class="fields-group-inner">
				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'WordPress address (URL)', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo esc_html( get_option( 'home' ) ); ?></span>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'Site address (URL)', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo esc_html( get_option( 'siteurl' ) ); ?></span>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'Configurator Version', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo esc_html( WPC_VERSION ); ?></span>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'WordPress version', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<?php
						$latest_version = get_transient( 'wpc_system_status_wp_version_check' );

						if ( false === $latest_version ) {
							$version_check = wp_remote_get( 'https://api.wordpress.org/core/version-check/1.7/' );
							$api_response  = json_decode( wp_remote_retrieve_body( $version_check ), true );

							if ( $api_response && isset( $api_response['offers'], $api_response['offers'][0], $api_response['offers'][0]['version'] ) ) {
								$latest_version = $api_response['offers'][0]['version'];
							} else {
								$latest_version = get_bloginfo( 'version' );
							}
							set_transient( 'wpc_system_status_wp_version_check', $latest_version, DAY_IN_SECONDS );
						}

						if ( version_compare( get_bloginfo( 'version' ), $latest_version, '<' ) ) {
							/* Translators: %1$s: Current version, %2$s: New version */
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - There is a newer version of WordPress available (%2$s)', 'wp-configurator-pro' ), esc_html( get_bloginfo( 'version' ) ), esc_html( $latest_version ) ) . '</mark>';
						} else {
							echo '<mark class="yes">' . esc_html( get_bloginfo( 'version' ) ) . '</mark>';
						}
						?>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'WordPress multisite', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo ( is_multisite() ) ? '<span class="dashicons dashicons-yes"></span>' : '&ndash;'; ?></span>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'WordPress memory limit', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<?php
						// WP memory limit.
						$wp_memory_limit = WPC_Utils::let_to_num( WP_MEMORY_LIMIT );
						if ( function_exists( 'memory_get_usage' ) ) {
							$wp_memory_limit = max( $wp_memory_limit, WPC_Utils::let_to_num( @ini_get( 'memory_limit' ) ) ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
						}

						if ( $wp_memory_limit < 67108864 ) {
							/* Translators: %1$s: Memory limit, %2$s: Docs link. */
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend setting memory to at least 64MB. See: %2$s', 'wp-configurator-pro' ), esc_html( size_format( $wp_memory_limit ) ), '<a href="https://wordpress.org/support/article/editing-wp-config-php/#increasing-memory-allocated-to-php" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'wp-configurator-pro' ) . '</a>' ) . '</mark>';
						} else {
							echo '<mark class="yes">' . esc_html( size_format( $wp_memory_limit ) ) . '</mark>';
						}
						?>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'WordPress debug mode', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<?php if ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ) : ?>
							<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
						<?php else : ?>
							<mark class="no">&ndash;</mark>
						<?php endif; ?>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'WordPress cron', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<?php if ( ! ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) ) : ?>
							<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
						<?php else : ?>
							<mark class="no">&ndash;</mark>
						<?php endif; ?>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'Language', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo esc_html( get_locale() ); ?></span>
					</div>
				</div>

			</div>
		</div>

		<div class="fields-group">
			<h3 class="title"><?php esc_html_e( 'Server environment', 'wp-configurator-pro' ); ?><span class="wpc-angle-down"></span></h3>
			<div class="fields-group-inner">
				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'Server info', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<?php
						$server_info = isset( $_SERVER['SERVER_SOFTWARE'] ) ? WPC_Utils::clean( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';
						?>
						<span><?php echo esc_html( $server_info ); ?></span>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'PHP version', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<?php
						$phpversion = phpversion();
						if ( version_compare( $phpversion, '7.4', '>=' ) ) {
							echo '<mark class="yes">' . esc_html( $phpversion ) . '</mark>';
						} else {
							$update_link = ' <a href="https://docs.woocommerce.com/document/how-to-update-your-php-version/" target="_blank">' . esc_html__( 'How to update your PHP version', 'wp-configurator-pro' ) . '</a>';
							$class       = 'error';

							$notice    = __( 'We recommend using PHP version 7.4 or above for greater performance and security.', 'wp-configurator-pro' ) . $update_link;
								$class = 'recommendation';

							echo '<mark class="no">' . esc_html( $phpversion ) . ' - ' . wp_kses_post( $notice ) . '</mark>';
						}
						?>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'PHP post max size', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo esc_html( size_format( WPC_Utils::let_to_num( ini_get( 'post_max_size' ) ) ) ); ?></span>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'PHP time limit', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo esc_html( (int) ini_get( 'max_execution_time' ) ); ?></span>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'PHP max input vars', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo esc_html( (int) ini_get( 'max_input_vars' ) ); ?></span>
					</div>
				</div>

				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'Max upload size', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<span><?php echo esc_html( size_format( wp_max_upload_size() ) ); ?></span>
					</div>
				</div>
			</div>
		</div>


		<div class="fields-group template-overrides">
			<h3 class="title"><?php esc_html_e( 'Templates', 'wp-configurator-pro' ); ?><span class="wpc-angle-down"></span></h3>
			<div class="fields-group-inner">
				<div class="wpc-options">
					<div class="wpc-pull-left">
						<span><?php esc_html_e( 'Overrides', 'wp-configurator-pro' ); ?>:</span>
					</div>
					<div class="wpc-pull-right">
						<?php
							/**
							 * Scan the theme directory for all WC templates to see if our theme
							 * overrides any of them.
							 */
							$override_files     = array();
							$outdated_templates = false;
							$scan_files         = WPC_Utils::scan_template_files( WPC_TEMPLATES_DIR );

						foreach ( $scan_files as $file ) {

							if ( file_exists( get_stylesheet_directory() . '/' . WPC()->template_path() . $file ) ) {
								$theme_file = get_stylesheet_directory() . '/' . WPC()->template_path() . $file;
							} elseif ( file_exists( get_template_directory() . '/' . WPC()->template_path() . $file ) ) {
								$theme_file = get_template_directory() . '/' . WPC()->template_path() . $file;
							} else {
								$theme_file = false;
							}

							if ( ! empty( $theme_file ) ) {
								$core_file = $file;

								$core_version  = WPC_Utils::get_file_version( WPC_PLUGIN_DIR . '/templates/' . $core_file );
								$theme_version = WPC_Utils::get_file_version( $theme_file ) ? WPC_Utils::get_file_version( $theme_file ) : '3.0';
								if ( $core_version && ( empty( $theme_version ) || version_compare( $theme_version, $core_version, '<' ) ) ) {
									if ( ! $outdated_templates ) {
										$outdated_templates = true;
									}
								}
								$override_files[] = array(
									'file'         => str_replace( WP_CONTENT_DIR . '/themes/', '', $theme_file ),
									'version'      => $theme_version,
									'core_version' => $core_version,
								);
							}
						}

						$override_files = apply_filters( 'wpc_template_override_files', $override_files );
						?>
						<?php if ( ! empty( $override_files ) ) : ?>
							<?php
							$total_overrides = count( $override_files );
							for ( $i = 0; $i < $total_overrides; $i++ ) {
								$override = $override_files[ $i ];

								echo '<p>';
								if ( $override['core_version'] && ( empty( $override['version'] ) || version_compare( $override['version'], $override['core_version'], '<' ) ) ) {
									$current_version = $override['version'] ? $override['version'] : '-';
									printf(
										/* Translators: %1$s: Template name, %2$s: Template version, %3$s: Core version. */
										esc_html__( '%1$s version %2$s is out of date. The core version is %3$s', 'wp-configurator-pro' ),
										'<code>' . esc_html( $override['file'] ) . '</code>',
										'<strong style="color:red">' . esc_html( $current_version ) . '</strong>',
										esc_html( $override['core_version'] )
									);
								} else {
									echo esc_html( $override['file'] );
								}
								if ( ( count( $override_files ) - 1 ) !== $i ) {
									echo ', ';
								}
								echo '</p>';
							}
							?>
						<?php else : ?>
							<span>&ndash;</span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
