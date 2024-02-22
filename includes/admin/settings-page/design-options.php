<?php
/**
 * Design option setting page.
 *
 * @package  wp-configurator-pro/includes/admin/settings-page/
 * @since  2.0
 * @version  3.4.2
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$field = array();


/* General ------------------------------------------------------------------------  */

$general[] = array(
	'type'  => 'control-start',
	'class' => 'general',
);

$general[] = array(
	'title' => esc_html__( 'General', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Body Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_body_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Title Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_title_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Content Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_content_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Link Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_link_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Link Hover Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_link_hover_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'type' => 'control-end',
);


/* Button -------------------------------------------------------------------------  */

$general[] = array(
	'type'  => 'control-start',
	'class' => 'button-style',
);

$general[] = array(
	'title' => esc_html__( 'Button', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Primary Button Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_primary_btn_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Primary Button Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_primary_btn_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Primary Button Border Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_primary_btn_border_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Primary Button Hover Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_primary_btn_hover_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Primary Button Hover Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_primary_btn_hover_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Secondary Button Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_secondary_btn_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Secondary Button Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_secondary_btn_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Secondary Button Border Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_secondary_btn_border_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Secondary Button Hover Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_secondary_btn_hover_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Secondary Button Hover Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_secondary_btn_hover_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'type' => 'control-end',
);

/* Form Fields --------------------------------------------------------------------  */

$general[] = array(
	'type'  => 'control-start',
	'class' => 'form-fields',
);

$general[] = array(
	'title' => esc_html__( 'Form Fields', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Label Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_form_label_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Placeholder Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_form_placeholder_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Input Text Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_form_input_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Input Background Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_form_input_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Input Border Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_form_input_border_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'type' => 'control-end',
);

/* Preview Slider -----------------------------------------------------------------  */

$general[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$general[] = array(
	'title' => esc_html__( 'Preview Slider', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Nav Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_preview_slider_nav_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Nav Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_preview_slider_nav_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Nav Hover Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_preview_slider_nav_hover_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Nav Hover Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_preview_slider_nav_hover_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Nav Active Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_preview_slider_nav_active_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Nav Active Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_preview_slider_nav_active_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'type' => 'control-end',
);

/* Popup --------------------------------------------------------------------------  */

$general[] = array(
	'type'  => 'control-start',
	'class' => 'popup',
);

$general[] = array(
	'title' => esc_html__( 'Popup', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Floating Popup Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_floating_popup_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Partial Popup Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_partial_popup_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Full Popup Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_full_popup_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Center Overflow Popup Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_center_overflow_popup_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Close Icon Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_popup_close_icon_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Close Icon Bckground Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_popup_close_icon_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'type' => 'control-end',
);

/* Flyin --------------------------------------------------------------------------  */

$general[] = array(
	'type'  => 'control-start',
	'class' => 'popup',
);

$general[] = array(
	'title' => esc_html__( 'Flyin', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Flyin Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_flyin_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Close Icon Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_flyin_close_icon_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'title' => esc_html__( 'Close Icon Bckground Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_flyin_close_icon_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$general[] = array(
	'type' => 'control-end',
);


/* Summary ------------------------------------------------------------------------  */

$field[] = array(
	'type'  => 'control-start',
	'class' => 'form-fields',
);

$field[] = array(
	'title' => esc_html__( 'Summary', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title' => esc_html__( 'Summary Title ', 'wp-configurator-pro' ),
	'id'    => 'wpc_summary_title_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Summary List Title Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_summary_list_title_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Summary Child List Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_summary_child_list_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Summary Child List Separator Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_summary_child_list_separator_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Summary Price Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_summary_price_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Summary Border Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_summary_border_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Summary Total Title color  ', 'wp-configurator-pro' ),
	'id'    => 'wpc_summary_total_title_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Summary Total Price Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_summary_total_price_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'type' => 'control-end',
);


/* Total Price --------------------------------------------------------------------  */

$field[] = array(
	'type'  => 'control-start',
	'class' => 'cart-group',
);

$field[] = array(
	'title' => esc_html__( 'Total Price', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title' => esc_html__( 'Total Price Title Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_total_price_title_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Total Price Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_total_price_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'type' => 'control-end',
);

/* Get a Quote --------------------------------------------------------------------  */

$field[] = array(
	'type'  => 'control-start',
	'class' => 'cart-group',
);

$field[] = array(
	'title' => esc_html__( 'Get a Quote', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title' => esc_html__( 'Get a Quote Title Color ', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_title_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'type' => 'control-end',
);

/* Default Controls ---------------------------------------------------------------  */

$field[] = array(
	'type'  => 'control-start',
	'class' => 'controls',
);

$field[] = array(
	'title' => esc_html__( 'Default Controls', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title' => esc_html__( 'Group Title Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_controls_group_title_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Title Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_control_title_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Active Title Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_active_control_title_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Group Description Text color', 'wp-configurator-pro' ),
	'id'    => 'wpc_controls_group_desc_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Control Label color', 'wp-configurator-pro' ),
	'id'    => 'wpc_controls_label_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Control Border Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_controls_border_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Active Control Border Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_active_controls_border_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Active Control Shadow Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_active_controls_box_shadow_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Control lists Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_control_lists_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Controls Tooltip Background', 'wp-configurator-pro' ),
	'id'    => 'wpc_controls_tooltip_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Controls Tooltip Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_controls_tooltip_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Description Tooltip Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_description_tooltip_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Description Tooltip Box shadow', 'wp-configurator-pro' ),
	'id'    => 'wpc_description_tooltip_box_shadow',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Description Tooltip Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_description_tooltip_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Description Tooltip Icon Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_description_tooltip_icon_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Toggle Icon Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_control_toggle_icon_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Control Separator Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_control_separator_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'type' => 'control-end',
);

/* Header Elements ----------------------------------------------------------------  */

$field[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$field[] = array(
	'title' => esc_html__( 'Header Elements', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title' => esc_html__( 'Header Background color', 'wp-configurator-pro' ),
	'id'    => 'wpc_header_background_color',
	'std'   => '',
	'type'  => 'colorpicker',
);


$field[] = array(
	'title' => esc_html__( 'Price Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_header_element_price_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Icon Background color', 'wp-configurator-pro' ),
	'id'    => 'wpc_header_element_icon_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Icon Text color', 'wp-configurator-pro' ),
	'id'    => 'wpc_header_element_icon_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'type' => 'control-end',
);


/* Header Menu Elements ----------------------------------------------------------------  */

$field[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$field[] = array(
	'title' => esc_html__( 'Header Menu', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title' => esc_html__( 'Menu Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_header_menu_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Sub Menu Background Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_sub_menu_bg',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Sub Menu Wrapper Border Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_sub_menu_wrapper_border_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Sub Menu Background Box Shadow Color', 'wp-configurator-pro' ),
	'id'    => 'wpc_sub_menu_wrapper_boxshadow_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'type' => 'control-end',
);


/* Header Mobile Menu Elements ----------------------------------------------------------------  */

$field[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$field[] = array(
	'title' => esc_html__( 'Moblie Menu', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title' => esc_html__( 'Moblie Menu Trigger color', 'wp-configurator-pro' ),
	'id'    => 'wpc_moblie_menu_trigger_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Menu color', 'wp-configurator-pro' ),
	'id'    => 'wpc_moblie_menu_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'title' => esc_html__( 'Menu Border color', 'wp-configurator-pro' ),
	'id'    => 'wpc_moblie_menu_border_color',
	'std'   => '',
	'type'  => 'colorpicker',
);

$field[] = array(
	'type' => 'control-end',
);

?>

<div class="wrap">
	<?php
	$addons_lists = apply_filters( 'wpc_addons_allow_design_settings', array() );
	$addons_lists = array_merge(
		array(
			'general'             => esc_html__( 'General', 'wp-configurator-pro' ),
			'wp-configurator-pro' => esc_html__( 'WP Configurator Pro', 'wp-configurator-pro' ),
		),
		$addons_lists
	);

	$subtab = isset( $_GET['subtab'] ) ? $_GET['subtab'] : 'general';
	?>
	<ul class="subsubsub">
		<?php
		if ( ! empty( $addons_lists ) ) {
			foreach ( $addons_lists as $key => $addon ) {
				$current = ( $key == $subtab ) ? 'current' : '';
				?>
				<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=design-options&subtab=<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $current ); ?>"><?php echo esc_html( $addon ); ?></a></li>
				<?php
			}
		}
		?>
	</ul> <!-- .subsubsub -->
	<?php

	if ( 'general' === $subtab ) {
		$settings = new wpc_option_fields( $general );
	} elseif ( 'wp-configurator-pro' === $subtab ) {
		$settings = new wpc_option_fields( $field );
	} else {
		do_action( 'wpc_addons_' . $subtab . '_design_settings_fields' );
	}
	?>
</div>
