<?php
/**
 * Sub controls separated template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.3
 * @version  3.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

$attr = wpc_sub_control_wrapper_attr( $parent_uid, $wpc );
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
		<?php
		if ( apply_filters( 'wpc_' . $wpc->style . '_allow_close_control', false, $parent_uid, $wpc ) ) {
			echo wp_kses( $wpc->get_controls_close( $parent_uid ), WPC_Utils::allowed_tags() );
		}

		foreach ( $layer as $key => $sub_layer ) {
			echo wp_kses( $wpc->get_control_item( $sub_layer ), WPC_Utils::allowed_tags() );
		}
		?>
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
foreach ( $layer as $key => $value ) {
	if ( isset( $value['children'] ) && ! empty( $value['children'] ) ) {
		echo $wpc->get_sub_controls_separated( $value['children'], $value['uid'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
