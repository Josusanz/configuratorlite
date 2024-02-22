<?php
/**
 * Admin View: Tools Page.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.4.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( isset( $_POST['wpc_tool_delete_inspiration_category'] ) ) {
	$inspiration_category = isset( $_POST['wpc_tool_inspiration_category'] ) ? $_POST['wpc_tool_inspiration_category'] : array();

	foreach ( $inspiration_category as $key => $term_id ) {
		wp_delete_term( $term_id, 'wpc_inspirations_cat' );
	}
}

$default_inspirations_cat = (int) get_option( 'default_term_wpc_inspirations_cat' );

$inspirations_terms = get_terms(
	array(
		'taxonomy'   => 'wpc_inspirations_cat',
		'hide_empty' => false,
	)
);

if ( isset( $_POST['wpc_tool_reset_editor_images'] ) ) {

	$editor_images_configurator = isset( $_POST['wpc_tool_editor_images_configurator'] ) ? $_POST['wpc_tool_editor_images_configurator'] : array();

	foreach ( $editor_images_configurator as $key => $config_id ) {

		$editor_images = get_post_meta( $config_id, '_wpc_editor_images', true );
		$views         = get_post_meta( $config_id, '_wpc_views', true );

		$redefined_images = WPC_Utils::get_rebuild_editor_images( $config_id, $views, $editor_images );

		update_post_meta( $config_id, '_wpc_editor_images', $redefined_images );
	}
}

?>

<div class="wpc-settings-wrap wpc-tools-wrap page-tab-status">

	<div class="wpc-options-wrap">
		<div class="fields-group active">
			<div class="fields-group-inner">

				<form method="POST">

					<div class="wpc-options">
						<div class="wpc-pull-left">
							<label><?php esc_html_e( 'Delete Inspiration Category', 'wp-configurator-pro' ); ?></label>
							<p class="description"><?php esc_html_e( 'This tool will help you to delete the inspiration category.', 'wp-configurator-pro' ); ?></p>
						</div>
						<div class="wpc-pull-right">
							<select name="wpc_tool_inspiration_category[]" multiple>
								<?php
								foreach ( $inspirations_terms as $key => $term ) {
									if ( $default_inspirations_cat === $term->term_id ) {
										continue;
									}
									?>
									<option value="<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_html( $term->name ); ?></option>
									<?php
								}
								?>
							</select>
							<button type="submit" name="wpc_tool_delete_inspiration_category" class="button button-primary"><?php esc_html_e( 'Deletea', 'wp-configurator-pro' ); ?></button>
						</div>
					</div>

					<div class="wpc-options">
						<div class="wpc-pull-left">
							<label><?php esc_html_e( 'Reset Preview Image', 'wp-configurator-pro' ); ?></label>
							<p class="description"><?php esc_html_e( 'If you accidently uploaded the higher resolution image and delete the layer, still preview broken.', 'wp-configurator-pro' ); ?></p>
						</div>
						<div class="wpc-pull-right">
							<select name="wpc_tool_editor_images_configurator[]" multiple>
								<?php
								$configurators = WPC_Utils::get_configurators();

								unset( $configurators[0] );

								foreach ( $configurators as $id => $configurator ) {
									?>
									<option value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $configurator ); ?></option>
									<?php
								}
								?>
							</select>
							<button type="submit" name="wpc_tool_reset_editor_images" class="button button-primary"><?php esc_html_e( 'Rebuild Image Data', 'wp-configurator-pro' ); ?></button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
