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
