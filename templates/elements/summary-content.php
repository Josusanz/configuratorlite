<?php
/**
 * Form Summary content template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.4
 * @version  3.4.9
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

?>
<div class="wpc-summary-content-wrap">

	<div class="wpc-summary-content-inner">

		<div class="wpc-summary-content-inner-child">

			<?php
			/**
			 * Hook: Before summary list content.
			 *
			 * * @since 3.4
			 *
			 * @param WPCSE $wpc WPCSE Class.
			 */
			do_action( 'wpc_before_summary_list_content', $wpc );
			?>

			<?php if ( WPC_Utils::str_to_bool( $wpc->summary_popup ) ) : ?>
				<div class="wpc-summary-lists-wrap">
					<?php
					/**
					 * Hook: Summary content.
					 *
					 * @hooked wpc_summary_title_html - 10
					 * @hooked wpc_summary_list_html - 15
					 * @hooked wpc_summary_total_html - 20
					 *
					 * * @since 3.4
					 *
					 * @param WPCSE $wpc WPCSE Class.
					 */
					do_action( 'wpc_summary_list_content', $wpc );
					?>
				</div>
			<?php endif; ?>

			<?php
			/**
			 * Hook: After summary list content.
			 *
			 * @hooked wpc_summary_form_html - 10
			 *
			 * * @since 3.4
			 *
			 * @param WPCSE $wpc WPCSE Class.
			 */
			do_action( 'wpc_after_summary_list_content', $wpc );
			?>

		</div> <!-- .wpc-summary-content-inner-child -->

	</div>  <!-- .wpc-summary-content-inner -->

</div> <!-- .wpc-summary-content-wrap -->
