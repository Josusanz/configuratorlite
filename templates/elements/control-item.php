<?php
/**
 * Control item template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2
 * @version  3.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

$uid = isset( $layer['uid'] ) ? $layer['uid'] : '';

if ( ! $wpc->allow_multiple_level && ( $wpc->layers[ $uid ]['level'] > 1 ) && $config_data->has_children( $uid ) ) {
	return;
}

if ( wpc_is_control_allowed( $uid, $wpc ) ) {

	/**
	 * Hook: Control inner html.
	 *
	 * * @since 3.2
	 *
	 * @param string $uid Layer uid.
	 * @param object $wpc WPCSE.
	 */
	do_action( 'wpc_before_control_item', $layer, $wpc );

	$control_item_attr = wpc_control_item_attr( $uid, $wpc );
	?>
	<li <?php echo implode( ' ', $control_item_attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php
		/**
		 * Hook: Control inner html.
		 *
		 * * @since 3.3
		 *
		 * @param string      $uid Layer uid.
		 * @param object       $wpc WPCSE.
		 */
		do_action( 'wpc_control_inner_html_start', $layer, $wpc );

		/**
		 * Hook: Custom layer type html.
		 *
		 * * @since 3.2
		 *
		 * @param string $uid Layer uid.
		 * @param object $wpc WPCSE.
		 */
		do_action( 'wpc_control_' . $layer['type'] . '_html', $layer, $wpc );

		/**
		 * Hook: Control inner html.
		 *
		 * * @since 3.3
		 *
		 * @param string      $uid Layer uid.
		 * @param object       $wpc WPCSE.
		 */
		do_action( 'wpc_control_inner_html_end', $layer, $wpc, $force_stop );
		?>
	</li>
	<?php
}
