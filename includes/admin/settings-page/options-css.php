<?php
/**
 * Custom CSS setting page.
 *
 * @package  wp-configurator-pro/includes/admin/settings-page/
 * @since  2.0
 * @version  2.5.2
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$settings = wp_enqueue_code_editor(
	array(
		'type'       => 'text/css',
		'codemirror' => array(
			'indentUnit' => 2,
			'tabSize'    => 4,
		),
	)
);

if ( isset( $_POST['wpc_update_css'] ) && ! preg_match( '#</?\w+#', $_POST['wpc_custom_css'] ) ) {
	update_option( 'wpc_custom_css', stripcslashes( $_POST['wpc_custom_css'] ) );
}

$custom_css = get_option( 'wpc_custom_css' );

?>

<div class="wrap">
	<h3><?php esc_html_e( 'Custom CSS', 'wp-configurator-pro' ); ?></h3>
	<form method="post">

		<table class="form-table">
			<tbody>
				<tr>
					<td>
						<textarea name="wpc_custom_css" id="css_editor" class="code" style="display: none;"><?php echo $custom_css; ?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input name="wpc_update_css" type="submit" value="<?php esc_attr_e( 'Save', 'wp-configurator-pro' ); ?>" class="button-primary submit-btn"/>
					</td>
				</tr>
			</tbody>
		</table>

	</form>
</div>
