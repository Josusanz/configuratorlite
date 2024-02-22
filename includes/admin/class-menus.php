<?php
/**
 * Admin menus and calbacks.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @version  3.4.10
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Plugin_Menu' ) ) {

	/**
	 * Add admin menus
	 */
	class WPC_Plugin_Menu {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'register_menus' ) );
		}

		/**
		 * Register plugin settings menu.
		 *
		 * @return void
		 */
		public function register_menus() {
			add_submenu_page(
				'edit.php?post_type=amz_configurator',
				esc_html__( 'Inspirations', 'wp-configurator-pro' ),
				esc_html__( 'Inspirations', 'wp-configurator-pro' ),
				apply_filters( 'wpc_menu_inspiration_role', 'administrator' ),
				'wpc-inspirations',
				array( $this, 'manage_inspirations_page' )
			);

			add_submenu_page(
				'edit.php?post_type=amz_configurator',
				esc_html__( 'Status', 'wp-configurator-pro' ),
				esc_html__( 'Status', 'wp-configurator-pro' ),
				apply_filters( 'wpc_menu_status_role', 'administrator' ),
				'wpc-status',
				array( $this, 'manage_status_page' )
			);

			add_submenu_page(
				'edit.php?post_type=amz_configurator',
				esc_html__( 'Tools', 'wp-configurator-pro' ),
				esc_html__( 'Tools', 'wp-configurator-pro' ),
				apply_filters( 'wpc_menu_tools_role', 'administrator' ),
				'wpc-tools',
				array( $this, 'manage_tools_page' )
			);

			add_submenu_page(
				'edit.php?post_type=amz_configurator',
				esc_html__( 'Settings', 'wp-configurator-pro' ),
				esc_html__( 'Settings', 'wp-configurator-pro' ),
				apply_filters( 'wpc_menu_settings_role', 'administrator' ),
				'wpc-settings',
				array( $this, 'manage_settings_page' )
			);

			add_submenu_page(
				'edit.php?post_type=amz_configurator',
				esc_html__( 'License', 'wp-configurator-pro' ),
				esc_html__( 'License', 'wp-configurator-pro' ),
				apply_filters( 'wpc_menu_license_role', 'administrator' ),
				'wpc-license',
				array( $this, 'manage_license_page' )
			);

		}

		/**
		 * Callback function for settings.
		 *
		 * @return void
		 */
		public function manage_settings_page() {

			$tab = isset( $_GET['tab'] ) ? wp_unslash( $_GET['tab'] ) : 'general';
			?>
				<div class="wpc-settings-wrap page-tab-<?php esc_attr( $tab ); ?>">

					<h2 class="title"><?php esc_html_e( 'Welcome to WP Configurator!', 'wp-configurator-pro' ); ?></h2>
					<p class="sub-title"><?php esc_html_e( 'Thank you for using Configurator Lite. If you need help or have any suggestions, please contact us.', 'wp-configurator-pro' ); ?></p>

					<ul class="nav-tab-wrapper">
						<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=general" class="nav-tab <?php echo 'general' === $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General', 'wp-configurator-pro' ); ?></a></li>						
						<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=text-string" class="nav-tab <?php echo 'text-string' === $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Text String', 'wp-configurator-pro' ); ?></a></li>
						<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=design-options" class="nav-tab <?php echo 'design-options' === $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Design Options', 'wp-configurator-pro' ); ?></a></li>
						<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=typography" class="nav-tab <?php echo 'typography' === $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Typography', 'wp-configurator-pro' ); ?></a></li>
						<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=css" class="nav-tab <?php echo 'css' === $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Custom CSS', 'wp-configurator-pro' ); ?></a></li>
					</ul> <!-- .nav-tab-wrapper -->

					<?php
					if ( 'general' === $tab ) :
						include_once WPC_INCLUDE_DIR . 'admin/settings-page/general.php';
					elseif ( 'text-string' === $tab ) :
						include_once WPC_INCLUDE_DIR . 'admin/settings-page/text-string.php';
					elseif ( 'design-options' === $tab ) :
						include_once WPC_INCLUDE_DIR . 'admin/settings-page/design-options.php';
					elseif ( 'typography' === $tab ) :
						include_once WPC_INCLUDE_DIR . 'admin/settings-page/typography.php';
					elseif ( 'css' === $tab ) :
						include_once WPC_INCLUDE_DIR . 'admin/settings-page/options-css.php';
					endif;
					?>

				</div> <!-- .wpc-settings-wrap -->

			<?php
		}

		/**
		 * Callback function for inspirations.
		 *
		 * @return void
		 */
		public function manage_inspirations_page() {
			include WPC_INCLUDE_DIR . 'admin/views/html-inspirations-page.php';
		}

		/**
		 * Callback function for status.
		 *
		 * @return void
		 */
		public function manage_status_page() {
			include WPC_INCLUDE_DIR . 'admin/views/html-status-page.php';
		}

		/**
		 * Callback function for tools.
		 *
		 * @return void
		 */
		public function manage_tools_page() {
			include WPC_INCLUDE_DIR . 'admin/views/html-tools-page.php';
		}

		/**
		 * Callback function for tools.
		 *
		 * @return void
		 */
		public function manage_license_page() {
			include WPC_INCLUDE_DIR . 'admin/views/html-license-page.php';
		}
	}

}

new WPC_Plugin_Menu();
