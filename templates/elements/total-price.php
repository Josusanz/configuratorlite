<?php
/**
 * Total Price template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.1
 * @version  3.4.12
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( ! WPC_Utils::str_to_bool( $wpc->total_price ) ) {
	return;
}

$total_price_text = get_option( 'wpc_total_price_text', esc_html__( 'Total Price', 'wp-configurator-pro' ) );

$build_price = WPC_Utils::price( $wpc->base_price );

$classes[] = 'wpc-total-price-parent-wrap';
$classes[] = 'wpc-config-element';
$classes[] = 'wpc-config-element-' . esc_attr( $wpc->id );

$classes = array_filter( array_merge( $classes, array( $wpc->extra_class ) ) );

/**
 * Filter: Total price element wrapper classes.
 *
 * * @since 3.0
 *
 * @param array   $classes Control wrapper classes.
 */
$classes = apply_filters( 'wpc_total_price_wrapper_classes', $classes );
?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-price-wrap data-config-id="<?php echo esc_attr( $wpc->id ); ?>">

	<div class="wpc-single-price wpc-price wpc-price-<?php echo esc_attr( $wpc->id ); ?>">

		<span class="wpc-total-text"><?php echo esc_html( $total_price_text ); ?></span>

		<?php
		/**
		 * Hook: Before total price element html.
		 *
		 * * @since 3.4.12
		 *
		 * @param int        $wpc->id Configurator ID.
		 * @param object      $wpc WPCSE Class.
		 * @param int       $base_price Base price.
		 */
		do_action( 'wpc_before_total_price', $wpc->id, $wpc, $wpc->base_price );
		?>

		<template x-data x-if="<?php echo esc_attr( $wpc->store . '.isSalePriceAvailable()' ); ?>">
			<span x-data class="wpc-calculation wpc-price-value wpc-regular-price" x-text="<?php echo esc_attr( $wpc->store . '.regularPriceHtml' ); ?>">
			<?php
			echo wp_kses(
				$build_price,
				array(
					'span' => array( 'class' => array() ),
					'bdi'  => array(),
				)
			);
			?>
			</span>
		</template>

		<span x-data class="wpc-calculation wpc-price-value" x-text="<?php echo esc_attr( $wpc->store . '.totalPriceHtml' ); ?>">
		<?php
		echo wp_kses(
			$build_price,
			array(
				'span' => array( 'class' => array() ),
				'bdi'  => array(),
			)
		);
		?>
		</span>

		<?php
		/**
		 * Hook: After total price element html.
		 *
		 * * @since 2.0
		 *
		 * @param int        $wpc->id Configurator ID.
		 * @param object      $wpc WPCSE Class.
		 * @param int       $base_price Base price.
		 */
		do_action( 'wpc_after_total_price', $wpc->id, $wpc, $wpc->base_price );
		?>

	</div> <!-- .wpc-single-price -->

</div> <!-- .wpc-total-price-parent-wrap -->
