<?php
/*
	Plugin Name: WP Configurator Lite
	Plugin URI: https://my.wpconfigurator.com/downloads/configurator-plugin/
	Description: It gives endless possibilities to create customizations for your products and offer visitors a truly different shopping experience.
	Version: 1.0
	Derived from: 3.5.3
	Author: WP Configurator
	Author URI: https://wpconfigurator.com/
	Text Domain: wp-configurator-pro
	Domain Path: /languages/
*/

defined( 'ABSPATH' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC' ) ) {

	/**
	 * Configurator Core Class.
	 */
	class WPC {

		/**
		 * The single instance of the class.
		 *
		 * @var null
		 */
		protected static $instance = null;


		/**
		 * Configurator backend editor.
		 *
		 * @var object
		 */
		public $editor = null;


		/**
		 * Configurator backend editor controls manager.
		 *
		 * @var object
		 */
		public $editor_controls = null;

		/**
		 * Minimum PHP Version
		 *
		 * @since 1.0
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '7.4';

		/**
		 * Main Helper Instance.
		 *
		 * Ensures only one instance of Helper is loaded or can be loaded.
		 *
		 * @static
		 * @return WPC - Main instance.
		 */
		public static function instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();

				/**
				* WP Configurator Pro loaded.
				*
				* Fires when WP Configurator Pro was fully loaded and instantiated.
				*
				* @since 1.0
				*/
				do_action( 'wpcl_loaded' );
			}

			return self::$instance;

		}

		/**
		 * Constructor.
		 */
		public function __construct() {

			$this->define_constants();
			$this->includes();

			register_activation_hook( WPC_PLUGIN_FILE, array( $this, 'install' ) );

			add_action( 'init', array( $this, 'init' ) );
			add_action( 'plugins_loaded', array( $this, 'plugins_textdomain' ) );
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
			add_filter( 'single_template', array( $this, 'single_page_template' ) );

			do_action( 'wpcl_loaded' );

		}

		/**
		 * When plugin activates, add the data version.
		 *
		 * @return void
		 */
		public function install() {
			$data_version = get_option( 'wpc_data_version', false );

			if ( ! $data_version ) {
				add_option( 'wpc_data_version', WPC_DATABASE_VERSION );
			}
		}

		/**
		 * Init hook.
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		public function init() {

			// Check for required PHP version.
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
				return;
			}

			if ( did_action( 'wpc_loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_pro_version_installed' ) );
			}
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function admin_notice_minimum_php_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wp-configurator-pro' ),
				'<strong>' . esc_html__( 'WP Configurator Pro', 'wp-configurator-pro' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'wp-configurator-pro' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * WP Configurator Pro installed, deactivate the lite version.
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		public function admin_notice_pro_version_installed() {
			deactivate_plugins( 'wp-configurator-lite/wp-configurator-lite.php' );
		}

		/**
		 * Define constants.
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		private function define_constants() {
			define( 'WPCL_VERSION', '1.0' );
			define( 'WPC_VERSION', '3.5.3' );
			define( 'WPC_DATABASE_VERSION', '3.4' );
			define( 'WPC_GOOGLE_FONT_VERSION', '3.4' );

			define( 'WPC_DEV_MODE', false );

			define( 'WPC_PLUGIN_FILE', __FILE__ );
			define( 'WPC_PLUGIN_BASENAME', plugin_basename( WPC_PLUGIN_FILE ) );

			define( 'WPC_PLUGIN_DIR', plugin_dir_path( WPC_PLUGIN_FILE ) );
			define( 'WPC_INCLUDE_DIR', WPC_PLUGIN_DIR . 'includes/' );
			define( 'WPC_TEMPLATES_DIR', WPC_PLUGIN_DIR . 'templates/' );
			define( 'WPC_SHORTCODES_DIR', WPC_INCLUDE_DIR . 'shortcodes/' );

			define( 'WPC_PLUGIN_URL', plugins_url( '', WPC_PLUGIN_FILE ) );
			define( 'WPC_ASSETS_URL', WPC_PLUGIN_URL . '/assets/' );
			define( 'WPC_TEMPLATE_PATH', $this->template_path() );
			define( 'WPC_WOO_ACTIVE', $this->woo_active() );
			define( 'WPC_CF7_ACTIVE', $this->cf7_active() );
		}

		/**
		 * Include required core files.
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		public function includes() {

			// Include useful 3rd party plugins.
			require WPC_INCLUDE_DIR . 'helper-plugin/aq_resizer.php';
			require WPC_INCLUDE_DIR . 'helper-plugin/pelago/emogrifier/Emogrifier.php';
			require WPC_INCLUDE_DIR . 'helper-plugin/pelago/emogrifier/HtmlProcessor/AbstractHtmlProcessor.php';
			require WPC_INCLUDE_DIR . 'helper-plugin/pelago/emogrifier/CssInliner.php';
			require WPC_INCLUDE_DIR . 'helper-plugin/pelago/emogrifier/Utilities/CssConcatenator.php';
			require WPC_INCLUDE_DIR . 'helper-plugin/pelago/emogrifier/Utilities/ArrayIntersector.php';
			require WPC_INCLUDE_DIR . 'helper-plugin/pelago/emogrifier/HtmlProcessor/HtmlPruner.php';
			require WPC_INCLUDE_DIR . 'helper-plugin/pelago/emogrifier/HtmlProcessor/CssToAttributeConverter.php';
			require WPC_INCLUDE_DIR . 'helper-plugin/pelago/emogrifier/HtmlProcessor/HtmlNormalizer.php';

			// Helper.
			require WPC_INCLUDE_DIR . 'class-utils.php';

			// Admin.
			require WPC_INCLUDE_DIR . 'admin/class-admin-config.php';
			require WPC_INCLUDE_DIR . 'admin/class-import-export.php';
			require WPC_INCLUDE_DIR . 'admin/updater/update-handler.php';
			require WPC_INCLUDE_DIR . 'admin/class-post-types.php';
			require WPC_INCLUDE_DIR . 'admin/class-menus.php';
			require WPC_INCLUDE_DIR . 'admin/class-option-fields.php';

			require WPC_INCLUDE_DIR . 'class-ajax-callback.php';

			// Frontend.
			require WPC_INCLUDE_DIR . 'class-config-data.php';
			require WPC_INCLUDE_DIR . 'frontend/class-frontend-config.php';
			require WPC_INCLUDE_DIR . 'frontend/class-quote-form-custom-fields.php';
			require WPC_INCLUDE_DIR . 'frontend/class-config-custom-fields.php';

			// Configurator Shortcode.
			require WPC_INCLUDE_DIR . 'template-hooks.php';
			require WPC_INCLUDE_DIR . 'template-functions.php';
			require WPC_SHORTCODES_DIR . 'class-config-elements.php';

			require WPC_SHORTCODES_DIR . 'include-config-elements.php';
		}

		/**
		 * Registor editor.
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		public function plugins_loaded() {

			// Editor.
			require WPC_INCLUDE_DIR . 'admin/editor/class-wpc-editor.php';
			$this->editor = new WPC_Editor();

			// Controls Manager Class.
			require WPC_INCLUDE_DIR . 'admin/editor/class-wpc-editor-controls.php';
			$this->editor_controls = new WPC_Editor_Controls();

		}

		/**
		 * Returns the plugin path.
		 *
		 * @since 1.0
		 * @access public
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( WPC_PLUGIN_FILE ) );
		}

		/**
		 * Returns the plugin url.
		 *
		 * @since 1.0
		 * @access public
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', WPC_PLUGIN_FILE ) );
		}

		/**
		 * Set the plugin text domain load path.
		 *
		 * @since 1.0
		 * @access public
		 * @return void
		 */
		public function plugins_textdomain() {
			load_plugin_textdomain( 'wp-configurator-lite', false, plugin_basename( dirname( WPC_PLUGIN_FILE ) ) . '/languages' );
		}

		/**
		 * If it is a configurator single post, load this file.
		 *
		 * @param string $page_template single page template.
		 * @since 1.0
		 * @access public
		 * @return string
		 */
		public function single_page_template( $page_template ) {

			if ( is_singular( 'amz_configurator' ) ) {
				$page_template = WPC_Utils::locate_template( 'single-configurator.php' );
			}

			return $page_template;
		}

		/**
		 * Returns the template path.
		 *
		 * @since 1.0
		 * @access public
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'configurator_template_path', 'configurator/' );
		}

		/**
		 * Check WooCommerce is active?
		 *
		 * @since 1.0
		 * @access public
		 * @return bool
		 */
		public function woo_active() {

			$active = false;

			if ( $this->is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				$active = true;
			}

			return $active;
		}

		/**
		 * Check Contact form 7 is active?
		 *
		 * @since 1.0
		 * @access public
		 * @return bool
		 */
		public function cf7_active() {

			$active = false;

			if ( $this->is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
				$active = true;
			}

			return $active;
		}

		/**
		 * Returns the plugins wheather it is active or not?
		 *
		 * @param string $plugin Plugin path.
		 * @since 1.0
		 * @access public
		 * @return bool
		 */
		public function is_plugin_active( $plugin = '' ) {

			if ( in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) ) {
				return true;
			}

			if ( ! is_multisite() ) {
				return false;
			}

			$plugins = get_site_option( 'active_sitewide_plugins' );
			if ( isset( $plugins[ $plugin ] ) ) {
				return true;
			}

			return false;
		}

	}

	/**
	 * Main instance of WPC.
	 *
	 * Returns the main instance of WPC to prevent the need to use globals.
	 */
	function WPC() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
		return WPC::instance();
	}

	// Global for backwards compatibility.
	$wpc = WPC();

}
