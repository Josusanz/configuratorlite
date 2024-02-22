<?php
/**
 * Customer new request a quote email
 *
 * @package  wp-configurator-pro/templates/
 * @since  2.5
 * @version  2.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;
?>
						</div>
					</td>
				</tr>
				<tr id="wpc-mail-footer-text">
					<td valign="top">
						<div>
							<p><?php echo sprintf( __( 'Thanks for using %s', 'wp-configurator-pro' ), esc_html( get_bloginfo( 'name', 'display' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>



