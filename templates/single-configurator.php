<?php
/**
 * Single configurator template.
 *
 * @package  wp-configurator-pro/templates/
 * @since  2.0
 * @version  3.4.12
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$config_id = get_the_id();
$desc      = WPC_Utils::get_meta_value( $config_id, '_wpc_description', '' );

get_header();

if ( ! WPC_Utils::is_database_upto_current_version( $config_id ) ) {
	WPC_Utils::update_notice();
	return;
}

$post_class = array();
$post_class[] = 'wpc-single-product-wrap';

$post_class = apply_filters( 'wpc_single_product_wrapper_classes', $post_class );

?>

<div id="wrapper">

	<div class="container">

		<div id="product-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>

			<div class="wpc-single-product-content clearfix">

				<div class="wpc-single-product-titlewrap">

					<?php the_title( '<h2 class="wpc-single-product-title">', '</h2>', true ); ?>

					<?php
					if ( ! empty( $desc ) ) :
						echo wp_kses_post( $desc );
					endif;
					?>

				</div> <!-- .wpc-single-product-titlewrap -->

				<?php
				/**
				 * Hook: Before configurator shortcode.
				 *
				 * * @since 3.4.13
				 */
				do_action( 'wpc_before_configurator_skin' );

				WPC_Utils::get_template( 'configurator-shortcode.php' );

				/**
				 * Hook: After configurator shortcode.
				 *
				 * * @since 2.6
				 */
				do_action( 'wpc_after_configurator_skin' );
				?>

			</div> <!-- .wpc-single-product-content -->

		</div> <!-- .wpc-single-product-wrap -->

	</div>

</div>

<?php
get_footer();
