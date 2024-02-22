<?php
/**
 * Summary List template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2
 * @version  3.5.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$class = array();
$class[] = 'wpc-summary-list';
$class[] = ! WPC_Utils::str_to_bool( $wpc->price_details ) ? 'wpc-hide-item-price' : '';
$class[] = WPC_Utils::str_to_bool( $wpc->remove_price_is_empty ) ? 'wpc-remove-price-empty' : '';
?>

<div x-data class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
	<ul>
		<template x-if="<?php echo esc_attr( $wpc->store . '.basePrice' ); ?>"> 
			<li>
				<span class="wpc-summary-list-title" x-text="wpc_i18n.base_price_text"></span>

				<span class="wpc-sign"> - </span>
				<span class="wpc-summary-list-base-price" x-text="<?php echo esc_attr( $wpc->store . '.basePriceHtml' ); ?>"></span>
			</li>
		</template>

		<template x-for="group, index in <?php echo esc_attr( $wpc->store . '.summaryData' ); ?>">
			<li :class="<?php echo esc_attr( 'wpc.simplify_string(' . $wpc->store . '.getTopLayerNameByIndex(parseInt(index)) )' ); ?>">
				<span class="wpc-summary-list-title" x-text="<?php echo esc_attr( $wpc->store . '.getTopLayerNameByIndex(parseInt(index))' ); ?>"></span>
				<span class="wpc-sign"> - </span>
				<template x-if="! wpc.stringToBoolean(wpc_plugin.remove_price_is_empty) || (wpc.stringToBoolean(wpc_plugin.show_group_price) && wpc.stringToBoolean(wpc_plugin.remove_price_is_empty) && <?php echo $wpc->store . '.getGroupPrice( group ))' ?>">
					<span class="wpc-summary-list-group-price" x-text="<?php echo esc_attr( 'wpc.formatMoney( ' . $wpc->store . '.getGroupPrice( group ))' ); ?>"></span>
				</template>
				<ul>
					<template  x-for="lists, index in group">
						<li :class="{ 'wpc-has-no-price' : ! wpc.getPrice(lists[Object.keys(lists).length - 1].settings) }">
							<span class="wpc-summary-list-child-wrap">
								<template x-for="list, index in lists">
									<span class="wpc-summary-list-child-title">
										<span x-text="<?php echo esc_attr( $wpc->store . '.getSummaryText( list.name, list )' ); ?>"></span>
										<span class="wpc-sign"> - </span>
									</span>
								</template>
							</span>
							<?php
							if ( WPC_Utils::str_to_bool( $wpc->price_details ) ) {
								?>
								<template x-if="! wpc.stringToBoolean(wpc_plugin.remove_price_is_empty) || (wpc.stringToBoolean(wpc_plugin.remove_price_is_empty) && wpc.getPrice(lists[Object.keys(lists).length - 1].settings))">
									<span x-data x-if="index == lists.length - 1" class="wpc-summary-list-price" x-text="wpc.formatMoney(wpc.getPrice(lists[Object.keys(lists).length - 1].settings))"></span>
								</template>
								<?php
							}
							?>
						</li>
					</template>
				</ul>
			</li>
		</template>
		<?php if ( apply_filters( 'wpc_has_custom_fields', false ) ) : ?>
			<template x-for="field, index in <?php echo esc_attr( $wpc->store . '.customFields' ); ?>">
				<template x-if="field.value">
					<li>
						<span class="wpc-summary-list-title" x-text="field.name"></span>
						<span class="wpc-sign"> - </span>
						<ul>
							<li>
								<span class="wpc-summary-list-child-wrap">
									<span class="wpc-summary-list-child-title">
										<span x-text="field.value"></span>
										<span class="wpc-sign"> - </span>
									</span>
								</span>
								<span class="wpc-summary-list-price" x-text="wpc.formatMoney(field.price)"></span>
							</li>
						</ul>
					</li>
				</template>                             
			</template>
		<?php endif; ?>

		<?php
		/**
		 * Hook: After summary list item.
		 *
		 * 
		 * * @since 3.5.3
		 *
		 * @param WPCSE $wpc WPCSE Class.
		 */
		do_action( 'wpc_after_summary_list_item', $wpc );
		?>
	</ul>
</div>
