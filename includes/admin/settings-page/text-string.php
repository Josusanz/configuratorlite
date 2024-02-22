<?php
/**
 * Design option setting page.
 *
 * @package  wp-configurator-pro/includes/admin/settings-page/
 * @version  3.0
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$field = array();

/* Form Fields --------------------------------------------------------------------  */

$general[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$general[] = array(
	'title' => esc_html__( 'General', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Base Price Text', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter base price text.', 'wp-configurator-pro' ),
	'id'    => 'wpc_base_price_text',
	'std'   => esc_html__( 'Base Price', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Total Price Text', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter total price text.', 'wp-configurator-pro' ),
	'id'    => 'wpc_total_price_text',
	'std'   => esc_html__( 'Total Price', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'type' => 'control-end',
);

$general[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$general[] = array(
	'title' => esc_html__( 'Summary', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'View Summary Button Text', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter view summary button text.', 'wp-configurator-pro' ),
	'id'    => 'wpc_view_summary_btn_text',
	'std'   => esc_html__( 'View Summary', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Build Summary Title', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter build summary popup title.', 'wp-configurator-pro' ),
	'id'    => 'wpc_build_summary_title',
	'std'   => esc_html__( 'Build Summary', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'type' => 'control-end',
);

$general[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$general[] = array(
	'title' => esc_html__( 'Get a Quote', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Get a Quote Form Title', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter get a quote form popup title.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_form_title',
	'std'   => esc_html__( 'Get a Quote', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Get a Quote Button Text', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter get a quote button text.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_btn_text',
	'std'   => esc_html__( 'Get a Quote', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Get a Quote Submit Button Text', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter get a quote submit button text.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_submit_btn_text',
	'std'   => esc_html__( 'Submit', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Name Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter name input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_name_placeholder',
	'std'   => esc_html__( 'Enter your name', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Email Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter email input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_email_placeholder',
	'std'   => esc_html__( 'Enter email address', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Phone Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter phone input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_phone_placeholder',
	'std'   => esc_html__( 'Enter phone number', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Message Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter message input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_message_placeholder',
	'std'   => esc_html__( 'Type your message', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Country/Region Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter country/region input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_country_placeholder',
	'std'   => esc_html__( 'Country/Region', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Address Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter address input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_address_placeholder',
	'std'   => esc_html__( 'Street Address', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'City Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter city input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_city_placeholder',
	'std'   => esc_html__( 'Town/City', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'State Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter state input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_state_placeholder',
	'std'   => esc_html__( 'State', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Postal Code Placeholder', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter postal code input field placeholder.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_zip_placeholder',
	'std'   => esc_html__( 'Postal Code', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'GDPR Label', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter the GDPR label.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_gdpr_label',
	'std'   => esc_html__( 'By using this form you agree with the terms and conditions of this website.', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Success Notice', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter the success notice.', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_success_notice',
	'std'   => esc_html__( 'Successfully requested for a Quote, Check your e-mail for the verifications.', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'type' => 'control-end',
);
?>


<div class="wrap">
	<?php
	$addons_lists = apply_filters( 'wpc_addons_allow_text_string_settings', array() );
	$addons_lists = array_merge(
		array(
			'general' => esc_html__( 'General', 'wp-configurator-pro' ),
		),
		$addons_lists
	);

	$subtab = isset( $_GET['subtab'] ) ? $_GET['subtab'] : 'general';
	?>
	<ul class="subsubsub">
		<?php
		if ( ! empty( $addons_lists ) ) {
			foreach ( $addons_lists as $key => $addon ) {
				$current = ( $key == $subtab ) ? 'current' : '';
				?>
				<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=text-string&subtab=<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $current ); ?>"><?php echo esc_html( $addon ); ?></a></li>
				<?php
			}
		}
		?>
	</ul> <!-- .subsubsub -->
	<?php

	if ( 'general' === $subtab ) {
		$settings = new wpc_option_fields( $general );
	} else {
		do_action( 'wpc_addons_' . $subtab . '_text_string_settings_fields' );
	}
	?>
</div>
