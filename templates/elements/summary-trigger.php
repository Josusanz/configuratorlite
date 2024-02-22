<?php
/**
 * Cart Form Summary template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2
 * @version  3.4.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( 'cart-form' === $wpc->form ) {
	$trigger = array(
		'show' => WPC_Utils::str_to_bool( $wpc->summary_popup ),
		'icon' => 'basket',
		'text' => $wpc->view_summary_btn_text,
	);
} else {
	$trigger = array(
		'show' => true,
		'icon' => 'mail',
		'text' => $wpc->btn_text,
	);
}

$trigger = apply_filters( 'wpc_summary_trigger', $trigger, $wpc );

$class[] = 'wpc-primary-btn';

$class = apply_filters( 'wpc_summary_trigger_btn_classes', $class, $wpc );

$attr['class']              = 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
$attr['alpine:data']        = 'x-data';
$attr['alpine:click']       = 'x-on:click.prevent="' . esc_attr( $wpc->store . '.buildSummaryData()' ) . '"';
$attr['data-open-popup-id'] = 'data-open-popup-id="' . esc_attr( $wpc->form . '-summary' ) . '"';
$attr['data-popup-type']    = 'data-popup-type="full"';

$attr = apply_filters( 'wpc_summary_trigger_attr', $attr, $wpc );

if ( isset( $trigger['show'] ) && $trigger['show'] ) {
	?>
	<span <?php echo implode( ' ', $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<span class="wpc-summary-btn-icon wpc-icon <?php echo esc_attr( WPC_Utils::icon( $trigger['icon'] ) ); ?>"></span>
		<span class="wpc-summary-btn-text"><?php echo esc_html( $trigger['text'] ); ?></span>
	</span>
	<?php
}
