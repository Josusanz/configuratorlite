<?php
/**
 * Editor Controls.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @version  3.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/**
 * Class responsible for register controls
 */
class WPC_Editor_Controls {

	/**
	 * Configurator post id
	 *
	 * @var Number
	 */
	public $post_id;

	/**
	 * Whether configurator posts exist
	 *
	 * @var Boolean
	 */
	public $post_exists;

	/**
	 * Layer Settings
	 *
	 * @var array
	 */
	private $layer_types = array();

	/**
	 * Register editor controls manager.
	 *
	 * @var object
	 */
	private $register_controls = null;

	/**
	 * Layer Settings
	 *
	 * @var array
	 */
	private $layer_settings = array();

	/**
	 * Global Settings (Common configurator settings)
	 *
	 * @var array
	 */
	private $global_settings = array();

	/**
	 * CSS/JS Settings
	 *
	 * @var array
	 */
	private $css_js_settings = array();

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->check_post_exists();

		$this->register_defaults();

	}

	/**
	 * Check Configurator posts exits
	 *
	 * @return boolean
	 */
	private function check_post_exists() {

		$this->post_id = $_GET['post'] ?? '0'; // phpcs:ignore

		/* TODO: check post is exist in configurator */

		if ( $this->post_id ) {
			$this->post_exists = true;
		} else {
			$this->post_exists = false;
		}

		return $this->post_exists;

	}

	/**
	 * Register defaults
	 *
	 * @return void
	 */
	private function register_defaults() {

		// Setup Layer types.
		$this->register_layer_types();

		/* Set default array, to avoid addon override / remove settings, These settings are default and absolutely necessary */

		$this->layer_settings = array(

			'layer_type' => array(
				'name'     => esc_html__( 'Layer Type', 'wp-configurator-pro' ),
				'settings' => array(),
			),

			'controls'   => array(
				'name'     => esc_html__( 'Controls Settings', 'wp-configurator-pro' ),
				'settings' => array(),
			),

			'others'     => array(
				'name'     => esc_html__( 'Other Settings', 'wp-configurator-pro' ),
				'settings' => array(),
			),

		);

		$this->global_settings = array(

			'page' => array(
				'name'     => esc_html__( 'Page Settings', 'wp-configurator-pro' ),
				'settings' => array(),
			),

		);

		require WPC_INCLUDE_DIR . 'admin/editor/class-wpc-editor-register-controls.php';

		$this->register_controls = new WPC_Editor_Register_Controls();

		$this->layer_settings = $this->register_controls->get_controls( 'layer' );

		$this->global_settings = $this->register_controls->get_controls( 'global' );

		$this->css_js_settings = $this->register_controls->get_controls( 'css_js' );

	}

	/**
	 * Register types
	 *
	 * @return void
	 */
	private function register_layer_types() {

		$this->layer_types = array(
			'group'     => array(
				'name' => esc_html__( 'Group', 'wp-configurator-pro' ),
				'icon' => 'folder_special',
			),

			'sub_group' => array(
				'name'      => esc_html__( 'Sub Group(Pro)', 'wp-configurator-pro' ),
				'icon'      => 'folder',
				'disabled'  => true,
				'separator' => true,
			),

			'image'     => array(
				'name'        => esc_html__( 'Image', 'wp-configurator-pro' ),
				'icon'        => 'image',
				'allow-align' => true,
			),
		);

	}

	public function get_layer_types() {
		return $this->layer_types;
	}

	public function get_layer_controls() {
		return $this->layer_settings;
	}

	public function get_global_controls() {
		return $this->global_settings;
	}

	public function get_css_js_controls() {
		return $this->css_js_settings;
	}

	/**
	 * Register controls based on Type
	 *
	 * @param String $type settings type (type is layer or global).
	 * @param String $key .
	 * @param Array  $settings fields array.
	 * @return void
	 */
	public function register_controls( $type, $key, $settings ) {

		$type = $type . '_settings';

		if ( array_key_exists( $key, $this->$type ) ) {

			$this->$type[ $key ]['settings'] = array_merge( $this->$type[ $key ]['settings'], $settings );

		} else {
			$this->$type[ $key ] = $settings;
		}

	}

	/**
	 * Add Layer Type
	 *
	 * @param String $id .
	 * @param Array  $settings = array( 'image' => array(
	 *      'name' => esc_html__( 'Image', 'wp-configurator-pro' ),
	 *      'icon' => 'image',
	 * ) ).
	 * @return void
	 */
	public function add_layer_type( $id, $settings ) {

		$new_type = array(
			$id => $settings,
		);

		$this->layer_types = array_merge( $this->layer_types, $new_type );

	}

	/**
	 * Add Layer Settings
	 *
	 * @param String $key .
	 * @param Array  $settings .
	 * @return void
	 */
	public function add_layer_settings( $key, $settings ) {
		$this->register_controls( 'layer', $key, $settings );
	}

	/**
	 * Add Global Settings
	 *
	 * @param String $key .
	 * @param Array  $settings .
	 * @return void
	 */
	public function add_global_settings( $key, $settings ) {
		$this->register_controls( 'global', $key, $settings );
	}

	/**
	 * Get Configurator components
	 *
	 * @return $views
	 */
	private function get_configurator_cs() {

		if ( $this->post_exists ) {
			return;
		}

		$cs = WPC_Utils::get_meta_value( $this->post_id, 'components', array() );

		return $cs;

	}

	/**
	 * Get Configurator views
	 *
	 * @return $views
	 */
	private function get_configurator_views() {

		if ( $this->post_exists ) {
			return;
		}

		$view = WPC_Utils::get_meta_value( $id, '_pwc_views', array( 'front' => esc_html__( 'Front', 'wp-configurator-pro' ) ) );

		return $view;

	}

}

