<?php
/**
 * Admin View: Config Mail Action.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.2.2
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;
?>

<ul class="order_actions submitbox">

	<li class="wide" id="actions">
		<select name="wpc_config_mail_action">
			<option value=""><?php esc_html_e( 'Choose an action...', 'wp-configurator-pro' ); ?></option>
			<option value="send_request_details"><?php esc_html_e( 'Email invoice / Request details to customer', 'wp-configurator-pro' ); ?></option>
		</select>
		<button id="wpc-config-apply-mail-action" data-id="<?php echo esc_attr( $post->ID ); ?>" class="button"><span><?php esc_html_e( 'Apply', 'wp-configurator-pro' ); ?></span></button>
	</li>

	<li class="wide">
		<div id="delete-action">
			<?php
			if ( current_user_can( 'delete_post', $post->ID ) ) {

				if ( ! EMPTY_TRASH_DAYS ) {
					$delete_text = __( 'Delete permanently', 'wp-configurator-pro' );
				} else {
					$delete_text = __( 'Move to Trash', 'wp-configurator-pro' );
				}
				?>
				<a class="submitdelete deletion" href="<?php echo esc_url( get_delete_post_link( $post->ID ) ); ?>"><?php echo esc_html( $delete_text ); ?></a>
				<?php
			}
			?>
		</div>

		<button type="submit" class="button save_order button-primary" name="save" value="<?php echo 'auto-draft' === $post->post_status ? esc_attr__( 'Create', 'wp-configurator-pro' ) : esc_attr__( 'Update', 'wp-configurator-pro' ); ?>"><?php echo 'auto-draft' === $post->post_status ? esc_html__( 'Create', 'wp-configurator-pro' ) : esc_html__( 'Update', 'wp-configurator-pro' ); ?></button>
	</li>

</ul>