<?php
/**
 * Hotspot template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.1
 * @version  3.4.6
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( isset( $wpc->hotspots[ $view ] ) ) {
	foreach ( $wpc->hotspots[ $view ] as $key => $uid ) {

		$config_data = $wpc->config[ $wpc->id ];

		$name        = $config_data->get_name( $uid );
		$description = $config_data->get_description( $uid );

		$class['hotspot'] = 'wpc-hotspot';

		$class = apply_filters( 'wpc_hotspot_classes', $class, $uid, $view, $wpc );

		$attr                     = array();
		$attr['class']            = 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
		$attr['data-hotspot']     = 'data-hotspot';
		$attr['data-hotspot-uid'] = 'data-hotspot-uid="' . esc_attr( $uid ) . '"';
		$attr['alpine:init']      = 'x-init="' . esc_attr( $wpc->store . '.initPreviewElement( "' . $uid . '", "' . $view . '" )' ) . '"';
		$attr['alpine:style']     = 'x-bind:style="' . esc_attr( $wpc->store . '.getPreviewElementStyle( "' . $uid . '", "' . $view . '" )' ) . '"';
		$attr['alpine:click']     = 'x-on:click.stop="' . esc_attr( $wpc->store . '.clickHotspot( "' . $uid . '", $el )' ) . '"';

		$attr = apply_filters( 'wpc_hotspot_attr', $attr, $uid, $view, $wpc );
		?>
		<div <?php echo implode( ' ', $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<span></span>
			<?php
			if ( $description && apply_filters( 'wpc_show_hotspot_tooltip', true, $uid, $view, $wpc ) ) {
				?>
				<div class="wpc-hotspot-tooltip">
					<div class="wpc-hotspot-tooltip-inner">
						<h3 class="wpc-title"><?php echo esc_html( $name ); ?></h3>
						<p class="wpc-desc"><?php echo esc_html( $description ); ?></p>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
}
