<?php
/**
 * Accordion skin template.
 *
 * @package  wp-configurator-pro/templates/skin/
 * @version  3.4.8
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

?>

<div id="wpc-configurator-wrap-<?php echo esc_attr( $wpc->id ); ?>" class="<?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?>">
	<?php
	$wpc->get_preview_html( true );
	$wpc->floating_icons( true );
	?>

	<div class="wpc-summary wpc-entry-summary">
		<?php
		$wpc->get_controls_html( true );
		$wpc->total_price_html( true );
		$wpc->share_inline( true );
		$wpc->form_summary( true );
		?>
	</div> <!-- .wpc-summary -->

</div> <!-- .wpc-single-product-wrap -->
