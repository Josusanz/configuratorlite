<?php
/**
 * Cart Form Summary template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.1
 * @version  3.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$product = ( WPC_WOO_ACTIVE ) ? wc_get_product( $wpc->product_id ) : false;

if ( $product && ! $product->is_purchasable() ) {
	return;
}

$classes[] = 'wpc-' . $wpc->form . '-parent-wrap';
$classes[] = 'wpc-config-element';
$classes[] = 'wpc-config-element-' . esc_attr( $wpc->id );
$classes[] =  $wpc->style;

$classes = array_filter( array_merge( $classes, array( $wpc->extra_class ) ) );

$classes[] = WPC_Utils::str_to_bool( $wpc->summary_popup ) ? 'wpc-has-summary' : '';

/**
 * Filter: Cart form element wrapper classes.
 *
 * * @since 3.0
 *
 * @param array   $classes Cart form wrapper classes.
 */
$classes = apply_filters( 'wpc_cart_form_wrapper_classes', $classes );
?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-config-id="<?php echo esc_attr( $wpc->id ); ?>">

	<?php
	/**
	 * Hook: Before summary form.
	 *
	 * @hooked wpc_summary_stock_html - 10
	 *
	 * * @since 3.4
	 *
	 * @param WPCSE $wpc WPCSE Class.
	 */
	do_action( 'wpc_before_summary_form', $wpc );
	?>

	<div class="wpc-<?php echo esc_attr( $wpc->form ); ?>-wrapper" data-<?php echo esc_attr( $wpc->form ); ?>>
		<?php
		/**
		 * Hook: After summary trigger button.
		 *
		 * @hooked wpc_summary_cart_form_html - 10
		 * @hooked wpc_summary_trigger_html - 15
		 * @hooked wpc_summary_popup_html - 20
		 *
		 * * @since 3.4
		 *
		 * @param WPCSE $wpc WPCSE Class.
		 */
		do_action( 'wpc_summary_form', $wpc );
		?>

	</div> <!-- .wpc-cart-form-wrapper -->

	<?php
	/**
	 * Hook: After summary form.
	 *
	 * * @since 3.4
	 *
	 * @param WPCSE $wpc WPCSE Class.
	 */
	do_action( 'wpc_after_summary_form', $wpc );
	?>

</div> <!-- .wpc-cart-form-parent-wrap -->
