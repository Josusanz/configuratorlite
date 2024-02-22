<?php
/**
 * General setting page.
 *
 * @package  wp-configurator-pro/includes/admin/settings-page/
 * @since  2.0
 * @version  3.4.11
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$general = array();
$field   = array();

$general[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$general[] = array(
	'title' => esc_html__( 'General', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'Thumb Size', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter thumbnail size in integer value. It should be between 150 and 800.', 'wp-configurator-pro' ),
	'id'    => 'wpc_thumb_size',
	'std'   => 300,
	'type'  => 'text',
);

$general[] = array(
	'title'   => esc_html__( 'Show/Hide Item Price', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Do you want to show item prices in summary?', 'wp-configurator-pro' ),
	'id'      => 'wpc_price_details',
	'std'     => 'show',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Show', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Hide', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Show/Hide Group Price', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Do you want to show group prices in summary?', 'wp-configurator-pro' ),
	'id'      => 'wpc_group_price',
	'std'     => 'show',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Show', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Hide', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Show/Hide Total Price', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Do you want to show total price?', 'wp-configurator-pro' ),
	'id'      => 'wpc_total_price',
	'std'     => 'show',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Show', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Hide', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Remove Price is Empty', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Do you want to remove price in the control and summary, if it is zero?', 'wp-configurator-pro' ),
	'id'      => 'wpc_remove_price_is_empty',
	'std'     => 'false',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Show/Hide Summary', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Do you want to show summary?', 'wp-configurator-pro' ),
	'id'      => 'wpc_summary_popup',
	'std'     => 'show',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Show', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Hide', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'        => esc_html__( 'Allowed Fonts', 'wp-configurator-pro' ),
	'id'           => 'wpc_allowed_fonts',
	'std'          => array(),
	'type'         => 'select',
	'multi_select' => true,
	'options'      => WPC_Utils::get_google_fonts(),
);

$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

$menu_list['none'] = esc_html__( 'None', 'wp-configurator-pro' );

foreach ( $menus as $key => $slug ) {
	if ( isset( $slug->name ) ) {
		$menu_list[ $slug->slug ] = $slug->name;
	}
}

$general[] = array(
	'title'        => esc_html__( 'Logo', 'wp-configurator-pro' ),
	'desc'         => esc_html__( 'Choose logo.', 'wp-configurator-pro' ),
	'id'           => 'wpc_logo',
	'std'          => '',
	'type'         => 'media_manager',
	'multi_select' => 'false',
	'options'      => 'image',
);

$general[] = array(
	'title'        => esc_html__( 'Flyin Logo', 'wp-configurator-pro' ),
	'desc'         => esc_html__( 'Choose logo.', 'wp-configurator-pro' ),
	'id'           => 'wpc_flyin_logo',
	'std'          => '',
	'type'         => 'media_manager',
	'multi_select' => 'false',
	'options'      => 'image',
);

$general[] = array(
	'title'   => esc_html__( 'Menu', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Choose menu location.', 'wp-configurator-pro' ),
	'id'      => 'wpc_menu',
	'std'     => '',
	'type'    => 'select',
	'options' => $menu_list,
);

$general[] = array(
	'title'   => esc_html__( 'Meta Pixel', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Is the site has enabled the Meta pixel?', 'wp-configurator-pro' ),
	'id'      => 'wpc_meta_pixel',
	'std'     => 'disable',
	'type'    => 'select',
	'options' => array(
		'enable'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'disable' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'type' => 'control-end',
);

if ( ! WPC_WOO_ACTIVE ) {
	$general[] = array(
		'type'  => 'control-start',
		'class' => 'controls-currency',
	);

	$general[] = array(
		'title' => esc_html__( 'Currency', 'wp-configurator-pro' ),
		'type'  => 'title',
	);

	$general[] = array(
		'title'   => esc_html__( 'Select Currency', 'wp-configurator-pro' ),
		'id'      => 'wpc_currency',
		'std'     => WPC_Utils::currency(),
		'type'    => 'select',
		'options' => array( '' => esc_html__( 'Select Currency', 'wp-configurator-pro' ) ) + WPC_Utils::get_currencies(),
	);

	$general[] = array(
		'title'   => esc_html__( 'Currency Position', 'wp-configurator-pro' ),
		'id'      => 'wpc_currency_pos',
		'std'     => 'left_space',
		'type'    => 'select',
		'options' => array(
			'left'        => esc_html__( 'Left', 'wp-configurator-pro' ),
			'right'       => esc_html__( 'Right', 'wp-configurator-pro' ),
			'left_space'  => esc_html__( 'Left with space', 'wp-configurator-pro' ),
			'right_space' => esc_html__( 'Right with space', 'wp-configurator-pro' ),
		),
	);

	$general[] = array(
		'title' => esc_html__( 'Thousand separator', 'wp-configurator-pro' ),
		'id'    => 'wpc_price_thousand_sep',
		'type'  => 'text',
		'mode'  => 'mini',
	);

	$general[] = array(
		'title' => esc_html__( 'Decimal separator', 'wp-configurator-pro' ),
		'id'    => 'wpc_price_decimal_sep',
		'type'  => 'text',
		'mode'  => 'mini',
	);

	$general[] = array(
		'title' => esc_html__( 'Number of decimals', 'wp-configurator-pro' ),
		'id'    => 'wpc_price_num_decimals',
		'type'  => 'number',
		'mode'  => 'mini',
	);

	$general[] = array(
		'type' => 'control-end',
	);
}

$general[] = array(
	'type'  => 'control-start',
	'class' => 'controls-slider',
);

$general[] = array(
	'title' => esc_html__( 'Preview Slider', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title'   => esc_html__( 'Dots', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_dot_style',
	'std'     => 'dots',
	'type'    => 'select',
	'options' => array(
		'none' => esc_html__( 'None', 'wp-configurator-pro' ),
		'dots' => esc_html__( 'Dots', 'wp-configurator-pro' ),
		'tabs' => esc_html__( 'Tab', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Dot Position', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_dot_position',
	'std'     => 'bottom',
	'type'    => 'select',
	'options' => array(
		'bottom' => esc_html__( 'Bottom', 'wp-configurator-pro' ),
		'top'    => esc_html__( 'Top', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Navigation', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_nav',
	'std'     => 'false',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title' => esc_html__( 'Initial View', 'wp-configurator-pro' ),
	'id'    => 'wpc_preview_slide_start_position',
	'std'   => '0',
	'type'  => 'number',
	'mode'  => 'mini',
);

$general[] = array(
	'title'   => esc_html__( 'Touch Drag', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_touch_drag',
	'std'     => 'false',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Mouse Drag', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_mouse_drag',
	'std'     => 'true',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Touch Drag Mobile', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_touch_drag_mobile',
	'std'     => 'false',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Mouse Drag Mobile', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_mouse_drag_mobile',
	'std'     => 'false',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Touch Drag Tablet', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_touch_drag_tablet',
	'std'     => 'false',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Mouse Drag Tablet', 'wp-configurator-pro' ),
	'id'      => 'wpc_preview_slide_mouse_drag_tablet',
	'std'     => 'false',
	'type'    => 'select',
	'options' => array(
		'true'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'false' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'type' => 'control-end',
);

$general[] = array(
	'type'  => 'control-start',
	'class' => 'controls-cart',
);

$general[] = array(
	'title' => esc_html__( 'Mail Settings', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$general[] = array(
	'title' => esc_html__( 'From name', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'How the sender name appears in outgoing Configurator emails.', 'wp-configurator-pro' ),
	'id'    => 'wpc_email_from_name',
	'std'   => esc_attr( get_bloginfo( 'name', 'display' ) ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'From address', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'How the sender email appears in outgoing Configurator emails.', 'wp-configurator-pro' ),
	'id'    => 'wpc_email_from_address',
	'std'   => get_option( 'admin_email' ),
	'type'  => 'text',
);

$general[] = array(
	'title'   => esc_html__( 'Billing Form Fields', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Do you want to add the billing address fields in the quote form.', 'wp-configurator-pro' ),
	'id'      => 'wpc_get_quote_billing_fields',
	'std'     => 'disable',
	'type'    => 'select',
	'options' => array(
		'enable'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'disable' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title'   => esc_html__( 'Admin Mail Recipient(s)', 'wp-configurator-pro' ),
	'id'      => 'wpc_get_quote_mail_to',
	'std'     => 'all-admin',
	'type'    => 'select',
	'options' => array(
		'all-admin'   => esc_html__( 'All Administrator', 'wp-configurator-pro' ),
		'custom-user' => esc_html__( 'Custom Recipient', 'wp-configurator-pro' ),
	),
);

$general[] = array(
	'title' => esc_html__( 'Custom Recipient(s)', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_mail_custom_user',
	'desc'  => esc_html__( 'Enter the Username seperated with | symbol.', 'wp-configurator-pro' ),
	'std'   => '',
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Admin Mail Subject', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter get a quote mail subject. Available placeholder: {site_title}', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_mail_subject',
	'std'   => esc_html__( 'New Request: #{request_id} has been received!', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Admin Mail Heading', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter get a quote mail heading. Available placeholder: {site_title}', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_admin_mail_heading',
	'std'   => esc_html__( 'Request Received', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Customer Mail Subject', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter get a quote mail subject. Available placeholder: {site_title}', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_customer_mail_subject',
	'std'   => esc_html__( 'Your {site_title} request has been received!', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title' => esc_html__( 'Customer Mail Heading', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter get a quote mail heading. Available placeholder: {site_title}', 'wp-configurator-pro' ),
	'id'    => 'wpc_get_quote_customer_mail_heading',
	'std'   => esc_html__( 'Thank you for your request', 'wp-configurator-pro' ),
	'type'  => 'text',
);

$general[] = array(
	'title'   => esc_html__( 'GDPR Implementation', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Want to add the GDPR implementation in Quote form.', 'wp-configurator-pro' ),
	'id'      => 'wpc_gdpr_implementation',
	'std'     => 'disable',
	'type'    => 'select',
	'options' => array(
		'enable'  => esc_html__( 'Enable', 'wp-configurator-pro' ),
		'disable' => esc_html__( 'Disable', 'wp-configurator-pro' ),
	),
);

$page_obj  = get_pages();
$all_pages = wp_list_pluck( $page_obj, 'post_title', 'ID' );

$general[] = array(
	'title'   => esc_html__( 'Greetings Page', 'wp-configurator-pro' ),
	'desc'    => esc_html__( 'Once successfully requested, it redirect to this page.', 'wp-configurator-pro' ),
	'id'      => 'wpc_get_quote_greetings_page',
	'std'     => '0',
	'type'    => 'select',
	'options' => array( '0' => esc_html__( 'Select Page', 'wp-configurator-pro' ) ) + $all_pages,
);

$general[] = array(
	'type' => 'control-end',
);

$field[] = array(
	'type'  => 'control-start',
	'class' => 'controls-group',
);

$field[] = array(
	'title' => esc_html__( 'Controls', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title'   => esc_html__( 'Type', 'wp-configurator-pro' ),
	'id'      => 'wpc_icon_type',
	'std'     => 'round',
	'type'    => 'select',
	'options' => array(
		'round'      => esc_html__( 'Round', 'wp-configurator-pro' ),
		'semi-round' => esc_html__( 'Semi Round', 'wp-configurator-pro' ),
		'square'     => esc_html__( 'Square', 'wp-configurator-pro' ),
	),
);

$field[] = array(
	'title' => esc_html__( 'Group Icon Width', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter icon width in integer value.', 'wp-configurator-pro' ),
	'id'    => 'wpc_group_icon_width',
	'std'   => '40',
	'type'  => 'number',
	'mode'  => 'mini',
);

$field[] = array(
	'title' => esc_html__( 'Group Icon Height', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter icon height in integer value.', 'wp-configurator-pro' ),
	'id'    => 'wpc_group_icon_height',
	'std'   => '40',
	'type'  => 'number',
	'mode'  => 'mini',
);

$field[] = array(
	'title' => esc_html__( 'Icon Width', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter icon width in integer value.', 'wp-configurator-pro' ),
	'id'    => 'wpc_icon_width',
	'std'   => '20',
	'type'  => 'number',
	'mode'  => 'mini',
);

$field[] = array(
	'title' => esc_html__( 'Icon Height', 'wp-configurator-pro' ),
	'desc'  => esc_html__( 'Enter icon height in integer value.', 'wp-configurator-pro' ),
	'id'    => 'wpc_icon_height',
	'std'   => '20',
	'type'  => 'number',
	'mode'  => 'mini',
);

$field[] = array(
	'type' => 'control-end',
);

?>

<div class="wrap">
	<?php
	$addons_lists = apply_filters( 'wpc_addons_allow_general_settings', array() );
	$addons_lists = array_merge(
		array(
			'general'             => esc_html__( 'General', 'wp-configurator-pro' ),
			'wp-configurator-pro' => esc_html__( 'WP Configurator Pro', 'wp-configurator-pro' ),
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
				<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=general&subtab=<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $current ); ?>"><?php echo esc_html( $addon ); ?></a></li>
				<?php
			}
		}
		?>
	</ul> <!-- .subsubsub -->

	<?php

	if ( 'general' === $subtab ) {
		$settings = new wpc_option_fields( $general );
	} elseif ( 'wp-configurator-pro' === $subtab ) {
		$settings = new wpc_option_fields( $field );
	} else {
		do_action( 'wpc_addons_' . $subtab . '_general_settings_fields' );
	}
	?>
</div>
