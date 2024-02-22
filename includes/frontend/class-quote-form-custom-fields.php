<?php
/**
 * Quote form custom fields.
 *
 * @package  wp-configurator-pro/includes/
 * @since  3.2.3
 * @version  3.5
 */

/*
To add custom fields for the configurator quote form, add the code in the child theme functions.php file and adjust it.

Example:

$fields[] = array(
	'id'          => 'custom_field_1',
	'name'        => esc_html__( 'Custom Field 1', 'text-domain' ),
	'placeholder' => esc_html__( 'Custom Field 1', 'text-domain' ),
	'type'        => 'text',
	'required'    => true,
);

$fields[] = array(
	'id'          => 'custom_field_2',
	'name'        => esc_html__( 'Custom Field 2', 'text-domain' ),
	'placeholder' => esc_html__( 'Custom Field 2', 'text-domain' ),
	'type'        => 'textarea',
	'required'    => true,
);

$fields[] = array(
	'id'          => 'custom_field_3',
	'name'        => esc_html__( 'Custom Field 3', 'text-domain' ),
	'placeholder' => esc_html__( 'Custom Field 3', 'text-domain' ),
	'type'        => 'radio',
	'options'     => array(
		'opt1' => esc_html__( 'One', 'text-domain' ),
		'opt2' => esc_html__( 'Two', 'text-domain' ),
		'opt3' => esc_html__( 'Three', 'text-domain' ),
	),
);

$fields[] = array(
	'id'          => 'custom_field_4',
	'name'        => esc_html__( 'Custom Field 4', 'text-domain' ),
	'placeholder' => esc_html__( 'Custom Field 4', 'text-domain' ),
	'type'        => 'select',
	'options'     => array(
		'' => esc_html__( 'Choose Option', 'text-domain' ),
		'opt1' => esc_html__( 'One', 'text-domain' ),
		'opt2' => esc_html__( 'Two', 'text-domain' ),
		'opt3' => esc_html__( 'Three', 'text-domain' ),
	),
	'required'    => true,
);

new WPC_Quote_Form_Custom_Fields( $fields );
*/
defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Quote_Form_Custom_Fields' ) ) {

	/**
	 * WooCommerce cart custom fields.
	 */
	class WPC_Quote_Form_Custom_Fields {

		/**
		 * Constructor.
		 *
		 * @param array $fields Custom fields.
		 */
		public function __construct( $fields ) {

			$this->fields = $fields;

			add_action( 'wpc_quote_form_field_before_message', array( $this, 'quote_form_field_before_message' ), 10, 2 );
			add_filter( 'wpc_quote_form_mail_post_values', array( $this, 'quote_form_mail_post_values' ), 10, 2 );
			add_action( 'wpc_quote_form_field_validation', array( $this, 'quote_form_field_validation' ), 10, 2 );
			add_action( 'wpc_config_mail_list_after_customer_details', array( $this, 'config_mail_additional_info' ) );
			add_action( 'wpc_admin_request_quote_after_customer_details', array( $this, 'config_mail_additional_info' ) );
			add_action( 'wpc_customer_request_quote_after_billing_details', array( $this, 'config_mail_additional_info' ) );
			add_filter( 'wpc_user_config_additional_details', array( $this, 'user_config_additional_details' ), 10, 2 );
		}

		/**
		 * Add custom fields before get quote mail message field.
		 *
		 * @return void
		 */
		public function quote_form_field_before_message( $id, $wpc ) {

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $index => $field ) {

					$id          = isset( $field['id'] ) ? $field['id'] : '';
					$name        = isset( $field['name'] ) ? $field['name'] : '';
					$placeholder = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
					$default     = isset( $field['default'] ) ? $field['default'] : '';
					$options     = isset( $field['options'] ) ? $field['options'] : array();
					$class       = isset( $field['class'] ) ? $field['class'] : '';

					echo '<div class="wpc-field-group ' . ( $class ) . ' ">';
					echo '<span class="wpc-field-title">' . esc_html( $name ) . '</span>';
					switch ( $field['type'] ) {
						case 'text':
						case 'email':
						case 'number':
							echo '<div class="wpc-field-textfield">';
							echo '<input type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $id ) . '" placeholder="' . esc_attr( $placeholder ) . '">';
							echo '<span class="error ' . esc_attr( $id ) . '-error" x-text="' . esc_attr( $wpc->store . '.getNotice("' . esc_attr( $id ) . '")' ) . '"></span>';
							echo '</div>';
							break;

						case 'textarea':
							echo '<div class="wpc-field-textarea">';
							echo '<textarea name="' . esc_attr( $id ) . '" placeholder="' . esc_attr( $placeholder ) . '"></textarea>';
							echo '<span class="error ' . esc_attr( $id ) . '-error" x-text="' . esc_attr( $wpc->store . '.getNotice("' . esc_attr( $id ) . '")' ) . '"></span>';
							echo '</div>';
							break;

						case 'radio':
							foreach ( $options as $key => $option ) {
								echo '<div class="wpc-field-radio">';
								echo '<input type="radio" id="' . esc_attr( $key ) . '" name="' . esc_attr( $id ) . '" value="' . esc_attr( $key ) . '" ' . checked( $default, esc_attr( $key ), false ) . '>';
								echo '<label for="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</label>';
								echo '</div>';
							}
							break;

						case 'select':
							echo '<div class="wpc-field-select">';
							echo '<select name="' . esc_attr( $id ) . '">';
							foreach ( $options as $key => $option ) {
								echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
							}
							echo '</select>';
							echo '<span class="error ' . esc_attr( $id ) . '-error" x-text="' . esc_attr( $wpc->store . '.getNotice("' . esc_attr( $id ) . '")' ) . '"></span>';
							echo '</div>';
							break;

						default:
							break;
					}

					echo '<span class="error" data-notice-' . esc_attr( $id ) . '="true"></span>';

					echo '</div>';
				}
			}

		}

		/**
		 * Add custom values to cart data.
		 *
		 * @return array
		 */
		public function quote_form_mail_post_values( $values ) {
			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$id = isset( $field['id'] ) ? $field['id'] : '';

					$values[ $id ] = ( isset( $_POST[ $id ] ) && ! empty( $_REQUEST[ $id ] ) ) ? $_POST[ $id ] : '';
				}

				return $values;
			}
		}

		/**
		 * Quote form validation.
		 *
		 * @param array $values Post values.
		 * @param array $errors Validation errors.
		 * @return void
		 */
		public function quote_form_field_validation( $values, $errors ) {

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$id       = isset( $field['id'] ) ? $field['id'] : '';
					$name     = isset( $field['name'] ) ? $field['name'] : '';
					$required = isset( $field['required'] ) ? $field['required'] : 'false';

					if ( $required && empty( $values[ $id ] ) ) {
						/* translators: %s Field name. */
						$errors->add( $id, sprintf( esc_html__( '%s field is empty.', 'textdomain' ), $name ) );
					}
				}
			}
		}

		/**
		 * Additional Info.
		 *
		 * @param array $values Post values.
		 * @return void
		 */
		public function config_mail_additional_info( $values ) {
			?>
			<div id="wpc-mail-additional-info">
				<h2><?php esc_html_e( 'Additional Info:', 'wp-configurator-pro' ); ?></h2>
				<table width="100%">
					<tbody>
						<?php
						if ( ! empty( $this->fields ) ) {
							foreach ( $this->fields as $key => $field ) {
								?>
								<tr>
									<th><?php echo esc_html( $field['name'] ); ?></th>
									<td><?php echo esc_html( $values[ $field['id'] ] ); ?></td>
								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
			<?php
		}

		/**
		 * User config additional details.
		 *
		 * @param string $content Info.
		 * @param array $values Post values.
		 * @return string
		 */
		public function user_config_additional_details( $content = '', $values = array() ) {

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {
					$content .= '<p>';
					$content .= '<strong>' . esc_html( $field['name'] ) . ':</strong> ';
					$content .= '<span>' . esc_html( $values[ $field['id'] ] ) . '</span>';
					$content .= '</p>';
				}
			}

			return $content;
		}
	}

}
