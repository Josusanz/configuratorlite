<?php
/**
 * Import and Export.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @version  3.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( ! class_exists( 'WPC_Import_Export_Posts' ) ) {

	/**
	 * Import/Export
	 */
	class WPC_Import_Export_Posts {	


		/**
		 * Configurator layer image fields.
		 *
		 * @var array
		 */
		public $image_fields = array();

		/**
		 * Configurator import temporary files folder.
		 */
		const TEMP_FILES_DIR = 'configurator/tmp';

		/**
		 * Hook in methods.
		 */
		public function __construct() {

			add_filter( 'wpc_page_row_actions', array( $this, 'page_row_actions' ), 10, 2 );

			add_action( 'admin_footer', array( $this, 'admin_import_template_form' ) );

			add_filter( 'bulk_actions-edit-amz_configurator', array( $this, 'admin_add_bulk_export_action' ) );
		}

		/**
		 * Post row actions.
		 *
		 * Add an export link to the template library action links table list.
		 *
		 * Fired by `page_row_actions` filter.
		 *
		 * @since 1.0
		 * @access public
		 *
		 * @param array    $actions An array of row action links.
		 * @param \WP_Post $post    The post object.
		 *
		 * @return array An updated array of row action links.
		 */
		public function page_row_actions( $actions, $post ) {

			$export_link = add_query_arg(
				array(
					'action' => 'wpc_export_template',
					'_nonce' => wp_create_nonce( 'wpc_admin_export_template' ),
					'post'   => esc_attr( $post->ID ),
				),
				admin_url()
			);

			$actions['export-template'] = sprintf( '<span>%1$s<span class="wpcl-pro-text">%2$s</span></span>', esc_html__( 'Export Template', 'wp-configurator-pro' ), esc_html__( '(Pro)', 'wp-configurator-pro' ) );

			return $actions;

		}

		/**
		 * Bulk export action.
		 *
		 * Adds an 'Export' action to the Bulk Actions drop-down in the template
		 * library.
		 */
		public function admin_add_bulk_export_action( $actions ) {
			$actions['wpc_export_multiple_templates'] = sprintf( wp_kses( __( '%s<span class="wpcl-pro-text">%s</span>', 'wp-configurator-pro' ), array( 'span' => array( 'class' => array() ) ) ), esc_html__( 'Export', 'wp-configurator-pro' ), esc_html__( '(Pro)', 'wp-configurator-pro' ) );

			return $actions;
		}

		/**
		 * Admin import template form.
		 *
		 * The import form displayed in "amz_configurator" screen in WordPress dashboard.
		 *
		 * The form allows the user to import template in json/zip format to the site.
		 *
		 * Fired by `admin_footer` action.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function admin_import_template_form() {

			global $current_screen;

			if ( ! ( 'edit' === $current_screen->base && 'amz_configurator' === $current_screen->post_type ) ) {
				return;
			}

			?>
			<div id="wpc-hidden-area">
				<span id="wpc-import-template-trigger" class="page-title-action"><?php esc_html_e( 'Import Configurators', 'wp-configurator-pro' ); ?><span class="wpcl-pro-text"><?php esc_html_e( '(Pro)', 'wp-configurator-pro' ); ?></span></span></span>
			</div>
			<?php
		}
	}

}

return new WPC_Import_Export_Posts();
