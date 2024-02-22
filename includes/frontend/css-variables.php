<?php
/**
 * CSS Variables.
 *
 * @package  wp-configurator-pro/includes/frontend/
 * @since  2.0
 * @version  3.4.2
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$css['body-bg']                                = WPC_utils::get_option( 'wpc_body_bg', '#fff' );
$css['title-color']                            = WPC_utils::get_option( 'wpc_title_color', '#28303d' );
$css['content-color']                          = WPC_utils::get_option( 'wpc_content_color', '#39414d' );
$css['link-color']                             = WPC_utils::get_option( 'wpc_link_color', '#28303d' );
$css['link-hover-color']                       = WPC_utils::get_option( 'wpc_link_hover_color', '#39414d' );
$css['primary-btn-bg']                         = WPC_utils::get_option( 'wpc_primary_btn_bg', '#28303d' );
$css['primary-btn-color']                      = WPC_utils::get_option( 'wpc_primary_btn_color', '#fff' );
$css['primary-btn-border-color']               = WPC_utils::get_option( 'wpc_primary_btn_border_color', 'transparent' );
$css['primary-btn-hover-bg']                   = WPC_utils::get_option( 'wpc_primary_btn_hover_bg', '#28303d' );
$css['primary-btn-hover-color']                = WPC_utils::get_option( 'wpc_primary_btn_hover_color', '#fff' );
$css['secondary-btn-bg']                       = WPC_utils::get_option( 'wpc_secondary_btn_bg', '#312e36' );
$css['secondary-btn-color']                    = WPC_utils::get_option( 'wpc_secondary_btn_color', '#fff' );
$css['secondary-btn-border-color']             = WPC_utils::get_option( 'wpc_secondary_btn_border_color', 'transparent' );
$css['secondary-btn-hover-bg']                 = WPC_utils::get_option( 'wpc_secondary_btn_hover_bg', '#312e36' );
$css['secondary-btn-hover-color']              = WPC_utils::get_option( 'wpc_secondary_btn_hover_color', '#fff' );
$css['label-color']                            = WPC_utils::get_option( 'wpc_form_label_color', '#28303d' );
$css['placeholder-color']                      = WPC_utils::get_option( 'wpc_form_placeholder_color', '#28303d' );
$css['input-color']                            = WPC_utils::get_option( 'wpc_form_input_color', '#808080' );
$css['input-bg']                               = WPC_utils::get_option( 'wpc_form_input_bg', '#fff' );
$css['input-border-color']                     = WPC_utils::get_option( 'wpc_form_input_border_color', '#e6e6e6' );
$css['floating-icon-color']                    = WPC_utils::get_option( 'wpc_floating_icon_color', '#39414d' );
$css['floating-icon-hover-color']              = WPC_utils::get_option( 'wpc_floating_icon_hover_color', '#39414d' );
$css['preview-slider-nav-color']               = WPC_utils::get_option( 'wpc_preview_slider_nav_color', '#ababaf' );
$css['preview-slider-nav-bg']                  = WPC_utils::get_option( 'wpc_preview_slider_nav_bg', '#0a0a1a' );
$css['preview-slider-nav-hover-color']         = WPC_utils::get_option( 'wpc_preview_slider_nav_hover_color', '#ababaf' );
$css['preview-slider-nav-hover-bg']            = WPC_utils::get_option( 'wpc_preview_slider_nav_hover_bg', '#0a0a1a' );
$css['preview-slider-nav-active-color']        = WPC_utils::get_option( 'wpc_preview_slider_nav_active_color', '#fff' );
$css['preview-slider-nav-active-bg']           = WPC_utils::get_option( 'wpc_preview_slider_nav_active_bg', '#00f1ff' );
$css['hotspot-bg']                             = WPC_utils::get_option( 'wpc_hotspot_bg', '#fff' );
$css['hotspot-color']                          = WPC_utils::get_option( 'wpc_hotspot_color', '#28303d' );
$css['hotspot-tooltip-bg']                     = WPC_utils::get_option( 'wpc_hotspot_tooltip_bg', '#fff' );
$css['hotspot-tooltip-box-shadow']             = WPC_utils::get_option( 'wpc_hotspot_tooltip_box_shadow', '#00000029' );
$css['hotspot-tooltip-title-color']            = WPC_utils::get_option( 'wpc_hotspot_tooltip_title_color', '#28303d' );
$css['hotspot-tooltip-description-color']      = WPC_utils::get_option( 'wpc_hotspot_tooltip_description_color', '#39414d' );
$css['floating-popup-bg']                      = WPC_utils::get_option( 'wpc_floating_popup_bg', '#fff' );
$css['partial-popup-bg']                       = WPC_utils::get_option( 'wpc_partial_popup_bg', '#fff' );
$css['full-popup-bg']                          = WPC_utils::get_option( 'wpc_full_popup_bg', '#fff' );
$css['center-overflow-popup-bg']               = WPC_utils::get_option( 'wpc_center_overflow_popup_bg', '#fff' );
$css['popup-close-icon-color']                 = WPC_utils::get_option( 'wpc_popup_close_icon_color', '#fff' );
$css['popup-close-icon-bg']                    = WPC_utils::get_option( 'wpc_popup_close_icon_bg', '#312e36' );
$css['flyin-bg']                               = WPC_utils::get_option( 'wpc_flyin_bg', '#fff' );
$css['flyin-close-icon-color']                 = WPC_utils::get_option( 'wpc_flyin_close_icon_color', '#fff' );
$css['flyin-close-icon-bg']                    = WPC_utils::get_option( 'wpc_flyin_close_icon_bg', '#28303d' );
$css['share-icon-dimension']                   = WPC_utils::get_option( 'wpc_share_icon_dimension', '50' );
$css['share-icon-line-height']                 = WPC_utils::get_option( 'wpc_share_icon_line_height', '56' );
$css['share-icon-border-radius']               = WPC_utils::get_option( 'wpc_share_icon_border_radius', '50' );
$css['share-icon-spacing']                     = WPC_utils::get_option( 'wpc_share_icon_spacing', '10' );
$css['share-label-color']                      = WPC_utils::get_option( 'wpc_share_label_color', '#39414d' );
$css['facebook-color']                         = WPC_utils::get_option( 'wpc_facebook_color', '#fff' );
$css['facebook-bg']                            = WPC_utils::get_option( 'wpc_facebook_bg', '#347cba' );
$css['twitter-color']                          = WPC_utils::get_option( 'wpc_twitter_color', '#fff' );
$css['twitter-bg']                             = WPC_utils::get_option( 'wpc_twitter_bg', '#1ebcd0' );
$css['linkedin-color']                         = WPC_utils::get_option( 'wpc_linkedin_color', '#fff' );
$css['linkedin-bg']                            = WPC_utils::get_option( 'wpc_linkedin_bg', '#108ac6' );
$css['pinterest-color']                        = WPC_utils::get_option( 'wpc_pinterest_color', '#fff' );
$css['pinterest-bg']                           = WPC_utils::get_option( 'wpc_pinterest_bg', '#d32f1e' );
$css['reddit-color']                           = WPC_utils::get_option( 'wpc_reddit_color', '#fff' );
$css['reddit-bg']                              = WPC_utils::get_option( 'wpc_reddit_bg', '#FF5700' );
$css['copy-link-color']                        = WPC_utils::get_option( 'wpc_copy_link_color', '#fff' );
$css['copy-link-bg']                           = WPC_utils::get_option( 'wpc_copy_link_bg', '#7dc03a' );
$css['inspiration-main-title-color']           = WPC_utils::get_option( 'wpc_inspiration_main_title_color', '#28303d' );
$css['inspiration-tab-menu-bg']                = WPC_utils::get_option( 'wpc_inspiration_tab_menu_bg', '#f2f2f2' );
$css['inspiration-tab-menu-color']             = WPC_utils::get_option( 'wpc_inspiration_tab_menu_color', '#28303d' );
$css['inspiration-tab-menu-hover-bg']          = WPC_utils::get_option( 'wpc_inspiration_tab_menu_hover_bg', '#f2f2f2' );
$css['inspiration-tab-menu-hover-color']       = WPC_utils::get_option( 'wpc_inspiration_tab_menu_hover_color', '#28303d' );
$css['inspiration-tab-menu-active-bg']         = WPC_utils::get_option( 'wpc_inspiration_tab_menu_active_bg', '#666' );
$css['inspiration-tab-menu-active-color']      = WPC_utils::get_option( 'wpc_inspiration_tab_menu_active_color', '#fff' );
$css['inspiration-list-title-color']           = WPC_utils::get_option( 'wpc_inspiration_list_title_color', '#28303d' );
$css['inspiration-list-desc-color']            = WPC_utils::get_option( 'wpc_inspiration_list_desc_color', '#39414d' );
$css['inspiration-list-price-color']           = WPC_utils::get_option( 'wpc_inspiration_list_price_color', '#39414d' );
$css['inspiration-admin-icon-color']           = WPC_utils::get_option( 'wpc_inspiration_admin_icon_color', '#312e36' );
$css['inspiration-admin-icon-bg']              = WPC_utils::get_option( 'wpc_inspiration_admin_icon_bg', '#f1f1f1' );
$css['summary-title-color']                    = WPC_utils::get_option( 'wpc_summary_title_color', '#28303d' );
$css['summary-list-title-color']               = WPC_utils::get_option( 'wpc_summary_list_title_color', '#28303d' );
$css['summary-child-list-color']               = WPC_utils::get_option( 'wpc_summary_child_list_color', '#312e36' );
$css['summary-child-list-separator-color']     = WPC_utils::get_option( 'wpc_summary_child_list_separator_color', '#a2a2a2' );
$css['summary-price-color']                    = WPC_utils::get_option( 'wpc_summary_price_color', '#989898' );
$css['summary-border-color']                   = WPC_utils::get_option( 'wpc_summary_border_color', '#cccccc' );
$css['summary-total-title-color']              = WPC_utils::get_option( 'wpc_summary_total_title_color', '#28303d' );
$css['summary-total-price-color']              = WPC_utils::get_option( 'wpc_summary_total_price_color', '#28303d' );
$css['total-price-title-color']                = WPC_utils::get_option( 'wpc_total_price_title_color', '#28303d' );
$css['total-price-color']                      = WPC_utils::get_option( 'wpc_total_price_color', '#28303d' );
$css['get-quote-title-color']                  = WPC_utils::get_option( 'wpc_get_quote_title_color', '#28303d' );
$css['controls-group-title-color']             = WPC_utils::get_option( 'wpc_controls_group_title_color', '#28303d' );
$css['controls-sub-group-title-color']         = WPC_utils::get_option( 'wpc_controls_sub_group_title_color', '#28303d' );
$css['control-title-bg']                       = WPC_utils::get_option( 'wpc_control_title_bg', '#eee' );
$css['active-control-title-bg']                = WPC_utils::get_option( 'wpc_active_control_title_bg', '#d2d2d2' );
$css['controls-group-desc-color']              = WPC_utils::get_option( 'wpc_controls_group_desc_color', '#39414d' );
$css['controls-sub-group-desc-color']          = WPC_utils::get_option( 'wpc_controls_sub_group_desc_color', '#39414d' );
$css['controls-label-color']                   = WPC_utils::get_option( 'wpc_controls_label_color', '#39414d' );
$css['controls-border-color']                  = WPC_utils::get_option( 'wpc_controls_border_color', '#fff' );
$css['active-controls-border-color']           = WPC_utils::get_option( 'wpc_active_controls_border_color', '#999' );
$css['active-controls-box-shadow-color']       = WPC_utils::get_option( 'wpc_active_controls_box_shadow_color', '#9a9a9a' );
$css['control-lists-bg']                       = WPC_utils::get_option( 'wpc_control_lists_bg', '#fff' );
$css['controls-tooltip-bg']                    = WPC_utils::get_option( 'wpc_controls_tooltip_bg', '#fff' );
$css['controls-tooltip-color']                 = WPC_utils::get_option( 'wpc_controls_tooltip_color', '#39414d' );
$css['control-toggle-icon-color']              = WPC_utils::get_option( 'wpc_control_toggle_icon_color', '#39414d' );
$css['control-separator-color']                = WPC_utils::get_option( 'wpc_control_separator_color', '#e8e3e3' );
$css['popover-control-header-bg']              = WPC_utils::get_option( 'wpc_popover_control_header_bg', '#eeeeee' );
$css['popover-control-header-back-icon-color'] = WPC_utils::get_option( 'wpc_popover_control_header_back_icon_color', '#28303d' );
$css['popover-control-footer-bg']              = WPC_utils::get_option( 'wpc_popover_control_footer_bg', '#eeeeee' );
$css['popover-cancel-btn-bg']                  = WPC_utils::get_option( 'wpc_popover_cancel_btn_bg', '#312e36' );
$css['popover-cancel-btn-color']               = WPC_utils::get_option( 'wpc_popover_cancel_btn_color', '#fff' );
$css['header-background-color']                = WPC_utils::get_option( 'wpc_header_background_color', 'transparent' );
$css['header-element-price-color']             = WPC_utils::get_option( 'wpc_header_element_price_color', '#28303d' );
$css['header-element-icon-color']              = WPC_utils::get_option( 'wpc_header_element_icon_color', '#312e36' );
$css['header-element-icon-bg']                 = WPC_utils::get_option( 'wpc_header_element_icon_bg', '#f1f1f1' );
$css['header-menu-color']                      = WPC_utils::get_option( 'wpc_header_menu_color', '#222' );
$css['sub-menu-bg']                            = WPC_utils::get_option( 'wpc_sub_menu_bg', '#fff' );
$css['sub-menu-wrapper-border-color']          = WPC_utils::get_option( 'wpc_sub_menu_wrapper_border_color', '#f2f2f2' );
$css['sub-menu-wrapper-boxshadow-color']       = WPC_utils::get_option( 'wpc_sub_menu_wrapper_boxshadow_color', '#f2f2f2' );
$css['moblie-menu-color']                      = WPC_utils::get_option( 'wpc_moblie_menu_color', '#ababaf' );
$css['moblie-menu-trigger-color']              = WPC_utils::get_option( 'wpc_moblie_menu_trigger_color', '#39414d' );
$css['moblie-menu-border-color']               = WPC_utils::get_option( 'wpc_moblie_menu_border_color', 'rgba(215, 215, 236, 0.2)' );
$css['description-tooltip-icon-color']         = WPC_utils::get_option( 'wpc_description_tooltip_icon_color', '#39414d' );
$css['description-tooltip-bg']                 = WPC_utils::get_option( 'wpc_description_tooltip_bg', '#fff' );
$css['description-tooltip-box-shadow']         = WPC_utils::get_option( 'wpc_description_tooltip_box_shadow', 'rgb(0 0 0 / 20%)' );
$css['description-tooltip-color']              = WPC_utils::get_option( 'wpc_description_tooltip_color', '#28303d' );

$css['primary-font']   = WPC_utils::get_option( 'wpc_primary_font', 'inherit' );
$css['secondary-font'] = WPC_utils::get_option( 'wpc_secondary_font', 'inherit' );

if ( WPC_Utils::is_full_window_style() ) {
	$css['primary-font']   = ( 'inherit' === $css['primary-font'] ) || empty( $css['primary-font'] ) ? 'Nunito' : $css['primary-font'];
	$css['secondary-font'] = ( 'inherit' === $css['secondary-font'] ) || empty( $css['secondary-font'] ) ? 'Nunito' : $css['secondary-font'];
}

$css['icon-width']            = (int) WPC_utils::get_option( 'wpc_icon_width', '20' );
$css['icon-height']           = (int) WPC_utils::get_option( 'wpc_icon_height', '20' );
$css['popover-icon-width']    = (int) WPC_utils::get_option( 'wpc_popover_icon_width', '40' );
$css['popover-icon-height']   = (int) WPC_utils::get_option( 'wpc_popover_icon_height', '40' );
$css['group-icon-width']      = (int) WPC_utils::get_option( 'wpc_group_icon_width', '40' );
$css['group-icon-height']     = (int) WPC_utils::get_option( 'wpc_group_icon_height', '40' );
$css['sub-group-icon-width']  = (int) WPC_utils::get_option( 'wpc_sub_group_icon_width', '20' );
$css['sub-group-icon-height'] = (int) WPC_utils::get_option( 'wpc_sub_group_icon_height', '20' );

$css['icon-width']  = apply_filters( 'wpc_control_item_icon_width', $css['icon-width'] );
$css['icon-height'] = apply_filters( 'wpc_control_item_icon_height', $css['icon-height'] );

$styles = WPC_Utils::get_styles();

foreach ( $styles as $style => $value ) {
	$css['popover-icon-width']  = ( 'popover' === $style ) ? $css['popover-icon-width'] : $css['icon-width'];
	$css['popover-icon-height'] = ( 'popover' === $style ) ? $css['popover-icon-height'] : $css['icon-height'];

	if ( has_filter( 'wpc_' . $style . '_control_item_icon_width' ) ) {
		$css[ $style . '-icon-width' ] = apply_filters( 'wpc_' . $style . '_control_item_icon_width', $css['icon-width'] );
	}

	if ( has_filter( 'wpc_' . $style . '_control_item_icon_height' ) ) {
		$css[ $style . '-icon-height' ] = apply_filters( 'wpc_' . $style . '_control_item_icon_height', $css['icon-height'] );
	}

	if ( has_filter( 'wpc_' . $style . '_group_icon_width' ) ) {
		$css[ $style . '-group-icon-width' ] = apply_filters( 'wpc_' . $style . '_group_icon_width', $css['group-icon-width'] );
	}

	if ( has_filter( 'wpc_' . $style . '_group_icon_height' ) ) {
		$css[ $style . '-group-icon-height' ] = apply_filters( 'wpc_' . $style . '_group_icon_height', $css['group-icon-height'] );
	}

	if ( has_filter( 'wpc_' . $style . '_sub_group_icon_width' ) ) {
		$css[ $style . '-sub-group-icon-width' ] = apply_filters( 'wpc_' . $style . '_sub_group_icon_width', $css['sub-group-icon-width'] );
	}

	if ( has_filter( 'wpc_' . $style . '_sub_group_icon_height' ) ) {
		$css[ $style . '-sub-group-icon-height' ] = apply_filters( 'wpc_' . $style . '_sub_group_icon_height', $css['sub-group-icon-height'] );
	}
}

/**
 * Filter: Modify CSS variables.
 *
 * * @since 3.4
 *
 * @param array   $css CSS values.
*/
$css = apply_filters( 'wpc_css_variables', $css );

$root = array();

foreach ( $css as $key => $value ) {
	$value = is_numeric( $value ) ? $value . 'px' : $value;

	$root[] = '--wpc-' . $key . ': ' . esc_html( $value ) . ';';
}

echo ':root {' . implode( ' ', $root ) . '}'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped



