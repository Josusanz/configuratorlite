<?php
/**
 * Header mobile menu template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2.5
 * @version  3.2.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$classes[] = 'wpc-mobile-nav-parent-wrap';
$classes[] = 'wpc-config-element';
$classes[] = 'wpc-config-element-' . esc_attr( $wpc->id );
$classes[] = 'wpc-mobile-nav';

$classes = array_filter( array_merge( $classes, array( $wpc->extra_class ) ) );

/**
 * Filter: Mobile nav element wrapper classes.
 *
 * * @since 3.0
 *
 * @param array   $classes Mobile nav wrapper classes.
 */
$classes = apply_filters( 'wpc_mobile_nav_wrapper_classes', $classes );
?>
<!-- Navigation append using JS -->
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wpc-flyin-logo">
		<?php $wpc->get_flyin_logo( true ); ?>
		<a href="#" class="wpc-close-btn js-wpc-mobile-nav-close-trigger">
			<i class="<?php echo esc_attr( WPC_Utils::icon( 'close' ) ); ?>"></i>
		</a>
	</div>
	<div class="wpc-mobile-inner"></div>
</div>
