<?php
/**
 * Typography setting page.
 *
 * @package  wp-configurator-pro/includes/admin/settings-page/
 * @version  2.0
 */

use WPCPelago\WPC_Emogrifier\WPC_CssInliner;

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$field = array();

$field[] = array(
	'type'  => 'control-start',
	'class' => 'controls-cart',
);

$field[] = array(
	'title' => esc_html__( 'General', 'wp-configurator-pro' ),
	'type'  => 'title',
);

$field[] = array(
	'title'   => esc_html__( 'Primary Font', 'wp-configurator-pro' ),
	'id'      => 'wpc_primary_font',
	'std'     => 'inherit',
	'type'    => 'select',
	'options' => array_merge(
		array(
			'inherit' => esc_html__( 'Inherit', 'wp-xonfigurator-pro' ),
		),
		WPC_Utils::get_google_fonts()
	),
);

$field[] = array(
	'title'   => esc_html__( 'Secondary Font', 'wp-configurator-pro' ),
	'id'      => 'wpc_secondary_font',
	'std'     => 'inherit',
	'type'    => 'select',
	'options' => array_merge(
		array(
			'inherit' => esc_html__( 'Inherit', 'wp-xonfigurator-pro' ),
		),
		WPC_Utils::get_google_fonts()
	),
);

$field[] = array(
	'title'   => esc_html__( 'Font Weight', 'wp-configurator-pro' ),
	'id'      => 'wpc_font_weight',
	'std'     => array( 400, 600 ),
	'type'    => 'checkbox',
	'options' => array(
		'100' => 100,
		'200' => 200,
		'300' => 300,
		'400' => 400,
		'500' => 500,
		'600' => 600,
		'700' => 700,
		'900' => 900,
	),
);

$field[] = array(
	'type' => 'control-end',
);
?>

<div class="wrap">
	<?php
	$addons_lists = apply_filters( 'wpc_addons_allow_typography_settings', array() );
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
				<li><a href="?post_type=amz_configurator&page=wpc-settings&tab=typography&subtab=<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $current ); ?>"><?php echo esc_html( $addon ); ?></a></li>
				<?php
			}
		}
		?>
	</ul> <!-- .subsubsub -->

	<?php

	if ( 'general' === $subtab ) {
		$settings = new wpc_option_fields( $field );
	} else {
		do_action( 'wpc_addons_' . $subtab . '_typography_settings_fields' );
	}
	?>
</div>
