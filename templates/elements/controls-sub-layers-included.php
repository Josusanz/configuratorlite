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
		foreach ( $layer as $key => $sub_layer ) {
			if ( wpc_is_control_allowed( $sub_layer['uid'], $wpc ) ) {
				echo wp_kses( $wpc->get_control_item( $sub_layer ), WPC_Utils::allowed_tags() );
			}
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
