<?php
/**
 * Sub controls included template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.3
 * @version  3.4.10
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

$sub_layer_group = '';
$sub_layer_items = '';

$childrens = array();

ob_start();

foreach ( $layer as $key => $sub_layer ) {

	$uid = isset( $sub_layer['uid'] ) ? $sub_layer['uid'] : '';

	$layer_type = $config_data->get_type( $uid );

	$layer_settings = $config_data->get_layer_settings( $uid );

	$custom_class = isset( $layer_settings['custom_class'] ) ? $layer_settings['custom_class'] : '';

	if ( 'sub_group' === $layer_type ) {

		$class                 = array();
		$class[]               = 'wpc-control-list';
		$class['custom-class'] = ( $custom_class ) ? $custom_class : '';

		/**
		 * Filter: Sub group wrapper classes.
		 *
		 * * @since 3.3
		 *
		 * @param array   $class Classes.
		 * @param string  $uid Layer uid.
		 * @param WPCSE  $wpc WPCSE.
		 */
		$class = apply_filters( 'wpc_sub_control_wrapper_classes', array_filter( $class ), $parent_uid, $wpc );

		echo '<div class="' . esc_attr( implode( ' ', $class ) ) . '">';

		echo wpc_get_control_group_name( $uid, $wpc );

		/**
		 * Hook: Before sub control list html.
		 *
		 * * @since 3.4.9
		 *
		 * @param string $uid Layer uid.
		 * @param object $wpc WPCSE.
		 */
		do_action( 'wpc_before_sub_control_list', $uid, $wpc );

		echo '<ul class="wpc-control-list-inner" data-controls data-parent-uid="' . esc_attr( $uid ) . '">';

		foreach ( $sub_layer['children'] as $key => $value ) {

			$layer_type = $config_data->get_type( $value['uid'] );

			echo wp_kses( $wpc->get_control_item( $value, true ), WPC_Utils::allowed_tags() );

			if ( 'sub_group' === $layer_type ) {
				$childrens[] = $value;
			}
		}

		echo '</ul>';

		/**
		 * Hook: After sub control list html.
		 *
		 * * @since 3.4.9
		 *
		 * @param string $uid Layer uid.
		 * @param object $wpc WPCSE.
		 */
		do_action( 'wpc_after_sub_control_list', $uid, $wpc );

		echo '</div>';

	} else {
		$sub_layer_items .= wp_kses( $wpc->get_control_item( $sub_layer ), WPC_Utils::allowed_tags() );
	}
}

if ( $sub_layer_items ) {	

	$layer_settings = $config_data->get_layer_settings( $parent_uid );

	$custom_class = isset( $layer_settings['custom_class'] ) ? $layer_settings['custom_class'] : '';

	$class                 = array();
	$class[]               = 'wpc-control-list';
	$class['custom-class'] = ( $custom_class ) ? $custom_class : '';

	/**
	 * Filter: Sub group wrapper classes.
	 *
	 * * @since 3.3
	 *
	 * @param array   $class Classes.
	 * @param string  $uid Layer uid.
	 * @param WPCSE  $wpc WPCSE.
	 */
	$class = apply_filters( 'wpc_sub_control_wrapper_classes', array_filter( $class ), $parent_uid, $wpc );

	echo '<div class="' . esc_attr( implode( ' ', $class ) ) . '">';

	/**
	 * Hook: before sub control list html.
	 *
	 * * @since 3.4.9
	 *
	 * @param string $uid Layer uid.
	 * @param object $wpc WPCSE.
	 */
	do_action( 'wpc_before_sub_control_list', $uid, $wpc );
	
	echo '<ul class="wpc-control-lists-inner" data-controls data-parent-uid="' . esc_attr( $parent_uid ) . '">';
	echo $sub_layer_items;
	echo '</ul>';

	/**
	 * Hook: After sub control list html.
	 *
	 * * @since 3.4.9
	 *
	 * @param string $uid Layer uid.
	 * @param object $wpc WPCSE.
	 */
	do_action( 'wpc_after_sub_control_list', $uid, $wpc );

	echo '</div>';
}

$sub_layer_group = ob_get_clean();

if ( $sub_layer_group ) {
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

		<div class="wpc-control-lists-inner">
			<?php echo wp_kses( $sub_layer_group, WPC_Utils::allowed_tags() ); ?>
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
		?>
	</div>
	<?php
}

if ( $childrens ) {
	foreach ( $childrens as $children_key => $children ) {
		if ( isset( $children['children'] ) ) {
			echo wp_kses( $wpc->get_sub_controls_children_separated( $children['children'], $children['uid'] ), WPC_Utils::allowed_tags() );
		}
	}
}

