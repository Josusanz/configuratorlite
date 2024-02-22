<?php
/**
 * Quote Form template.
 *
 * @package  wp-configurator-pro/templates/elements/
 * @since  3.1.1
 * @version  3.5.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

$product = ( WPC_WOO_ACTIVE ) ? wc_get_product( $wpc->product_id ) : false;

$form_class = array();
$form_class[] = 'wpc-form';
$form_class[] = 'wpc-quote-form';

/**
 * Filter: Quote form wrapper classes.
 *
 * * @since 3.4.12
 *
 * @param array   $classes Control wrapper classes.
 * @param object       $wpc WPCSE Class.
 */
$form_class = apply_filters( 'wpc_quote_form_wrapper_classes', $form_class, $wpc );
?>
<form x-data class="<?php echo esc_attr( implode( ' ', $form_class ) ); ?>" data-form action="" method="post" enctype='multipart/form-data'>
	<span class="wpc-notice wpc-error" x-text="<?php echo esc_attr( $wpc->store . '.getNotice("disabled")' ); ?>"></span>
	<span class="wpc-notice wpc-success" x-text="<?php echo esc_attr( $wpc->store . '.getNotice("success")' ); ?>"></span>

	<h4 class="wpc-form-title"><?php echo esc_html( $wpc->form_title ); ?></h4>

	<?php
	/**
	 * Hook: Before quote form fields.
	 *
	 * * @since 2.0
	 *
	 * @param int        $wpc->id Configurator ID.
	 * @param object     $wpc WPCSE Class.
	 */
	do_action( 'wpc_before_quote_form_field', $wpc->id, $wpc );

	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		$user_email   = $current_user->user_email;
	}

	$user_email = isset( $user_email ) ? $user_email : '';
	?>

	<div class="wpc-mail-form-values">

		<?php
		if ( apply_filters( 'wpc_allow_name_field_on_quote_form', true ) ) {
			WPC_Utils::field(
				array(
					'id'          => 'name',
					'label'        => esc_html__( 'Name', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->name_placeholder ),
					'type'        => 'text',
					'error'       => array(
						'id'    => 'name',
						'store' => $wpc->store,
					),
				)
			);
		}		

		if ( apply_filters( 'wpc_allow_email_field_on_quote_form', true ) ) {
			WPC_Utils::field(
				array(
					'id'          => 'email',
					'label'       => esc_html__( 'Email', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->email_placeholder ),
					'default'     => esc_attr( sanitize_email( $user_email ) ),
					'type'        => 'text',
					'error'       => array(
						'id'    => 'email',
						'store' => $wpc->store,
					),
				)
			);
		}

		if ( apply_filters( 'wpc_allow_phone_field_on_quote_form', true ) ) {
			WPC_Utils::field(
				array(
					'id'          => 'phone',
					'label'       => esc_html__( 'Phone', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->phone_placeholder ),
					'type'        => 'text',
				)
			);
		}

		$billing_fields = get_option( 'wpc_get_quote_billing_fields', 'disable' );

		if ( 'enable' === $billing_fields ) {
			WPC_Utils::field(
				array(
					'id'          => 'country',
					'label'       => esc_html__( 'Country', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->country_placeholder ),
					'type'        => 'text',
					'error'       => array(
						'id'    => 'country',
						'store' => $wpc->store,
					),
				)
			);

			WPC_Utils::field(
				array(
					'id'          => 'address',
					'label'       => esc_html__( 'Address', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->address_placeholder ),
					'type'        => 'text',
					'error'       => array(
						'id'    => 'address',
						'store' => $wpc->store,
					),
				)
			);

			WPC_Utils::field(
				array(
					'id'   => 'address',
					'type' => 'wrap_start',
					'attr' => array(
						'class' => 'wpc-field-group-set',
					),
				)
			);

			WPC_Utils::field(
				array(
					'id'          => 'city',
					'label'       => esc_html__( 'City', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->city_placeholder ),
					'type'        => 'text',
					'error'       => array(
						'id'    => 'city',
						'store' => $wpc->store,
					),
				)
			);

			WPC_Utils::field(
				array(
					'id'          => 'state',
					'label'       => esc_html__( 'State', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->state_placeholder ),
					'type'        => 'text',
					'error'       => array(
						'id'    => 'state',
						'store' => $wpc->store,
					),
				)
			);

			WPC_Utils::field(
				array(
					'id'          => 'zip',
					'label'       => esc_html__( 'Postal Code', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->zip_placeholder ),
					'type'        => 'text',
					'error'       => array(
						'id'    => 'zip',
						'store' => $wpc->store,
					),
				)
			);

			WPC_Utils::field(
				array(
					'id'   => 'address',
					'type' => 'wrap_end',
				)
			);
		}

		/**
		 * Hook: Before quote form message field.
		 *
		 * * @since 2.0
		 *
		 * @param int        $wpc->id Configurator ID.
		 * @param object     $wpc WPCSE Class.
		*/
		do_action( 'wpc_quote_form_field_before_message', $wpc->id, $wpc );

		if ( apply_filters( 'wpc_allow_message_field_on_quote_form', true ) ) {
			WPC_Utils::field(
				array(
					'id'          => 'message',
					'label'       => esc_html__( 'Message', 'wp-configurator-pro' ),
					'placeholder' => esc_attr( $wpc->message_placeholder ),
					'type'        => 'textarea',
					'error'       => array(
						'id'    => 'message',
						'store' => $wpc->store,
					),
				)
			);
		}

		$gdpr_implementation = get_option( 'wpc_gdpr_implementation', 'disable' );

		if ( WPC_Utils::str_to_bool( $gdpr_implementation ) ) {
			WPC_Utils::field(
				array(
					'id'       => 'gdpr',
					'label'    => esc_html( $wpc->gdpr_label ),
					'multiple' => false,
					'type'     => 'checkbox',
					'error'    => array(
						'id'    => 'gdpr',
						'store' => $wpc->store,
					),
				)
			);
		}

		echo $wpc->get_required_fields(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		WPC_Utils::field(
			array(
				'id'      => 'action',
				'default' => 'wpc_get_quote_submit',
				'type'    => 'hidden',
			)
		);
		?>

		<?php
		/**
		 * Hook: After quote form fields.
		 *
		 * * @since 2.0
		 *
		 * @param int        $wpc->id Configurator ID.
		 * @param object     $wpc WPCSE Class.
		 */
		do_action( 'wpc_after_quote_form_field', $wpc->id, $wpc );
		?>

	</div> <!-- .wpc-mail-form-values -->		

	<?php
	/**
	 * Hook: Before quote form submit button.
	 *
	 * * @since 2.0
	 *
	 * @param int        $wpc->id Configurator ID.
	 * @param object     $wpc WPCSE Class.
	 */
	do_action( 'wpc_before_quote_form_submit_button', $wpc->id, $wpc );

	WPC_Utils::field(
		array(
			'id'    => 'submit',
			'class' => 'wpc-primary-btn wpc-btn-text',
			'label' => esc_html( $wpc->submit_btn_text ),
			'type'  => 'button',
		)
	);
	?>

</form> <!-- .cart -->
