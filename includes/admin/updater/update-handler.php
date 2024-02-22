<?php
/**
 * Update handler.
 *
 * @package  wp-configurator-pro/includes/admin/updater
 * @version  2.0
 * @since  3.4.9
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/**
 * License update handler.
 */
class WPC_Update_Handler {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->define_constants();
		$this->includes();

		$status = get_option( 'wpc_license_status' );

		if ( 'valid' === $status ) {
			$this->setup_update();
		}

		add_action( 'admin_init', array( $this, 'register_option' ) );

		add_action( 'admin_init', array( $this, 'activate_license' ) );

		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		add_action( 'admin_init', array( $this, 'deactivate_license' ) );

	}

	/**
	 * Define Constants.
	 *
	 * @return void
	 */
	private function define_constants() {

		define( 'WPC_ITEM_NAME', 'WP Configurator Pro' );

		define( 'WPC_STORE_URL', 'https://my.wpconfigurator.com' );

		// Product ID in EDD.
		define( 'WPC_ITEM_ID', 2407 );

		define( 'WPC_PLUGIN_LICENSE_PAGE', 'edit.php?post_type=amz_configurator&page=wpc-license' );

	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	private function includes() {
		if ( ! class_exists( 'WPC_Plugin_Updater' ) ) {
			include dirname( __FILE__ ) . '/class-plugin-updater.php';
		}
	}

	/**
	 * Setup update handler.
	 *
	 * @return void
	 */
	private function setup_update() {

		// Retrieve plugin license key.
		$license_key = trim( get_option( 'wpc_license_key' ) );

		// Setup updater.
		$updater = new WPC_Plugin_Updater(
			WPC_STORE_URL,
			WPC_PLUGIN_FILE,
			array(
				'version' => WPC_VERSION,       // Plugin version.
				'license' => $license_key,      // License key.
				'item_id' => WPC_ITEM_ID,       // Product ID in EDD.
				'author'  => 'WP Configurator', // Plugin author.
				'url'     => home_url(),
			)
		);

	}

	/**
	 * Register option.
	 *
	 * @return void
	 */
	public function register_option() {
		// creates our settings in the options table.
		register_setting( 'wpc_license', 'wpc_license_key', array( $this, 'sanitize_license' ) );
	}

	/**
	 * Save license key.
	 *
	 * @param string $new New license key.
	 * @return void
	 */
	public function sanitize_save_license( $new ) {

		$old = get_option( 'wpc_license_key' );

		if ( ! $old ) {
			update_option( 'wpc_license_key', $new );
		}

		if ( $old && $old != $new ) {
			delete_option( 'wpc_license_status' ); // New license has been entered, so must reactivate.
			update_option( 'wpc_license_key', $new );
		}
	}

	/**
	 * Sanitize license.
	 *
	 * @param string $new New license key.
	 * @return string
	 */
	public function sanitize_license( $new ) {
		$old = get_option( 'wpc_license_key' );
		if ( $old && $old != $new ) {
			delete_option( 'wpc_license_status' ); // New license has been entered, so must reactivate.
		}
		return $new;
	}

	/**
	 * Activate license
	 *
	 * @return void
	 */
	public function activate_license() {
		// listen for our activate button to be clicked.
		if ( isset( $_POST['wpc_license_activate'] ) ) {
			// run a quick security check.
			if ( ! check_admin_referer( 'wpc_nonce', 'wpc_nonce' ) ) {
				return; // get out if we didn't click the Activate button.
			}
			// retrieve the license from the database.
			$license = trim( get_option( 'wpc_license_key' ) );

			if ( ! $license && isset( $_POST['wpc_license_key'] ) ) {
				$license = trim( $_POST['wpc_license_key'] );
			}

			// data to send in our API request.
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $license,
				'item_id'    => WPC_ITEM_ID, // The ID of the item in EDD.
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post(
                WPC_STORE_URL,
                array(
                    'method'    => 'GET',
                    'timeout'   => 45,
                    'sslverify' => false,
                    'headers'     => array(
                        'Content-Type' => 'application/json',
                    ),
                    'body'      => $api_params,
                )
            );

			// make sure the response came back okay.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				$message = ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : __( 'An error occurred, please try again.' );
			} else {
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );
				if ( false === $license_data->success ) {
					switch ( $license_data->error ) {
						case 'expired':
							$message = sprintf(
								/* translators: 1: Expiry date */
								esc_html__( 'Your license key expired on %s.', 'wp-configurator-pro' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;
						case 'revoked':
							$message = esc_html__( 'Your license key has been disabled.', 'wp-configurator-pro' );
							break;
						case 'missing':
							$message = esc_html__( 'Invalid license.', 'wp-configurator-pro' );
							break;
						case 'invalid':
						case 'site_inactive':
							$message = esc_html__( 'Your license is not active for this URL.', 'wp-configurator-pro' );
							break;
						case 'item_name_mismatch':
							/* translators: 1: Plugin name */
							$message = sprintf( esc_html__( 'This appears to be an invalid license key for %s.', 'wp-configurator-pro' ), WPC_ITEM_NAME );
							break;
						case 'no_activations_left':
							$message = esc_html__( 'Your license key has reached its activation limit.', 'wp-configurator-pro' );
							break;
						default:
							$message = esc_html__( 'An error occurred, please try again.', 'wp-configurator-pro' );
							break;
					}
				}
			}
			// Check if anything passed on a message constituting a failure.
			if ( ! empty( $message ) ) {
				$base_url = admin_url( WPC_PLUGIN_LICENSE_PAGE );
				$redirect = add_query_arg(
					array(
						'wpc_activation' => 'false',
						'message'        => rawurlencode( $message ),
					),
					$base_url
				);
				wp_redirect( $redirect );
				exit();
			} else {
				$status = $license_data->license;
				// $license_data->license will be either "valid" or "invalid"
				update_option( 'wpc_license_status', $status );

				if ( 'valid' === $status ) {
					$this->sanitize_save_license( $license );
				}

				wp_redirect( admin_url( WPC_PLUGIN_LICENSE_PAGE ) );
				exit();
			}
		}
	}

	/**
	 * Deactivate license.
	 *
	 * @return void
	 */
	public function deactivate_license() {

		// listen for our activate button to be clicked.
		if ( isset( $_POST['wpc_license_deactivate'] ) ) {

			// run a quick security check.
			if ( ! check_admin_referer( 'wpc_nonce', 'wpc_nonce' ) ) {
				return; // get out if we didn't click the Deactivate button.
			}

			// retrieve the license from the database.
			$license = trim( get_option( 'wpc_license_key' ) );

			// data to send in our API request.
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $license,
				'item_id'    => WPC_ITEM_ID,
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post(
                WPC_STORE_URL,
                array(
                    'method'    => 'GET',
                    'timeout'   => 45,
                    'sslverify' => false,
                    'headers'     => array(
                        'Content-Type' => 'application/json',
                    ),
                    'body'      => $api_params,
                )
            );

			// make sure the response came back okay.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = esc_html__( 'An error occurred, please try again.', 'wp-configurator-pro' );
				}

				$base_url = admin_url( WPC_PLUGIN_LICENSE_PAGE );
				$redirect = add_query_arg(
					array(
						'wpc_activation' => 'false',
						'message'        => rawurlencode( $message ),
					),
					$base_url
				);

				wp_redirect( $redirect );
				exit();
			} else {
				// Decode the license data.
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				// $license_data->license will be either "deactivated" or "failed"
				if ( 'deactivated' === $license_data->license ) {
					delete_option( 'wpc_license_status' );
					delete_option( 'wpc_license_key' );
				}

				wp_redirect( admin_url( WPC_PLUGIN_LICENSE_PAGE ) );
				exit();
			}
		}
	}

	/**
	 * This is a means of catching errors from the activation method above and displaying it to the customer
	 */
	public function admin_notices() {
		if ( isset( $_GET['wpc_activation'] ) && ! empty( $_GET['message'] ) ) {
			switch ( $_GET['wpc_activation'] ) {
				case 'false':
					$message = urldecode( $_GET['message'] );
					?>
					<div class="error">
						<p><?php echo esc_html( $message ); ?></p>
					</div>
					<?php
					break;
				case 'true':
				default:
					// Developers can put a custom success message here for when activation is successful if they way.
					break;
			}
		}
	}

}

new WPC_Update_Handler();
