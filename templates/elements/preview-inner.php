<?php
/**
 * Preview inner template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.4
 * @version  3.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_data = $wpc->config[ $wpc->id ];

if ( ! empty( $wpc->total_views ) ) {
	foreach ( $wpc->total_views as $view => $screen ) {

		$dot_data_text = ( 'tabs' === $wpc->dot_style ) ? $screen : '';
		?>

		<div x-bind:style="<?php echo esc_attr( $wpc->store . '.getPreviewStyle( $el )' ); ?>" class="wpc-preview-inner wpc-<?php echo esc_attr( WPC_Utils::simplify_string( $view ) ); ?>" data-preview-inner data-dot="<?php echo esc_attr( $dot_data_text ); ?>" id="wpc-<?php echo esc_attr( WPC_Utils::simplify_string( $view ) . '-' . $wpc->id ); ?>" data-type="<?php echo esc_attr( $view ); ?>">

			<?php
			if ( ! empty( $wpc->active_uid ) ) {
				foreach ( $wpc->active_uid as $key => $uid ) {
					echo wp_kses( $wpc->get_subset_html( $uid, $view ), WPC_Utils::allowed_tags() );
				}
			}

			// Hotspot.
			if ( ! empty( $wpc->hotspots ) ) {
				echo $wpc->get_hotspot_html( $view ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/**
			 * Hook: After image subset element html.
			 *
			 * * @since 2.0
			 * * @version 3.4
			 *
			 * @param string  $view Configurator current view.
			 * @param WPCSE   $wpc WPCSE Class.
			 */
			do_action( 'wpc_after_subset', $view, $wpc );
			?>

		</div> <!-- .wpc-preview-inner -->
		<?php
	}
}
