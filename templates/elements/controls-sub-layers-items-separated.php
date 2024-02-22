<?php
/**
 * Sub controls included template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.3
 * @version  3.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

$attr = wpc_sub_control_wrapper_attr( $parent_uid, $wpc );

$level = $wpc->layers[ $parent_uid ]['level'];

$open_parent_uid = $config_data->get_parent_uid( $parent_uid );

if ( ! $open_parent_uid ) {
	$open_parent_uid = $config_data->get_anchestor_id();
}

$sub_layers = '';

foreach ( $layer as $key => $sub_layer ) {

	$uid = isset( $sub_layer['uid'] ) ? $sub_layer['uid'] : '';

	$type = $config_data->get_type( $uid );

	if ( 'sub_group' === $type ) {
		if ( wpc_is_control_allowed( $sub_layer['uid'], $wpc ) ) {
			$sub_layers .= wp_kses( $wpc->get_control_item( $sub_layer, true ), WPC_Utils::allowed_tags() );
		}
	} else {
		$parent_uid = $config_data->get_parent_uid( $uid );

		if ( wpc_is_control_allowed( $sub_layer['uid'], $wpc ) ) {
			$wpc->control_items[ $parent_uid ][] = $sub_layer;
		}
	}
}

if ( $sub_layers ) {
	/**
	 * Hook: Before sub layer group.
	 *
	 * * @since 3.3
	 *
	 * @param string $parent_uid Parent layer uid.
	 * @param object $wpc WPCSE.
	 */
	do_action( 'wpc_before_sub_layer_group', $parent_uid, $wpc );
	?>

	<div <?php echo implode( ' ', $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<ul class="wpc-control-lists-inner" data-controls data-parent-uid="<?php echo esc_attr( $parent_uid ); ?>">
			<?php echo wp_kses( $sub_layers, WPC_Utils::allowed_tags() ); ?>			
		</ul>
	</div>

	<?php
	/**
	 * Hook: After sub layer group.
	 *
	 * * @since 3.3
	 *
	 * @param string $parent_uid Parent layer uid.
	 * @param object $wpc WPCSE.
	 */
	do_action( 'wpc_after_sub_layer_group', $parent_uid, $wpc );
}
