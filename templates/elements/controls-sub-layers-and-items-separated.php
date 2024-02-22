<?php
/**
 * Sub controls separated template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.4.1
 * @version  3.4.1
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

$attr = wpc_sub_control_wrapper_attr( $parent_uid, $wpc );

$sub_layer_items = '';

if ( apply_filters( 'wpc_' . $wpc->style . '_allow_close_control', false, $parent_uid, $wpc ) ) {
	$back_control = wp_kses( $wpc->get_controls_close( $parent_uid ), WPC_Utils::allowed_tags() );
}

foreach ( $layer as $key => $sub_layer ) {

	$uid = isset( $sub_layer['uid'] ) ? $sub_layer['uid'] : '';

	$layer_type = $config_data->get_type( $uid );

	if ( 'sub_group' === $layer_type ) {
		$sub_layer_items .= wp_kses( $wpc->get_control_item( $sub_layer ), WPC_Utils::allowed_tags() );
	} else {
		$parent_uid = $config_data->get_parent_uid( $uid );

		if ( wpc_is_control_allowed( $sub_layer['uid'], $wpc ) ) {
			$wpc->control_items[ $parent_uid ][] = $sub_layer;
		}
	}
}

if ( $sub_layer_items ) {
	?>

	<div <?php echo implode( ' ', $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php
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

		<ul class="wpc-control-lists-inner" data-controls data-parent-uid="<?php echo esc_attr( $parent_uid ); ?>">
			<?php echo $back_control; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php echo $sub_layer_items; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</ul>

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
		?>
	</div>

	<?php
}

foreach ( $layer as $key => $value ) {
	if ( isset( $value['children'] ) && ! empty( $value['children'] ) ) {
		echo $wpc->get_sub_controls_and_items_separated( $value['children'], $value['uid'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
