<?php
/**
 * Controls close all template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.4
 * @version  3.4.6
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

$attr['class'] = '';

$attr['alpine:click'] = 'x-on:click="' . esc_attr( $wpc->store . '.closeAll( $el )' ) . '"';
?>

<div class="wpc-control-close">
	<span <?php echo implode( ' ', $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<span class="wpc-control-close-icon <?php echo esc_attr( apply_filters( 'wpc_control_close_all_icon', WPC_Utils::icon( 'close' ), $wpc ) ); ?>"></span>
		<span class="wpc-control-close-text"><?php echo esc_html( apply_filters( 'wpc_control_close_all_text', esc_html__( 'Close', 'wp-configurator-pro' ), $wpc ) ); ?></span>
	</span>
</div>
