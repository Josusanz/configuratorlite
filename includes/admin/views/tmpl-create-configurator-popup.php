<?php
/**
 * Template: Create Configurator Popup.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.5.1
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;
?>

<script type="text/html" id="tmpl-wpc-create-configurator-popup-template">
	<div id="wpc-create-configurator-popup">
		<div class="wpc-overlay"></div>

		<div id="wpc-create-configurator-popup-wrap">
			<div id="wpc-create-configurator-popup-head">
				<h2 class="wpc-popup-main-title"><?php esc_html_e( 'New Configurator', 'wp-configurator-pro' ); ?></h2>
				<span id="wpc-close-create-config-popup" class="dashicons dashicons-no-alt"></span>
			</div>

			<div class="wpc-create-configurator-popup-inner-wrap">
				<div class="wpc-create-configurator-popup-inner">
					<div class="wpc-create-configurator-popup-description">
						<h3 class="wpc-popup-sub-title"><?php esc_html_e( 'Make Your Web Store Stand Out!', 'wp-configurator-pro' ); ?></span></h3>
						<p class="wpc-create-configurator-popup-desc"><?php esc_html_e( 'Offer visitors a truly different shopping experience and convert them to customers.', 'wp-configurator-pro' ); ?></p>
					</div>
					<div id="wpc-create-configurator-popup-create">
						<h3 class="wpc-popup-form-title"><?php esc_html_e( 'Create Configurator', 'wp-configurator-pro' ); ?></h3>
						<form id="wpc-create-config-submit">
							<?php
							WPC_Utils::field(
								array(
									'id'          => 'title',
									'label'       => esc_html__( 'Name a Configurator', 'wp-configurator-pro' ),
									'placeholder' => esc_attr__( 'Enter a configurator title', 'wp-configurator-pro' ),
									'type'        => 'text',
									'allow_error' => true,
								)
							);

							if ( WPC_WOO_ACTIVE ) {
								$products = WPC_Utils::get_products();
								WPC_Utils::field(
									array(
										'id'       => 'product',
										'label'    => esc_html__( 'Choose Product', 'wp-configurator-pro' ),
										'type'     => 'select',
										'options'  => array( '0' => esc_html__( 'Select a Product', 'wp-configurator-pro' ) ) + $products,
										'disabled' => true,
									)
								);
							}

							$styles = WPC_Utils::get_styles();
							WPC_Utils::field(
								array(
									'id'               => 'style',
									'label'            => esc_html__( 'Choose Style', 'wp-configurator-pro' ),
									'type'             => 'select',
									'options'          => $styles,
									'disabled_options' => array(
										'style1',
										'style2',
										'style3',
										'accordion-2',
										'popover',
									),
								)
							);

							WPC_Utils::field(
								array(
									'id'      => 'action',
									'type'    => 'hidden',
									'default' => 'wpc_create_config',
								)
							);

							WPC_Utils::field(
								array(
									'id'    => 'wpc_create_config_btn',
									'label' => esc_html__( 'Create', 'wp-configurator-pro' ),
									'type'  => 'button',
									'class' => 'button button-primary button-large',
								)
							);
							?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
