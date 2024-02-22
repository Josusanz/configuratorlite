<?php
/**
 * Editor.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @version  3.5.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/**
 * WPC_Editor class
 */
class WPC_Editor {

	/**
	 * Editor data from api
	 *
	 * @var [type]
	 */
	private $editor_data;

	public function __construct() {
		$this->register_hooks();
	}

	private function register_hooks() {

		// Register hook to add a menu to the admin page.
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );

		add_filter( 'wpc_page_row_actions', array( $this, 'page_row_actions' ), 10, 2 );
		add_action( 'admin_menu', array( $this, 'remove_themes_submenu' ), 999 );

		add_action( 'admin_print_scripts', array( $this, 'admin_print_scripts' ) );

	}

	public function add_admin_menu() {

		add_submenu_page(
			'edit.php?post_type=amz_configurator',
			esc_html__( 'Editor', 'wp-configurator-pro' ),
			esc_html__( 'Editor', 'wp-configurator-pro' ),
			'edit_posts',
			'wpc-editor',
			array( $this, 'wpc_editor' ),
			2
		);

		global $title;
		$post_id = isset( $_GET['post'] ) ? $_GET['post'] : 0;

		if ( $post_id ) {
			$title = sprintf( '"%s"', esc_html( get_the_title( $post_id ) ) );
		}

	}

	public function remove_themes_submenu() {
		remove_submenu_page( 'edit.php?post_type=amz_configurator', 'wpc-editor' );
	}

	public function wpc_editor() {

		do_action( 'wpc/editor/before_load_scripts' );

		wp_enqueue_style( 'wpc-editor-css' );

		wp_enqueue_script( 'vue' );
		wp_enqueue_script( 'vuex' );

		wp_enqueue_script( 'wpc-editor-hooks-js' );

		do_action( 'wpc/editor/addon_scripts' );

		wp_enqueue_script( 'wpc-editor-js' );

		do_action( 'wpc/editor/after_load_scripts' );

		// page templates.
		require_once WPC_INCLUDE_DIR . 'admin/editor/templates/editor-page.php';
	}

	public function load_scripts() {

		$vue_directory = plugin_dir_url( __FILE__ ) . 'dist';

		wp_enqueue_style( 'wpc-material-icons', '//fonts.googleapis.com/icon?family=Material+Icons', array(), '3.0', 'all' );
		wp_enqueue_style( 'wpc-configurator-fonts', '//fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800', array(), '3.0', 'all' );

		// set script as module
		add_filter( 'script_loader_tag', array( $this, 'add_type_attribute' ), 10, 3 );

		wp_register_script( 'wpc-editor-hooks-js', WPC_ASSETS_URL . 'backend/js/hooks.js', array( 'jquery' ), '1.0', true );

		if ( $this->is_develop_serve() ) {

			wp_register_script( 'vue', WPC_ASSETS_URL . 'vendor/vue.global.js', array(), '3.2.29', true );
			wp_register_script( 'vuex', WPC_ASSETS_URL . 'vendor/vuex.global.js', array( 'vue' ), '4.0.2', true );

			wp_register_script( 'wpc-editor-js', 'http://localhost:3000/src/main.js', array( 'jquery', 'wpc-editor-hooks-js' ), '3.5.3', true );

		} else {

			wp_register_script( 'vue', WPC_ASSETS_URL . 'vendor/vue.global.prod.js', array(), '3.2.29', true );

			wp_register_script( 'vuex', WPC_ASSETS_URL . 'vendor/vuex.global.prod.js', array( 'vue' ), '4.0.2', true );

			wp_register_script( 'wpc-editor-js', WPC_ASSETS_URL . 'editor/main.min.js', array( 'jquery', 'wpc-editor-hooks-js' ), '3.5.31', true );

			wp_register_style( 'wpc-editor-css', WPC_ASSETS_URL . 'editor/main.min.css', array(), '3.5.3', 'all' );

		}
	}

	public function admin_print_scripts() {

		// Allow addons to register extra controls.
		do_action( 'wpc/editor/register_controls' );

		$layer_controls  = WPC()->editor_controls->get_layer_controls();
		$global_controls = WPC()->editor_controls->get_global_controls();
		$css_js_controls = WPC()->editor_controls->get_css_js_controls();

		$layer_types = WPC()->editor_controls->get_layer_types();

		// TODO: change as function like $this->get_components()
		$post_id = $_GET['post'] ?? '0'; // phpcs:ignore
		$components = WPC_Utils::get_meta_value( $post_id, '_wpc_components', array() );

		// TODO: change as function like $this->get_views()
		$views = WPC_Utils::get_meta_value( $post_id, '_wpc_views', array( 'front' => esc_html__( 'Front', 'wp-configurator-pro' ) ) );

		$view_array = array();

		if ( $views ) {
			foreach ( $views as $key => $view ) {
				$view_array[] = array(
					'id'   => $key,
					'name' => $view,
				);
			}
		}

		$images = WPC_Utils::get_meta_value( $post_id, '_wpc_editor_images', array() );

		/*
		 'defaults' => array(
			'settings'  => array(
				'layer' => array(
					'name' => 'tab_name',
					'icon' => 'icon',
					'controls' => $layer_controls,
				),
				'global' => array(
					'name' => 'tab_name',
					'icon' => 'icon',
					'controls' => $global_controls,
				)
			),
			'layers_types'    => $layer_types,
		),
		*/

		$data_version = WPC_Utils::get_meta_value( $post_id, '_wpc_data_version', false );

		$duplicate_link = add_query_arg(
			array(
				'action' => 'wpc_duplicate_config_post',
				'post'   => esc_attr( $post_id ),
				'_nonce' => wp_create_nonce( 'wpc_duplicate_config_post_ajax' ),
			),
			admin_url()
		);

		$current_user_id = get_current_user_id();

		$tour_completed = get_user_meta( $current_user_id, 'wpc_tour_completed', true );

		$editor_data = array(
			'dashboard_url'           => admin_url(),
			'edit_page_url'           => admin_url( 'edit.php?post_type=amz_configurator' ),
			'preview_url'             => get_preview_post_link( $post_id ),
			'duplicate_post_url'      => $duplicate_link,
			'save_btn_text'           => ( 'publish' === get_post_status( $post_id ) ) ? esc_html__( 'Update', 'wp-configurator-pro' ) : esc_html__( 'Publish', 'wp-configurator-pro' ),
			'post_id'                 => $post_id,
			'title'                   => esc_html( get_the_title( $post_id ) ),
			'permalink'               => esc_url( get_permalink( $post_id ) ),
			'tabs'                    => array(
				'layer_controls'  => $layer_controls,
				'global_controls' => $global_controls,
				'css_js_controls' => $css_js_controls,
			),
			'defaults'                => array(
				'layers_types' => $layer_types,
			),
			'global_controls_default' => $this->get_global_controls_default( $post_id, $global_controls ),
			'i18n'                    => array(
				'group' => esc_html__( 'Group', 'wp-configurator-pro' ),
			),
			'image_fields'            => WPC_Utils::get_image_fields(),
			'components'              => $components,
			'data_version'            => $data_version,
			'views'                   => $view_array,
			'images'                  => $images,
			'tour_completed'          => WPC_Utils::str_to_bool( $tour_completed ),
			'toolbar_icons'           => apply_filters( 'wpc_editor_toolbar_icons', array(), $post_id ),
			'allowed_fonts'           => apply_filters( 'wpc_editor_allowed_fonts', get_option( 'wpc_allowed_fonts', array() ), $post_id ),
			'addon_datas'             => apply_filters( 'wpc_editor_addon_data', array(), $post_id ),
			'_nonce'                  => wp_create_nonce( 'wpc-update-post' ),
		);

		$extended_data = apply_filters( 'wpc_editor_add_data', $editor_data );

		// Added edited data as second param to avoid default data overwritten.
		$this->editor_data = array_merge( $extended_data, $editor_data );

		echo "<script type='text/javascript'>\n";
		echo 'window.wpc = window.wpc || {};';
		echo 'wpc.editor = ' . wp_json_encode( $this->editor_data ) . ';';
		echo "\n</script>";
	}

	public function get_global_controls_default( $post_id, $global_controls ) {

		$global_controls_default = array();

		foreach ( $global_controls as $tab => $value ) {
			foreach ( $value['settings'] as $key => $value ) {
				$global_controls_default[ $key ] = WPC_Utils::get_meta_value( $post_id, $key );
			}
		}

		return $global_controls_default;
	}

	private function is_develop_serve() {
		if ( WPC_DEV_MODE ) {
			return true;
		}

		return false;
	}

	public function add_type_attribute( $tag, $handle, $src ) {

		// if not your script, do nothing and return original $tag.
		if ( 'wpc-editor-js' !== $handle && 'wpc-editor-chunks' !== $handle ) {
			return $tag;
		}

		// change the script tag by adding type="module" and return it.
		$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
		return $tag;

	}

	/**
	 * Post row actions.
	 *
	 * Add an export link to the template library action links table list.
	 *
	 * Fired by `page_row_actions` filter.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array    $actions An array of row action links.
	 * @param \WP_Post $post    The post object.
	 *
	 * @return array An updated array of row action links.
	 */
	public function page_row_actions( $actions, $post ) {

		$link = add_query_arg(
			array(
				'page' => 'wpc-editor',
				'post' => esc_attr( $post->ID ),
			),
			admin_url( 'edit.php?post_type=amz_configurator' )
		);

		array_splice( $actions, 1, 0, array( 'wpc-editor' => sprintf( '<a href="%1$s">%2$s</a>', esc_url( $link ), esc_html__( 'Edit', 'wp-configurator-pro' ) ) ) );

		return $actions;

	}

}
