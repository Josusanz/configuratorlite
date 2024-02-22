<?php
/**
 * Controls template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.1
 * @version  3.4.7
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$classes[] = 'wpc-controls-parent-wrap';
$classes[] = 'wpc-config-element';
$classes[] = 'wpc-config-element-' . esc_attr( $wpc->id );
$classes[] = $wpc->style;

$classes = array_filter( array_merge( $classes, array( $wpc->extra_class ) ) );

/**
 * Filter: Control element wrapper classes.
 *
 * * @since 3.0
 *
 * @param array   $classes Control wrapper classes.
 */
$classes = apply_filters( 'wpc_controls_wrapper_classes', $classes );

if ( 'style1' === $wpc->style || 'style2' === $wpc->style || 'style3' === $wpc->style ) {
	$style = 'default';
} elseif ( 'accordion' === $wpc->style || 'accordion-2' === $wpc->style ) {
	$style = 'accordion';
} else {
	$style = $wpc->style;
}

$control_type = $wpc->control_type;
?>

<div x-data x-init="<?php echo esc_attr( $wpc->store . '.setControlStyle( "' . $style . '", $el )' ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-controls-wrap data-control-type="<?php echo esc_attr( $control_type ); ?>" data-config-id="<?php echo esc_attr( $wpc->id ); ?>">
	<?php
	/**
	 * Hook: Before controls wrap html.
	 *
	 * * @since 3.4.7
	 *
	 * @param WPCSE $wpc WPCSE Class.
	 */
	do_action( 'wpc_before_controls_wrap_html', $wpc );

	$classes   = array();
	$classes[] = 'wpc-controls-wrap';
	$classes[] = 'wpc-' . esc_attr( $style ) . '-control';

	/**
	 * Filter: Control element wrapper classes.
	 *
	 * * @since 3.0
	 *
	 * @param array   $classes Control wrapper classes.
	 * @param object       $wpc WPCSE Class.
	 */
	$classes = apply_filters( 'wpc_controls_inner_classes', $classes, $wpc );
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" x-bind:class="<?php echo esc_attr( $wpc->store . '.getControlsInnerClasses()' ); ?>">

		<?php
		/**
		 * Hook: Before controls html.
		 *
		 * * @since 3.3
		 *
		 * @param object       $wpc WPCSE Class.
		 */
		do_action( 'wpc_before_controls_html', $wpc );

		echo wp_kses( $wpc->get_controls_inner_html(), WPC_Utils::allowed_tags() );

		/**
		 * Hook: After controls html.
		 *
		 * * @since 2.0
		 *
		 * @param object       $wpc WPCSE Class.
		 */
		do_action( 'wpc_after_controls_html', $wpc );
		?>

	</div> <!-- .wpc-controls-wrap -->

	<?php
	/**
	 * Hook: After controls wrap html.
	 *
	 * * @since 3.4.7
	 *
	 * @param WPCSE $wpc WPCSE Class.
	 */
	do_action( 'wpc_after_controls_wrap_html', $wpc );
	?>

</div> <!-- .wpc-controls-parent-wrap -->
