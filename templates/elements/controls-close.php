<?php
/**
 * Controls close template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.3
 * @version  3.4.2
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

$open_parent_uid = $config_data->get_parent_uid( $parent_uid );

if ( ! $open_parent_uid ) {
	$open_parent_uid = $config_data->get_anchestor_id();
}

$level = $wpc->layers[ $parent_uid ]['level'];

$class   = array();
$class[] = 'wpc-control-item';
if ( apply_filters( 'wpc_allow_control_animation', false, $wpc ) ) {
	$class[] = 'animated fadeOutUp';
}

$attr['class'] = 'class="wpc-control-close ' . esc_attr( implode( ' ', $class ) ) . '"';
$attr['text']  = 'data-control-close';
$attr['text']  = 'data-text="' . esc_attr__( 'Close', 'wp-configurator-pro' ) . '"';

$attr['alpine:click'] = ( 1 === $level ) ? 'x-on:click="' . esc_attr( $wpc->store . '.closeGroup( "' . $parent_uid . '", $el )' ) . '"' : 'x-on:click="' . esc_attr( $wpc->store . '.closeAndOpenGroup( "' . $parent_uid . '", "' . $open_parent_uid . '", $el )' ) . '"';

$attr = apply_filters( 'wpc_close_control_attr', $attr, $parent_uid, $open_parent_uid, $wpc );
?>

<li <?php echo implode( ' ', $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<i class="wpc-control-close-icon <?php echo esc_attr( apply_filters( 'wpc_close_control_icon', WPC_Utils::icon( 'close' ), $wpc ) ); ?>"></i>
	<span class="wpc-control-close-text"><?php echo esc_html( apply_filters( 'wpc_close_control_text', esc_html__( 'Close', 'wp-configurator-pro' ), $wpc ) ); ?></span>
</li>
