<?php
/**
 * Admin View: Quick Edit Configurator.
 *
 * @package  wp-configurator-pro/includes/admin/views
 * @version  3.5.1
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;
?>

<fieldset id="wpc-quick-edit-fields" class="inline-edit-col-center">
	<legend class="inline-edit-legend"><?php esc_html_e( 'Configurator data', 'wp-configurator-pro' ); ?></legend>
	<div class="inline-edit-col">
		<?php
		if ( WPC_WOO_ACTIVE ) {
			$products = WPC_Utils::get_products();
			WPC_Utils::field(
				array(
					'id'       => '_wpc_product_id',
					'label'    => esc_html__( 'Choose Product(Pro)', 'wp-configurator-pro' ),
					'type'     => 'select',
					'default'  => '0',
					'options'  => $products,
					'disabled' => true,
				)
			);
		}

		$styles = WPC_Utils::get_styles();
		WPC_Utils::field(
			array(
				'id'               => '_wpc_config_style',
				'label'            => esc_html__( 'Choose Style', 'wp-configurator-pro' ),
				'type'             => 'select',
				'default'          => 'accordion',
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

		$forms = WPC_Utils::get_forms();
		WPC_Utils::field(
			array(
				'id'               => '_wpc_form',
				'label'            => esc_html__( 'Choose Form', 'wp-configurator-pro' ),
				'type'             => 'select',
				'default'          => 'quote-form',
				'options'          => $forms,
				'disabled_options' => array(
					'cart-form',
					'contact-form',
				),
			)
		);

		$contact_forms = WPC_Utils::get_contact_forms();
		WPC_Utils::field(
			array(
				'id'       => '_wpc_contact_form',
				'label'    => esc_html__( 'Contact Form(Pro)', 'wp-configurator-pro' ),
				'type'     => 'select',
				'default'  => '0',
				'options'  => $contact_forms,
				'disabled' => true,
			)
		);
		?>
	</div>

	<div class="inline-edit-col">
		<?php

		WPC_Utils::field(
			array(
				'id'    => '_wpc_base_price',
				'label' => esc_html__( 'Base Price', 'wp-configurator-pro' ),
				'type'  => 'text',
			)
		);

		WPC_Utils::field(
			array(
				'id'       => '_wpc_load_configurator_in',
				'label'    => esc_html__( 'Load Configurator in(Pro)', 'wp-configurator-pro' ),
				'type'     => 'select',
				'default'  => 'direct',
				'options'  => array(
					'direct'        => esc_html__( 'Directly in Product Page', 'wp-configurator-pro' ),
					'configure_btn' => esc_html__( 'Once Configure is clicked!', 'wp-configurator-pro' ),
				),
				'disabled' => true,
			)
		);

		WPC_Utils::field(
			array(
				'id'       => '_wpc_configurator_template',
				'label'    => esc_html__( 'Configurator Template(Pro)', 'wp-configurator-pro' ),
				'type'     => 'select',
				'default'  => 'entire_product_page',
				'options'  => array(
					'entire_product_page' => esc_html__( 'Replace Entire Product Page', 'wp-configurator-pro' ),
					'summary_area'        => esc_html__( 'Override Product Detail as Configurator', 'wp-configurator-pro' ),
				),
				'disabled' => true,
			)
		);
		?>
	</div>
	<div class="inline-edit-col">
		<?php
		WPC_Utils::field(
			array(
				'id'    => '_wpc_description',
				'label' => esc_html__( 'Description', 'wp-configurator-pro' ),
				'type'  => 'textarea',
			)
		);

		WPC_Utils::field(
			array(
				'id'      => '_wpc_quick_edit_save_configurator',
				'type'    => 'hidden',
				'default' => '1',
			)
		);
		?>
	</div>
</fieldset>
