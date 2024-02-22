<?php
/**
 * Summary template for email and config posts.
 *
 * @package  wp-configurator-pro/templates/
 * @since  2.6.2
 * @version  3.4.10
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$base_price_text  = get_option( 'wpc_base_price_text', esc_html__( 'Base Price', 'wp-configurator-pro' ) );
$total_price_text = get_option( 'wpc_total_price_text', esc_html__( 'Expected Total', 'wp-configurator-pro' ) );

$total = $base_price;

$class = array();
$class[] = ! WPC_Utils::str_to_bool( $price_details ) ? 'wpc-hide-item-price' : '';

echo '<ul class="' . esc_attr( implode( ' ', $class ) ) . '">';

if ( floatval( $base_price ) > 0 ) {
	echo '<li>';
	echo '<span class="wpc-summary-list-title">' . esc_html( $base_price_text ) . '</span>';


	echo '<span class="wpc-sign"> - </span>';
	echo '<span class="wpc-summary-list-base-price">' . WPC_Utils::price( $base_price ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	echo '</li>';
}

if ( isset( $active_tree_array ) ) {
	foreach ( $active_tree_array as $key => $groups ) {

		echo '<li class="' . esc_attr( WPC_Utils::simplify_string( $groups['title'] ) ) . '">';
			echo '<span class="wpc-summary-list-title">' . esc_html( $groups['title'] ) . '</span>';

			if ( WPC_Utils::str_to_bool( $show_group_price ) ) {

				echo '<span class="wpc-sign"> - </span>';

				echo '<span class="wpc-summary-list-group-price">' . WPC_Utils::price( $groups['price'] ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			echo '<ul>';

				foreach ( $groups['active'] as $key => $group ) {

					echo '<li class="list-' . esc_attr( $key ) . '">';

						$count = count( $group );

						foreach ( $group as $key => $set ) { /* Index starts with 1, skip the first index */

							$first = ( 1 === $key );
							$last  = ( $count === $key );
							$text  = $set['title'];
							$price = (float) $set['price'];

							if ( $first ) {
								echo '<span class="wpc-summary-list-child-wrap">';
							}

							echo '<span class="wpc-summary-list-child-title">';
								echo esc_html( apply_filters( 'wpc_summary_list_item_layer_text', $text, $set, $values ) );

								echo '<span class="wpc-sign"> - </span>';
							echo '</span>';

							if ( $last && ! empty( $price ) ) {
								echo '</span>';

								if ( WPC_Utils::str_to_bool( $price_details ) ) {
									echo '<span class="wpc-summary-list-price">' . WPC_Utils::price( $price ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								$total += isset( $price ) ? $price : 0;
							}
						}

					echo '</li>';
				}

			echo '</ul>';
		echo '</li>';
	}
}

/**
 * Hook: After customer details.
 *
 * * @since 2.6
 *
 * @param int $config_id Configurator ID.
 */
do_action( 'wpc_summary_lists', $config_id );

echo '</ul>';

if ( WPC_Utils::str_to_bool( $show_total_price ) ) {

	/**
	 * Filter: Total price.
	 *
	 * * @since 2.6
	 *
	 * @param float              $total Total price.
	 * @param float/int/string   $base_price Base price.
	 */
	$total = apply_filters(
		'wpc_summary_total',
		$total,
		$base_price
	);

	echo '<div class="wpc-summary-total-wrap">';
	echo '<h4 class="wpc-summary-total">';
	echo '<span class="wpc-summary-list-title">' . esc_html( $total_price_text ) . '</span>';
	echo '<span class="wpc-sign"> - </span>';
	echo '<span class="wpc-summary-list-total-price">' . WPC_Utils::price( $total ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</h4>';
	echo '</div>';
}
