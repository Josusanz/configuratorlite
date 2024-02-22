<?php
/**
 * Admin View: Config Mail Summary.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.2.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$summary    = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_summary', '' );
$config_id  = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_id', '' );
$product_id = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_product_id', '' );
$encoded    = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_encoded', '' );

$post_thumbnail_id = get_post_thumbnail_id( $post );

$allowed_html = array(
	'div'  => array(
		'class' => array(),
	),
	'span' => array(
		'class' => array(),
	),
	'ul'   => array(
		'class' => array(),
	),
	'li'   => array(
		'class' => array(),
	),
);

$permalink = ! empty( $product_id ) ? get_permalink( $product_id ) : get_permalink( $config_id );

$share_link = add_query_arg(
	array(
		'key' => $encoded,
	),
	$permalink
);
?>
<style type="text/css">
	#wpc-user-config-summary .postbox-header { display:none }
</style>
<div class="wpc-user-config-summary-panel-wrap">
	<h3>
		<?php esc_html_e( 'User Configurations', 'wp-configurator-pro' ); ?>
		<a href="<?php echo esc_url( $share_link ); ?>" class="wpc-btn button-primary" target="_blank"><?php echo esc_html( get_option( 'wpc_view_configuration_btn_text', esc_html__( 'View Configuration', 'wp-configurator-pro' ) ) ); ?></a>
	</h3>
	<div class="wpc-user-config-summary-panel-inner">
		<?php echo WPC_Utils::get_image( $post_thumbnail_id, false ); ?>
		<?php echo wp_kses( $summary, $allowed_html ); ?>
	</div>
</div>
