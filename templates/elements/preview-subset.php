<?php
/**
 * Subset template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.4
 * @version  3.4.11
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( apply_filters( 'wpc_allow_preview_element', false, $uid, $view, $wpc ) ) {

	$config_data = $wpc->config[ $wpc->id ];

	$layer_type = $config_data->get_type( $uid );

	$layer_settings = $config_data->get_layer_settings( $uid );

	$parent_uid = $config_data->get_parent_uid( $uid );

	$class['subset']     = 'subset';
	$class['layer-type'] = esc_attr( 'wpc-' . $layer_type . '-layer' );

	if ( ! isset( $layer_settings['layer_initial_state'] ) || WPC_Utils::str_to_bool( $layer_settings['layer_initial_state'] ) ) {
		$class['active'] = 'active';
	}

	if ( isset( $layer_settings['hide_control'] ) && WPC_Utils::str_to_bool( $layer_settings['hide_control'] ) ) {
		$class['always-show'] = 'wpc-always-show';
	}

	$class = apply_filters( 'wpc_subset_classes', $class, $uid, $view, $wpc );

	$attr                    = array();
	$attr['class']           = 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
	$attr['data-uid']        = 'data-uid="' . esc_attr( $uid ) . '"';
	$attr['data-parent-uid'] = 'data-parent-uid="' . esc_attr( $parent_uid ) . '"';
	$attr['alpine:init']     = 'x-init="' . esc_attr( $wpc->store . '.initPreviewElement( "' . $uid . '", "' . $view . '" )' ) . '"';
	$attr['alpine:style']    = 'x-bind:style="' . esc_attr( $wpc->store . '.getPreviewElementStyle( "' . $uid . '", "' . $view . '" )' ) . '"';
	$attr['alpine:class']    = 'x-bind:class="' . esc_attr( $wpc->store . '.getSubsetClasses( "' . $uid . '" )' ) . '"';

	$attr = apply_filters( 'wpc_subset_attr', $attr, $uid, $view, $wpc );
	?>
	<div <?php echo implode( ' ', $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php
		/**
		 * Hook: Subset inner html.
		 *
		 * * @since 3.4
		 *
		 * @param string  $uid Layer uid.
		 * @param string  $view View.
		 * @param WPCSE   $wpc WPCSE Class.
		 */
		do_action( 'wpc_subset_inner_html', $uid, $view, $wpc );
		?>
	</div>
	<?php
}
