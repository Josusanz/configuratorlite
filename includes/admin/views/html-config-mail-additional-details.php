<?php
/**
 * Admin View: Config Mail Request Details.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.2.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$info = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_additional_info', esc_html__( 'Custom field data or contact form 7 form values( if you added it in the additional information section ).', 'wp-configurator-pro' ) );
?>
<style type="text/css">
	#wpc-user-config-additional-details .postbox-header { display:none }
</style>
<div class="wpc-user-config-additional-details-panel-wrap">
	<h3 class="wpc-user-config-additional-details-heading"><?php esc_html_e( 'Additional Details', 'wp-configurator-pro' ); ?></h3>
	<div>
	<?php
	echo wp_kses(
		$info,
		array(
			'p'      => array(),
			'strong' => array(),
			'span'   => array(),
		)
	);
	?>
	</div>
</div>
