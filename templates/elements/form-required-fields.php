<?php
/**
 * Required Field template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.1
 * @version  3.4.11
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$update = isset( $_GET['update'] ) ? $_GET['update'] : 0;
$item   = isset( $_GET['item'] ) ? $_GET['item'] : 0;
?>
<div x-data class="wpc-hidden-inputs" data-config-id="<?php echo esc_attr( $wpc->id ); ?>">
<input type='hidden' name='wpc-encoded' x-bind:value='<?php echo esc_attr( $wpc->store . '.activeData.encoded' ); ?>'>
<input type='hidden' name='wpc-active-tree-set' x-bind:value='<?php echo esc_attr( 'JSON.stringify(' . $wpc->store . '.treeSet )' ); ?>'>
<input type="hidden" name="wpc-config-id" value="<?php echo esc_attr( $wpc->id ); ?>" />
<input type="hidden" name="wpc-product-id" value="<?php echo esc_attr( $wpc->product_id ); ?>" />
<input type="hidden" name="wpc-request-id" value="<?php echo esc_attr( $wpc->request_id ); ?>">
<input type="hidden" name="wpc-config-image" value="">
<input type="hidden" name="update" value="<?php echo esc_attr( $update ); ?>">
<input type="hidden" name="item" value="<?php echo esc_attr( $item ); ?>">
<input type="hidden" name="redirect" value="<?php echo esc_url( WPC_Utils::current_url() ); ?>">
<?php
/**
 * Hook: Add custom hidden fields.
 *
 * * @since 2.0
 *
 * @param int    $wpc->id Configurator ID.
 */
do_action( 'wpc_hidden_fields', $wpc->id, $wpc );
?>
</div>
