<?php
/**
 * Header logo template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.2.5
 * @version  3.2.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$logo = get_option( 'wpc_logo', '' );
$logo = str_replace( '\\', '', $logo );
$logo = ! empty( $logo ) ? json_decode( $logo ) : '';

if ( empty( $logo ) ) {
	?>
	<div id="wpc-logo">
		<a href="<?php echo esc_url( get_home_url() ); ?>"><img src="<?php echo esc_url( WPC_ASSETS_URL . '/frontend/img/logo.png' ); ?>" alt=""></a>
	</div>
	<?php
} else {
	$logo_url = ( null !== $logo[0]->itemId ) ? wp_get_attachment_image_src( $logo[0]->itemId, 'full' ) : '';
	if ( ! empty( $logo_url[0] ) ) {
		?>
		<div id="wpc-logo"><a href="<?php echo esc_url( get_home_url() ); ?>"><img src="<?php echo esc_url( $logo_url[0] ); ?>" alt=""></a></div>
		<?php
	}
}
