<?php
/**
 * Preview template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.1
 * @version  3.4.6
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$classes[] = 'wpc-preview-parent-wrap';
$classes[] = 'wpc-config-element';
$classes[] = 'wpc-config-element-' . esc_attr( $wpc->id );

$classes = array_filter( array_merge( $classes, array( $wpc->extra_class ) ) );

/**
 * Filter: Preview element wrapper classes.
 *
 * * @since 3.0
 *
 * @param array   $classes Preview wrapper classes.
 */
$classes = apply_filters( 'wpc_preview_wrapper_classes', $classes );

if ( function_exists( 'wc_print_notices' ) ) {
	wc_print_notices();
}


/**
 * Hook: Before configurator preview wrapper element html.
 *
 * * @since 3.3
 *
 * @param object  $wpc WPCSE Class.
 */
do_action( 'wpc_before_preview_wrapper', $wpc );

?>
<div x-data x-on:resize.window="<?php echo esc_attr( $wpc->store . '.windowResized( $el )' ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" x-bind:class="<?php echo esc_attr( $wpc->store . '.getPreviewWrapperClasses( $el )' ); ?>" data-configurator data-config-id="<?php echo esc_attr( $wpc->id ); ?>">

	<div id="configurator-<?php echo esc_attr( $wpc->id ); ?>" class="wpc-configurator">

		<?php
		/**
		 * Hook: Before configurator preview element html.
		 *
		 * * @since 3.4.6
		 *
		 * @param object $wpc WPCSE Class.
		 */
		do_action( 'wpc_before_preview', $wpc );

		$container_class = apply_filters(
			'wpc_preview_container_class',
			array(
				'configurator-view',
				'wpc-configurator-view',
				'wpc-carousel',
				'dot-style-' . $wpc->dot_style,
				'dot-position-' . $wpc->dot_position,
			)
		);
		?>
		<div id="configurator-view-<?php echo esc_attr( $wpc->id ); ?>" class="<?php echo esc_attr( implode( ' ', $container_class ) ); ?>" data-configurator-view <?php echo implode( ' ', $wpc->slider_data ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

			<?php
			echo wp_kses( $wpc->get_preview_inner_html(), WPC_Utils::allowed_tags() );

			/**
			 * Hook: After preview inner element html.
			 *
			 * * @since 2.0
			 *
			 * @param int        $wpc->id Configurator ID.
			 * @param object     $wpc WPCSE Class.
			 */
			do_action( 'wpc_after_preview_inner_html', $wpc->id, $wpc );
			?>

		</div> <!-- .configurator-view -->

		<?php
		$wpc->get_show_details_trigger_html( true );

		/**
		 * Hook: After configurator preview element html.
		 *
		 * * @since 2.0
		 *
		 * @param object $wpc WPCSE Class.
		 */
		do_action( 'wpc_after_preview', $wpc );
		?>

	</div> <!-- .wpc-configurator -->

</div> <!-- .wpc-preview-parent-wrap -->

<?php
/**
 * Hook: After configurator preview wrapper element html.
 *
 * * @since 3.3
 *
 * @param object  $wpc WPCSE Class.
 */
do_action( 'wpc_after_preview_wrapper', $wpc );
