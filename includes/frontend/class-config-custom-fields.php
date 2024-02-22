<?php
/**
 * Config custom fields.
 *
 * @package  wp-configurator-pro/includes/
 * @since  3.1
 * @version  3.4.11
 */

/*
To add custom fields for the configurator cart form, please add the below code in the child theme functions.php file and adjust it.

Example:

add_action( 'wpc_shortcode_initialized', function( $wpc = null, $code = '' ) {
	if ( class_exists( 'WPC_Config_Custom_Fields' ) ) {

		$fields = array();

		// It only appears on the specific configurator.
		if( {configID} === $wpc->id ) { // Change config ID
			$fields[] = array(
				'id'          => 'custom_field_1',
				'name'        => esc_html__( 'Custom Field 1', 'text-domain' ),
				'placeholder' => esc_html__( 'Custom Field 1', 'text-domain' ),
				'type'        => 'text',
				'default'     => '',
				'price'       => 5,
				'class'       => '',
			);
		}

		$fields[] = array(
			'id'          => 'custom_field_2',
			'name'        => esc_html__( 'Custom Field 2', 'text-domain' ),
			'placeholder' => esc_html__( 'Custom Field 2', 'text-domain' ),
			'type'        => 'textarea',
			'default'     => '',
			'price'       => 10,
			'class'       => '',
		);

		$fields[] = array(
			'id'          => 'custom_field_3',
			'name'        => esc_html__( 'Custom Field 3', 'text-domain' ),
			'placeholder' => esc_html__( 'Custom Field 3', 'text-domain' ),
			'type'        => 'radio',
			'default'     => 'opt2',
			'options'     => array(
				'opt1' => esc_html__( 'One', 'text-domain' ),
				'opt2' => esc_html__( 'Two', 'text-domain' ),
				'opt3' => esc_html__( 'Three', 'text-domain' ),
			),
			'price'       => array(
				'opt1' => 10,
				'opt2' => 20,
				'opt3' => 30,
			),
			'class'       => '',
		);

		$fields[] = array(
			'id'          => 'custom_field_4',
			'name'        => esc_html__( 'Custom Field 4', 'text-domain' ),
			'placeholder' => esc_html__( 'Custom Field 4', 'text-domain' ),
			'type'        => 'select',
			'default'     => 'opt2',
			'options'     => array(
				'opt1' => esc_html__( 'One', 'text-domain' ),
				'opt2' => esc_html__( 'Two', 'text-domain' ),
				'opt3' => esc_html__( 'Three', 'text-domain' ),
			),
			'price'       => array(
				'opt1' => 50,
				'opt2' => 100,
				'opt3' => 150,
			),
			'class'       => '',
		);

		// To prevent duplicate field, if shortcode used.
		if ( 'wpc_config_accordion_control' === $code || 'wpc_config_controls' === $code || 'wpc_config_popover_control' === $code || 'wpc_config' === $code ) {
			new WPC_Config_Custom_Fields( $fields );
		}
	}

}, 10, 2 );

*/
defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Config_Custom_Fields' ) ) {

	/**
	 * WooCommerce cart custom fields.
	 */
	class WPC_Config_Custom_Fields {

		/**
		 * Constructor.
		 *
		 * @param array $fields Custom fields.
		 */
		public function __construct( $fields ) {

			$this->fields = $fields;

			add_action( 'wpc_after_controls_html', array( $this, 'after_controls_html' ) );
			add_action( 'wpc_after_controls_html', array( $this, 'localize_scripts' ) );
			add_action( 'wpc_hidden_fields', array( $this, 'hidden_fields' ), 10, 2 );
			add_filter( 'wpc_cart_data', array( $this, 'cart_data' ) );
			add_filter( 'wpc_cart_items_data', array( $this, 'cart_items_data' ), 10, 2 );
			add_filter( 'wpc_cart_cutom_price_sub_total', array( $this, 'cart_cutom_price_sub_total' ), 10, 2 );
			add_filter( 'wpc_cart_cutom_price', array( $this, 'cart_cutom_price' ), 10, 2 );
			add_action( 'wpc_order_item_meta', array( $this, 'order_item_meta' ), 10, 4 );
			add_action( 'wpc_summary_lists', array( $this, 'summary_lists' ) );
			add_filter( 'wpc_summary_total', array( $this, 'summary_total' ), 10, 2 );
			add_filter( 'wpc_wpcf7_form_fields', array( $this, 'wpcf7_form_fields' ) );
			add_filter( 'wpc_has_custom_fields', array( $this, 'has_custom_fields' ) );

		}

		/**
		 * Add custom fields to global script data.
		 *
		 * @return void
		 */
		public function localize_scripts() {
			wp_localize_script(
				'wpc-utils',
				'wpc_config_custom_fields',
				$this->fields
			);
		}

		/**
		 * Add custom fields after the controls.
		 *
		 * @param object $wpc WPCSE class.
		 * @return void
		 */
		public function after_controls_html( $wpc = null ) {

			$this->store = '$store.config_' . $wpc->id;

			echo '<form x-data class="wpc-custom-field-form" data-custom-field-form data-config-id="' . esc_attr( $wpc->id ) . '">';

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $index => $field ) {

					$id          = isset( $field['id'] ) ? $field['id'] : '';
					$name        = isset( $field['name'] ) ? $field['name'] : '';
					$placeholder = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
					$default     = isset( $field['default'] ) ? $field['default'] : '';
					$options     = isset( $field['options'] ) ? $field['options'] : array();
					$price       = isset( $field['price'] ) ? $field['price'] : '';
					$class       = isset( $field['class'] ) ? $field['class'] : '';

					echo '<div class="wpc-field-group ' . esc_attr( $class ) . '">';
					echo '<span class="wpc-field-title">' . esc_html( $name ) . '</span>';
					switch ( $field['type'] ) {
						case 'text':
							echo '<div class="wpc-field-textfield">';
								echo '<input 
									x-on:input="' . esc_attr( $this->store ) . '.setCustomFieldPrice($el)"
									type="text" name="' . esc_attr( $id ) . '" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $default ) . '">';
							echo '</div>';
							break;

						case 'textarea':
							echo '<div class="wpc-field-textarea">';
								echo '<textarea x-on:input="' . esc_attr( $this->store ) . '.setCustomFieldPrice($el)" type="text" name="' . esc_attr( $id ) . '" placeholder="' . esc_attr( $placeholder ) . '">' . esc_html( $default ) . '</textarea>';
							echo '</div>';
							break;

						case 'radio':
							foreach ( $options as $key => $option ) {
								echo '<div class="wpc-field-radio">';
									echo '<input x-on:change="' . esc_attr( $this->store ) . '.setCustomFieldPrice($el)" type="radio" id="' . esc_attr( $key ) . '" name="' . esc_attr( $id ) . '" value="' . esc_attr( $key ) . '" ' . checked( $default, $key, false ) . '>';
									echo '<label for="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</label>';
								echo '</div>';
							}
							break;

						case 'select':
							echo '<div class="wpc-field-select">';
								echo '<select x-on:change="' . esc_attr( $this->store ) . '.setCustomFieldPrice($el)" name="' . esc_attr( $id ) . '">';
							foreach ( $options as $key => $option ) {
								echo '<option value="' . esc_attr( $key ) . '" ' . selected( $default, $key, false ) . '>' . esc_html( $option ) . '</option>';
							}
								echo '</select>';
							echo '</div>';
							break;

						default:
							break;
					}
					echo '</div>';
				}
			}

			echo '</form>';

		}

		/**
		 * Add custom hidden fields.
		 *
		 * @param integer $config_id Configurator ID.
		 * @param object $wpc WPCSE class.
		 * @return void
		 */
		public function hidden_fields( $config_id = 0, $wpc = null ) {

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $index => $field ) {

					$id   = isset( $field['id'] ) ? $field['id'] : '';
					$name = isset( $field['name'] ) ? $field['name'] : '';

					echo '<input type="hidden" name="' . esc_attr( $id ) . '" x-bind:value="' . esc_attr( $wpc->store . '.customFields.' . $id . '.value' ) . '">';
				}
			}

		}

		/**
		 * Add custom values to cart data.
		 *
		 * @return array
		 */
		public function cart_data() {
			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$id = isset( $field['id'] ) ? $field['id'] : '';

					$value[ $id ] = ( isset( $_REQUEST[ $id ] ) && ! empty( $_REQUEST[ $id ] ) ) ? $_REQUEST[ $id ] : '';
				}

				return $value;
			}
		}

		/**
		 * Add custom values to cart items data.
		 *
		 * @param array $item_data Default variation data.
		 * @param array $cart_item Cart item array.
		 * @return array
		 */
		public function cart_items_data( $item_data, $cart_item ) {

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$id    = isset( $field['id'] ) ? $field['id'] : '';
					$name  = isset( $field['name'] ) ? $field['name'] : '';
					$price = isset( $field['price'] ) ? $field['price'] : '';

					$value = isset( $cart_item[ $id ] ) ? $cart_item[ $id ] : '';

					if ( ! empty( $value ) ) {

						if ( is_array( $price ) ) {
							$price = isset( $price[ $cart_item[ $id ] ] ) ? $price[ $cart_item[ $id ] ] : 0;
						}

						$item_data[] = array(
							'key'     => $name,
							'value'   => '<span class="custom item-title-wrap">' . $value . '(' . wc_price( $price ) . ')</span>',
							'display' => '',
						);
					}
				}

				return $item_data;
			}

			return $item_data;
		}

		/**
		 * Add custom price.
		 *
		 * @param float $custom_price Total configurator price.
		 * @param array $cart_item Cart order item array.
		 * @return float
		 */
		public function cart_cutom_price( $custom_price, $cart_item ) {
			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$price = isset( $field['price'] ) ? $field['price'] : 0;

					if ( ! empty( $cart_item[ $field['id'] ] ) ) {

						if ( is_array( $price ) ) {
							$price = isset( $price[ $cart_item[ $field['id'] ] ] ) ? $price[ $cart_item[ $field['id'] ] ] : 0;
						}

						$custom_price += $price;
					}
				}

				return $custom_price;
			}
		}

		/**
		 * Add custom details to order details and email.
		 *
		 * @param object   $item Cart item.
		 * @param string   $cart_item_key The cart item key.
		 * @param array    $values The values.
		 * @param WC_Order $order Order instance.
		 * @return void
		 */
		public function order_item_meta( $item, $cart_item_key, $values, $order ) {

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {
					$id   = isset( $field['id'] ) ? $field['id'] : '';
					$name = isset( $field['name'] ) ? $field['name'] : '';

					$meta = isset( $values[ $id ] ) ? $values[ $id ] : '';

					$item->add_meta_data( $name, $meta );
				}
			}
		}

		/**
		 * Add custom price in sub total.
		 *
		 * @param float $total Total configurator price.
		 * @param array $value Cart item values.
		 * @return float
		 */
		public function cart_cutom_price_sub_total( $total, $value ) {

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$id = isset( $field['id'] ) ? $field['id'] : '';

					$price = isset( $field['price'] ) ? $field['price'] : 0;

					if ( ! empty( $value[ $id ] ) ) {

						if ( is_array( $price ) ) {
							$price = isset( $price[ $value[ $id ] ] ) ? $price[ $value[ $id ] ] : 0;
						}

						$total += $price;
					}
				}

				return $total;
			}
		}

		/**
		 * Add custom field to the summary lists.
		 *
		 * @param int $config_id Configurator ID.
		 * @return void
		 */
		public function summary_lists( $config_id = 0 ) {
			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$id   = isset( $field['id'] ) ? $field['id'] : '';
					$name = isset( $field['name'] ) ? $field['name'] : '';

					$value = ( isset( $_POST[ $id ] ) && ! empty( $_POST[ $id ] ) ) ? $_POST[ $id ] : '';

					$price = isset( $field['price'] ) ? $field['price'] : 0;

					if ( ! empty( $value ) ) {

						if ( is_array( $price ) ) {
							$price = isset( $price[ $value ] ) ? $price[ $value ] : 0;
						}

						echo '<li>';
						echo '<span class="wpc-summary-list-title">' . esc_html( $name ) . '</span>';
						echo '<span class="wpc-sign"> - </span>';
						echo '<span class="wpc-summary-list-group-price">' . WPC_Utils::price( $price ) . '</span>';
						echo '</li>';
					}
				}
			}
		}

		/**
		 * Add custom fields price to the total.
		 *
		 * @param float $total Total configurator price.
		 * @param float $base_price Configurator base price.
		 * @return float
		 */
		public function summary_total( $total = '', $base_price = '' ) {
			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$id = isset( $field['id'] ) ? $field['id'] : '';

					$value = ( isset( $_POST[ $id ] ) && ! empty( $_POST[ $id ] ) ) ? $_POST[ $id ] : '';

					$price = isset( $field['price'] ) ? $field['price'] : 0;

					if ( ! empty( $value ) ) {

						if ( is_array( $price ) ) {
							$price = isset( $price[ $value ] ) ? $price[ $value ] : 0;
						}

						$total += isset( $price ) ? $price : 0;
					}
				}
			}

			return $total;
		}

		/**
		 * Add custom fields hidden input in Contact Form 7
		 *
		 * @param array $fields Form fields.
		 * @return array
		 */
		public function wpcf7_form_fields( $fields = array() ) {

			if ( ! empty( $this->fields ) ) {
				foreach ( $this->fields as $key => $field ) {

					$id      = isset( $field['id'] ) ? $field['id'] : '';
					$default = isset( $field['default'] ) ? $field['default'] : '';

					$fields[ $id ] = $default;
				}
			}

			return $fields;
		}

		/**
		 * Has any custom fields?
		 *
		 * @param array $fields Form fields.
		 * @return array
		 */
		public function has_custom_fields() {
			return ! empty( $this->fields ) ? true : false;
		}
	}

}
