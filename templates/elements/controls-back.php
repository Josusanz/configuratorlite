<?php
/**
 * Controls back template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.3
 * @version  3.4.1
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

$parent_of_parent = $config_data->get_parent_uid( $parent_uid );

$class[] = 'wpc-control-back-btn';

$class = apply_filters( 'wpc_back_btn_classes', $class, $parent_uid, $wpc );

$attr['class']        = 'class="' . implode( ' ', $class ) . '"';
$attr['alpine:click'] = ! empty( $parent_of_parent ) ? 'x-on:click="' . esc_attr( $wpc->store . '.openGroup( "' . $parent_of_parent . '", $el )' ) . '"' : 'x-on:click="' . esc_attr( $wpc->store . '.closeGroup( "' . $parent_uid . '", $el )' ) . '"';

$attr = apply_filters( 'wpc_back_control_attr', $attr, $parent_uid, $wpc );
?>
<div <?php echo implode( ' ', $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<span class="wpc-control-back-icon wpc-icon <?php echo esc_attr( apply_filters( 'wpc_control_back_icon', WPC_Utils::icon( 'arrow-left' ), $wpc ) ); ?>"></span>
	<span class="wpc-control-back-text"><?php echo esc_html( apply_filters( 'wpc_control_back_text', esc_html__( 'Back', 'wp-configurator-pro' ), $wpc ) ); ?></span>
</div>
