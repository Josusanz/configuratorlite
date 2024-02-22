<?php
/**
 * Register Controls.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @since  3.0
 * @version  3.4.12
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/**
 * Class responsible for register controls
 */
class WPC_Editor_Register_Controls {

	/**
	 * Layer Controls.
	 *
	 * @var Array
	 */
	private $layer_controls;

	/**
	 * Global Controls.
	 *
	 * @var Array
	 */
	private $global_controls;

	/**
	 * Global Controls.
	 *
	 * @var Array
	 */
	private $css_js_controls;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->add_layer_controls();

		$this->add_global_controls();

		$this->add_css_js_controls();

	}

	/**
	 * Add Layer Controls
	 *
	 * @return void
	 */
	private function add_layer_controls() {

		$layer_controls = array();

		$layer_controls['layer_type'] = array(
			'name'     => esc_html__( 'Layer Type', 'wp-configurator-pro' ),
			'settings' => array(

				/*
				'id1' => array(
					'name'         => esc_html__( 'Fancy Select', 'wp-configurator-pro' ),
					'desc'         => esc_html__( 'Fancy Select Description', 'wp-configurator-pro' ),
					'default'      => '',
					'options' => array(
						'' => esc_attr__( 'Choose', 'wp-configurator-pro' ),
						'option1' => esc_attr__( 'Option 1', 'wp-configurator-pro' ),
						'option2' => esc_attr__( 'Option 2', 'wp-configurator-pro' ),
						'option3' => esc_attr__( 'Option 3', 'wp-configurator-pro' ),
						'option4' => esc_attr__( 'Option 4', 'wp-configurator-pro' ),
					),
					'type'         => 'fancy-select', // text, select, checkbox, media.
					'support_view' => false, // ignore this if not needed.
					'separator'    => false,
				),
				*/

				'layer-type' => array(
					'name'       => esc_html__( 'Layer Type', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'You can switch layer type', 'wp-configurator-pro' ),
					'default'    => '',
					'type'       => 'layer-type', // text, select, checkbox, media.
					'separator'  => false,
					'conditions' => array( 'layerType', 'group', '!=' ),
				),

				'image'      => array(
					'name'         => esc_html__( 'Product Image', 'wp-configurator-pro' ),
					'desc'         => esc_html__( 'Choose product images for views', 'wp-configurator-pro' ),
					'default'      => '',
					'type'         => 'media', // text, select, checkbox, media.
					'support_view' => true, // ignore this if not needed.

					/*
					'conditions' => array(
						array (
							'id' => 'layerType',
							'value' => 'group',
							'operator' => '!='
						),
						array (
							'id' => 'layerType',
							'value' => 'group',
							'operator' => '!='
						)
					),
					'conditions' => array(
						'relation' => 'or',
						'term'=> array(
							array (
								'id' => 'layerType',
								'value' => 'group',
								'operator' => '!='
							),
							array (
								'id' => 'layerType',
								'value' => 'group',
								'operator' => '!='
							)
						)
					),
					'conditions' => array(
						'relation' => 'and',
						'term'=> array(
							array( 'layerType', 'group', '==' ),
							array( 'layerType', 'group', '==' )
						)
					),
					*/
					'conditions'   => array( 'layerType', 'image', '==' ),

				),

			),
		);

		$layer_controls['controls'] = array(
			'name'     => esc_html__( 'Control Settings', 'wp-configurator-pro' ),
			'settings' => array(
				'control_type' => array(
					'name'       => esc_html__( 'Control Type', 'wp-configurator-pro' ),
					'default'    => 'icon',
					'options'    => array(
						'color'       => esc_attr__( 'Color', 'wp-configurator-pro' ),
						'label'       => esc_attr__( 'Label', 'wp-configurator-pro' ),
						'inline_text' => esc_attr__( 'Inline Text', 'wp-configurator-pro' ),
						'icon'        => esc_attr__( 'Icon', 'wp-configurator-pro' ),
					),
					'type'       => 'fancy-select',
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_control_type',
						array(
							'relation' => 'or',
							'term'     => array(
								array( 'layerType', 'group', '==' ),
								array( 'layerType', 'sub_group', '==' ),
								array( 'layerType', 'image', '==' ),
							),
						)
					),
				),
				'color'        => array(
					'name'       => esc_html__( 'Color', 'wp-configurator-pro' ),
					'default'    => '',
					'type'       => 'color',
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_color',
						array(
							'relation' => 'and',
							'term'     => array(
								array( 'control_type', 'inline_text', '!=' ),
								array( 'control_type', 'icon', '!=' ),
							),
						)
					),
				),
				'icon'         => array(
					'name'       => esc_html__( 'Control Icon', 'wp-configurator-pro' ),
					'default'    => '',
					'type'       => 'media',
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_icon',
						array(
							'relation' => 'and',
							'term'     => array(
								array( 'control_type', 'inline_text', '!=' ),
								array( 'control_type', 'color', '!=' ),
							),
						)
					),
				),
				'label'        => array(
					'name'       => esc_html__( 'Label', 'wp-configurator-pro' ),
					'default'    => '',
					'type'       => 'text',
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_label',
						array(
							'relation' => 'or',
							'term'     => array(
								array( 'control_type', 'label', '==' ),
								array( 'control_type', 'inline_text', '==' ),
							),
						)
					),
				),
				'info_image'   => array(
					'name'       => esc_html__( 'Info Image', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Please choose the image for information.', 'wp-configurator-pro' ),
					'type'       => 'media',
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_info_image',
						array(
							'relation' => 'and',
							'term'     => array(
								array( 'layerType', 'group', '!=' ),
								array( 'layerType', 'sub_group', '!=' ),
							),
						)
					),
				),
				'tags'         => array(
					'name'       => esc_html__( 'Tags', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Please type the tags.', 'wp-configurator-pro' ),
					'type'       => 'multi-text',
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_tags',
						array(
							'relation' => 'and',
							'term'     => array(
								array( 'layerType', 'group', '!=' ),
							),
						)
					),
				),
			),
		);

		$layer_controls['others'] = array(
			'name'     => esc_html__( 'Other Settings', 'wp-configurator-pro' ),
			'settings' => array(

				'group_initial_state' => array(
					'name'       => esc_html__( 'Initial State', 'wp-configurator-pro' ),
					'options'    => apply_filters(
						'wpc_editor_layer_control_options_group_initial_state',
						array(
							''           => esc_html__( 'Choose Initial State', 'wp-configurator-pro' ),
							'open'       => esc_html__( 'Open', 'wp-configurator-pro' ),
							'deactivate' => esc_html__( 'Deactivate', 'wp-configurator-pro' ),
						)
					),
					'default'    => '',
					'type'       => 'select',
					'conditions' => array(
						'relation' => 'or',
						'term'     => array(
							array( 'layerType', 'group', '==' ),
							array( 'layerType', 'sub_group', '==' ),
						),
					),
				),

				'layer_initial_state' => array(
					'name'       => esc_html__( 'Initial State', 'wp-configurator-pro' ),
					'options'    => apply_filters(
						'wpc_editor_layer_control_options_layer_initial_state',
						array(
							''           => esc_html__( 'Choose Initial State', 'wp-configurator-pro' ),
							'deactivate' => esc_html__( 'Deactivate', 'wp-configurator-pro' ),
						)
					),
					'default'    => '',
					'type'       => 'select',
					'conditions' => array(
						'relation' => 'and',
						'term'     => array(
							array( 'layerType', 'group', '!=' ),
							array( 'layerType', 'sub_group', '!=' ),
						),
					),
				),

				'price'               => array(
					'name'       => esc_html__( 'Regular Price', 'wp-configurator-pro' ),
					'default'    => '',
					'type'       => 'text',
					'class'      => esc_attr( 'wpc-input-mini' ),
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_price',
						array(
							'relation' => 'and',
							'term'     => array(
								array( 'layerType', 'group', '!=' ),
								array( 'layerType', 'sub_group', '!=' ),
							),
						)
					),
				),

				'sale_price'          => array(
					'name'       => esc_html__( 'Sale Price', 'wp-configurator-pro' ),
					'default'    => '',
					'type'       => 'text',
					'class'      => esc_attr( 'wpc-input-mini' ),
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_sale_price',
						array(
							'relation' => 'and',
							'term'     => array(
								array( 'layerType', 'group', '!=' ),
								array( 'layerType', 'sub_group', '!=' ),
							),
						)
					),
				),

				'description'         => array(
					'name'       => esc_html__( 'Description', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Enter Short Description', 'wp-configurator-pro' ),
					'default'    => '',
					'type'       => 'textarea',
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_description',
						array(
							'relation' => 'or',
							'term'     => array(
								array( 'layerType', 'group', '==' ),
								array( 'layerType', 'sub_group', '==' ),
							),
						)
					),
				),

				'required'            => array(
					'name'       => esc_html__( 'Required', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Is this required?', 'wp-configurator-pro' ),
					'default'    => false,
					'type'       => 'checkbox',
					'conditions' => array(
						'relation' => 'or',
						'term'     => array(
							array( 'layerType', 'group', '==' ),
							array( 'layerType', 'sub_group', '==' ),
						),
					),
				),

				'multiple'            => array(
					'name'       => esc_html__( 'Multiple', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Allow multiple selection?', 'wp-configurator-pro' ),
					'default'    => false,
					'type'       => 'checkbox',
					'conditions' => array(
						'relation' => 'or',
						'term'     => array(
							array( 'layerType', 'group', '==' ),
							array( 'layerType', 'sub_group', '==' ),
						),
					),
				),

				'active'              => array(
					'name'       => esc_html__( 'Active', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Active on load?', 'wp-configurator-pro' ),
					'default'    => false,
					'type'       => 'checkbox',
					'conditions' => apply_filters(
						'wpc_editor_layer_control_conditions_active',
						array(
							'relation' => 'and',
							'term'     => array(
								array( 'layerType', 'group', '!=' ),
								array( 'layerType', 'sub_group', '!=' ),
							),
						)
					),
				),

				'hide_control'        => array(
					'name'       => esc_html__( 'Hide Control', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Hide this and child layers in controls', 'wp-configurator-pro' ),
					'default'    => false,
					'type'       => 'checkbox',
					'conditions' => apply_filters( 'wpc_editor_layer_control_conditions_hide_control', array() ),
				),

				'switch_view'         => array(
					'name'       => esc_html__( 'Switch View', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Switch to selected view when user click this control', 'wp-configurator-pro' ),
					'type'       => 'view',
					'conditions' => array(
						'relation' => 'or',
						'term'     => array(
							array( 'layerType', 'group', '==' ),
							array( 'layerType', 'sub_group', '==' ),
						),
					),
				),

				'deselect_child'      => array(
					'name'       => esc_html__( 'Deselect Child', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Remove all siblings active layers in this group', 'wp-configurator-pro' ),
					'default'    => false,
					'type'       => 'checkbox',
					'conditions' => array(
						'term' => array(
							array( 'layerType', 'sub_group', '==' ),
						),
					),
				),

				'deselect_type'       => array(
					'name'       => esc_html__( 'Deselect Type', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'what are the active controls be deselect?', 'wp-configurator-pro' ),
					'options'    => array(
						''                       => esc_html__( 'Select Deselect Type', 'wp-configurator-pro' ),
						'siblings'               => esc_html__( 'Only Siblings', 'wp-configurator-pro' ),
						'siblings_with_children' => esc_html__( 'Siblings with Children', 'wp-configurator-pro' ),
						'everything'             => esc_html__( 'Everything', 'wp-configurator-pro' ),
					),
					'default'    => '',
					'type'       => 'select',
					'conditions' => array( 'deselect_child', true ),
				),

				'custom_class'   => array(
					'name'       => esc_html__( 'Custom Class', 'wp-configurator-pro' ),
					'desc'       => esc_html__( 'Enter the custom class.', 'wp-configurator-pro' ),
					'default'    => '',
					'type'       => 'text',
				),
			),
		);

		$this->layer_controls = $layer_controls;

	}

	/**
	 * Add global controls
	 *
	 * @return void
	 */
	private function add_global_controls() {

		$global_controls = array();

		$global_controls['global'] = array(
			'name'     => esc_html__( 'Global Settings', 'wp-configurator-pro' ),
			'settings' => array(
				'_wpc_product_id'                    => array(
					'name'     => esc_html__( 'Choose Product', 'wp-configurator-pro' ),
					'desc'     => esc_html__( 'If you dont select any product, Single configurator page loads.', 'wp-configurator-pro' ),
					'type'     => 'select',
					'options'  => WPC_Utils::get_products(),
					'sort'     => 'alphabetical',
					'disabled' => true,
				),
				'_wpc_config_style'                    => array(
					'name'             => esc_html__( 'Choose Style', 'wp-configurator-pro' ),
					'desc'             => esc_html__( 'Please choose the control style.', 'wp-configurator-pro' ),
					'type'             => 'select',
					'options'          => WPC_Utils::get_styles(),
					'disabled_options' => array(
						'style1',
						'style2',
						'style3',
						'accordion-2',
						'popover',
					),
				),
				'_wpc_responsible_view_cart_thumbnail' => array(
					'name' => esc_html__( 'Responsible View Cart Thumbnail', 'wp-configurator-pro' ),
					'desc' => esc_html__( 'Choose the responsible view for cart thumbnail.', 'wp-configurator-pro' ),
					'type' => 'view',
				),
				'_wpc_form'                            => array(
					'name'             => esc_html__( 'Choose Form', 'wp-configurator-pro' ),
					'desc'             => esc_html__( 'You chose the `Cart Form` and you dont select any product, Quote Form applies automatically.', 'wp-configurator-pro' ),
					'type'             => 'select',
					'options'          => WPC_Utils::get_forms(),
					'disabled_options' => array(
						'cart-form',
						'contact-form',
					),
				),
				'_wpc_contact_form'                    => array(
					'name'     => esc_html__( 'Contact Form', 'wp-configurator-pro' ),
					'desc'     => esc_html__( 'Please choose the contact form', 'wp-configurator-pro' ),
					'type'     => 'select',
					'options'  => WPC_Utils::get_contact_forms(),
					'disabled' => true,
				),
				'_wpc_base_price'                      => array(
					'name' => esc_html__( 'Base Price', 'wp-configurator-pro' ),
					'desc' => esc_html__( 'Product base price', 'wp-configurator-pro' ),
					'type' => 'text',
				),
				'_wpc_load_configurator_in'            => array(
					'name'     => esc_html__( 'Load Configurator in', 'wp-configurator-pro' ),
					'desc'     => esc_html__( 'Once Configure is clicked! is selected, `Configure it` button added in single product page.', 'wp-configurator-pro' ),
					'type'     => 'select',
					'options'  => array(
						'direct'        => esc_html__( 'Directly in Product Page', 'wp-configurator-pro' ),
						'configure_btn' => esc_html__( 'Once Configure is clicked!', 'wp-configurator-pro' ),
					),
					'disabled' => true,
				),
				'_wpc_configurator_template'           => array(
					'name'     => esc_html__( 'Configurator Template', 'wp-configurator-pro' ),
					'desc'     => esc_html__( '`Override Product Detail as Configurator` is selected, It replaces the product gallery and summary details as `Configurator`.', 'wp-configurator-pro' ),
					'type'     => 'select',
					'options'  => array(
						'entire_product_page' => esc_html__( 'Replace Entire Product Page', 'wp-configurator-pro' ),
						'summary_area'        => esc_html__( 'Override Product Detail as Configurator', 'wp-configurator-pro' ),
					),
					'disabled' => true,
				),
				'_wpc_description'                     => array(
					'name' => esc_html__( 'Description', 'wp-configurator-pro' ),
					'desc' => esc_html__( 'Enter Short Description', 'wp-configurator-pro' ),
					'type' => 'textarea',
				),
				'_wpc_view_background'                 => array(
					'name'         => esc_html__( 'View Background', 'wp-configurator-pro' ),
					'desc'         => esc_html__( 'Choose the view background', 'wp-configurator-pro' ),
					'type'         => 'media',
					'support_view' => true,
				),
				'_wpc_show_details_page'               => array(
					'name'     => esc_html__( 'Show Details Page', 'wp-configurator-pro' ),
					'desc'     => esc_html__( 'Please choose the detail page( Note: it wont load the theme style, you need to style by yourself ). If you dont set anything it loads the products details by default.', 'wp-configurator-pro' ),
					'type'     => 'select',
					'options'  => WPC_Utils::get_pages(),
					'disabled' => true,
				),
			),
		);

		$this->global_controls = $global_controls;

	}



	/**
	 * Add global controls
	 *
	 * @return void
	 */
	private function add_css_js_controls() {

		$css_js_controls = array();

		$id = isset( $_GET['post'] ) ? $_GET['post'] : 0;

		$custom_css = WPC_Utils::get_meta_value( $id, '_wpc_custom_css', '' );
		$custom_js  = WPC_Utils::get_meta_value( $id, '_wpc_custom_js', '' );

		$css_js_controls['custom_css'] = array(
			'name'     => esc_html__( 'Custom CSS(Pro)', 'wp-configurator-pro' ),
			'settings' => array(
				'_wpc_custom_css' => array(
					'name'     => esc_html__( 'Custom CSS', 'wp-configurator-pro' ),
					'desc'     => esc_html__( 'Please type CSS.', 'wp-configurator-pro' ),
					'mod'      => 'large',
					'type'     => 'textarea',
					'default'  => $custom_css,
					'disabled' => true,
				),
			),
		);

		$css_js_controls['custom_js'] = array(
			'name'     => esc_html__( 'Custom JS(Pro)', 'wp-configurator-pro' ),
			'settings' => array(
				'_wpc_custom_js' => array(
					'name'     => esc_html__( 'Custom JS', 'wp-configurator-pro' ),
					'desc'     => esc_html__( 'Please type scripts.', 'wp-configurator-pro' ),
					'mod'      => 'large',
					'type'     => 'textarea',
					'default'  => $custom_js,
					'disabled' => true,
				),
			),
		);

		$this->css_js_controls = $css_js_controls;

	}

	/**
	 * Get Control
	 *
	 * @param String $control_key
	 * @return Array controls
	 */
	public function get_controls( $control_key ) {
		$control_key = $control_key . '_controls';
		return $this->$control_key;
	}

}

// new WPC_Editor_Register_Controls();
