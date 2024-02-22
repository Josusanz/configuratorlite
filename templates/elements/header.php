<?php
/**
 * Header template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2.5
 * @version  3.2.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$classes[] = 'wpc-header-parent-wrap';
$classes[] = 'wpc-config-element';
$classes[] = 'wpc-config-element-' . esc_attr( $wpc->id );
$classes[] = 'clearfix';

$classes = array_filter( array_merge( $classes, array( $wpc->extra_class ) ) );

/**
 * Filter: Header element wrapper classes.
 *
 * * @since 3.2.5
 *
 * @param array   $classes Header wrapper classes.
 */
$classes = apply_filters( 'wpc_header_wrapper_classes', $classes );
?>
<header class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
	/**
	 * Hook: Before header logo.
	 *
	 * * @since 3.2.5
	 *
	 * @param class $wpc WPCSE Class.
	 */
	do_action( 'wpc_before_header_logo', $wpc );

	$wpc->header_logo( true );
	?>

	<!-- Header Right Side Elements -->
	<div id="wpc-header-element-right-wrapper">
		<?php
		/**
		 * Hook: After header right elements.
		 *
		 * * @since 3.2.5
		 *
		 * @param class $wpc WPCSE Class.
		 */
		do_action( 'wpc_before_header_total_price', $wpc );

		if ( apply_filters( 'wpc_allow_header_total_price', true, $wpc ) ) {
			$wpc->header_total_price( true );
		}
		?>

		<div class="wpc-header-element-right" data-config-id="<?php echo esc_attr( $wpc->id ); ?>">
			<?php
			$wpc->header_menu_trigger( true );
			$wpc->share_inline( true );

			/**
			 * Hook: After header right elements.
			 *
			 * * @since 3.2.5
			 *
			 * @param class $wpc WPCSE Class.
			 */
			do_action( 'wpc_after_share_inline', $wpc );
			?>
		</div>

		<?php
		/**
		 * Hook: After header right elements.
		 *
		 * * @since 3.2.5
		 *
		 * @param class $wpc WPCSE Class.
		 */
		do_action( 'wpc_after_header_right_elements', $wpc );
		?>
	</div>			

	<?php $wpc->header_menu( true ); ?>
</header>
