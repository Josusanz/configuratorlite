<?php
/**
 * Controls template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.3
 * @version  3.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

$parent_uid = $config_data->get_anchestor_id();
?>

<div class="wpc-control-lists wpc-parent-control" x-bind:class="<?php echo esc_attr( $wpc->store . '.getParentControlWrapperClasses()' ); ?>">

	<?php
	/**
	 * Hook: Before parent control html.
	 *
	 * * @since 3.3
	 *
	 * @param object $wpc WPCSE Class.
	 */
	do_action( 'wpc_before_parent_control_html', $wpc );
	?>

	<ul class="wpc-control-lists-inner" data-controls data-parent-uid="<?php echo esc_attr( $parent_uid ); ?>">
		<?php
		$sub_controls = '';

		$parent = array();

		foreach ( $wpc->components as $top_key => $layer ) {
			echo wp_kses( $wpc->get_control_item( $layer ), WPC_Utils::allowed_tags() );

			if ( wpc_is_control_allowed( $layer['uid'], $wpc ) && isset( $layer['children'] ) ) {
				$sub_controls .= $wpc->get_sub_controls_children_separated( $layer['children'], $layer['uid'] );
			}
		}
		?>
	</ul>

	<?php
	/**
	 * Hook: After parent control html.
	 *
	 * * @since 3.3
	 *
	 * @param object $wpc WPCSE Class.
	 */
	do_action( 'wpc_after_parent_control_html', $wpc );
	?>

</div> <!-- .wpc-parent-control -->

<?php
if ( $sub_controls ) {
	?>
	<div x-data class="wpc-sub-controls" x-bind:class="<?php echo esc_attr( $wpc->store . '.getSubControlWrapperClasses()' ); ?>">
		<?php
		/**
		 * Hook: Before sub control html.
		 *
		 * * @since 3.3
		 *
		 * @param object $wpc WPCSE Class.
		 */
		do_action( 'wpc_before_sub_control_html', $wpc );

		echo $sub_controls; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		/**
		 * Hook: After sub control html.
		 *
		 * * @since 3.3
		 *
		 * @param object $wpc WPCSE Class.
		 */
		do_action( 'wpc_after_sub_control_html', $wpc );
		?>
	</div>
	<?php
}

