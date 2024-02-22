<?php
/**
 * Core options fields class.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @version  3.4.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( ! class_exists( 'wpc_option_fields' ) ) {

	class wpc_option_fields {

		private $fields;
		private $fields_html = '';

		public function __construct( $fields ) {

			$this->fields = $fields;

			$this->save_form_fields( $fields );
			$this->reset_form_fields( $fields );
			$this->form_fields( $fields );

		}

		public function form_fields( $fields ) {

			$this->fields_html .= '<form method="POST">';

				$this->fields_html .= '<div class="wpc-options-wrap">';

			foreach ( $fields as $key => $field ) {

				// Default
				$field_type   = isset( $field['type'] ) ? $field['type'] : '';
				$field_id     = isset( $field['id'] ) ? $field['id'] : '';
				$title        = isset( $field['title'] ) ? $field['title'] : '';
				$desc         = isset( $field['desc'] ) ? $field['desc'] : '';
				$placeholder  = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
				$std          = isset( $field['std'] ) ? $field['std'] : '';
				$mode         = isset( $field['mode'] ) ? $field['mode'] : '';
				$options      = isset( $field['options'] ) ? $field['options'] : '';
				$multi_select = isset( $field['multi_select'] ) ? $field['multi_select'] : false;
				$class        = isset( $field['class'] ) ? $field['class'] : '';

				if ( isset( $field['id'] ) ) {

					$value = get_option( $field_id, $std );

					$this->fields_html .= '<div class="wpc-options" id="' . esc_attr( $field_id ) . '">';

						// Left Side Content
						$this->fields_html .= '<div class="wpc-pull-left">';

							$this->fields_html .= '<label for="' . esc_attr( $field_id ) . '" class="wpc-sub-title">' . ucwords( esc_html( $title ) ) . '</label>';

					if ( isset( $desc ) && ! empty( $desc ) ) {
						$this->fields_html .= '<p class="description">' . $desc . '</p>';
					}

						$this->fields_html .= '</div>'; // .wpc-pull-left

						// Right Side Content
						$this->fields_html .= '<div class="wpc-pull-right">';

					switch ( $field_type ) {

						case 'text':
						case 'number':
						case 'email':
						case 'tel':
						case 'url':
							$this->fields_html .= '<input name="' . esc_attr( $field_id ) . '" type="' . esc_attr( $field_type ) . '" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $value ) . '" class="textfield ' . esc_attr( $mode ) . '">';
							break;

						case 'textarea':
							$this->fields_html .= '<textarea name="' . esc_attr( $field_id ) . '" placeholder="' . esc_attr( $placeholder ) . '" class="textarea ' . esc_attr( $mode ) . '">' . esc_html( $value ) . '</textarea>';
							break;

						case 'select':
							if ( ! empty( $options ) ) {

								$field_id = ( $multi_select ) ? $field_id . '[]' : $field_id;

								$multiple_attr = ( $multi_select ) ? 'multiple' : '';

								$this->fields_html .= '<select name="' . esc_attr( $field_id ) . '" ' . esc_attr( $multiple_attr ) . '>';
								foreach ( $options as $key => $opt ) {

									$selected = $this->is_selected( $value, $key, $multi_select );

									$this->fields_html .= '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" ' . ( $selected ? ' selected="selected"' : '' ) . '>' . esc_html( $opt ) . '</option>';
								}
								$this->fields_html .= '</select>';
							}

							break;

						case 'checkbox':
							if ( ! empty( $options ) ) {
								$this->fields_html .= '<div class="wpc-options-wrap">';
								foreach ( $options as $key => $opt ) {
									$this->fields_html     .= '<div class="wpc-options-inner">';
										$this->fields_html .= '<input name="' . esc_attr( $field_id ) . '[]" type="checkbox" value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" ' . ( in_array( $key, $value ) ? 'checked' : '' ) . '>';
										$this->fields_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $opt ) . '</label>';
									$this->fields_html     .= '</div>'; // .wpc-options-inner
								}
								$this->fields_html .= '</div>';
							}

							break;

						case 'radio':
							if ( ! empty( $options ) ) {
								$this->fields_html .= '<div class="wpc-options-wrap">';
								foreach ( $options as $key => $opt ) {
									$this->fields_html     .= '<div class="wpc-options-inner">';
										$this->fields_html .= '<input name="' . esc_attr( $field_id ) . '" type="radio" value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" ' . checked( $value, $key, false ) . '>';
										$this->fields_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $opt ) . '</label>';
									$this->fields_html     .= '</div>';
								}
								$this->fields_html .= '</div>';
							}

							break;

						case 'switch':
							if ( ! empty( $options ) ) {
								$this->fields_html .= '<input name="' . esc_attr( $field_id ) . '" type="hidden" value="' . esc_attr( $value ) . '" id="' . esc_attr( $field_id ) . '">';
								$this->fields_html .= '<div class="wpc-options-wrap">';
								foreach ( $options as $key => $opt ) {
									$active = ( $key == $value ) ? 'active' : '';

									$this->fields_html .= '<span data-value="' . esc_attr( $key ) . '" class="wpc-switch ' . esc_attr( $active ) . '">' . esc_html( $opt ) . '</span>';
								}
								$this->fields_html .= '</div>';
							}

							break;

						case 'colorpicker':
							$this->fields_html .= '<input name="' . esc_attr( $field_id ) . '" type="text" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $value ) . '" class="color-picker">';
							break;

						case 'media_manager':
							if ( ! empty( $options ) ) {

								$value = stripslashes( $value );

								$this->fields_html     .= '<div class="media-upload-input-wrap">';
									$this->fields_html .= '<input type="hidden" class="media-upload-val" name="' . esc_attr( $field_id ) . '" value="' . esc_attr( $value ) . '">';
									$this->fields_html .= '<a href="#" class="select-files" data-title="' . esc_attr__( 'Select File', 'wp-configurator-pro' ) . '"  data-file-type="' . esc_attr( $options ) . '" data-multi-select="' . esc_attr( $multi_select ) . '" data-insert="true">' . esc_html( $title ) . '</a>';
								$this->fields_html     .= '</div>';

							}

							break;

						case 'edd_license':
							$license = get_option( 'wpc_license_key' );
							$status  = get_option( 'wpc_license_status' );

							$this->fields_html .= '<input name="' . esc_attr( $field_id ) . '" type="text" placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $value ) . '" class="textfield large">';

							if ( false !== $license ) {

								if ( $status !== false && $status == 'valid' ) {

									$this->fields_html .= '<span style="color:green;">' . __( 'active', 'wp-configurator-pro' ) . '</span>';

									wp_nonce_field( 'wpc_license_nonce', 'wpc_license_nonce' );

									$this->fields_html .= '<input type="submit" class="button-secondary" name="edd_license_deactivate" value="' . __( 'Deactivate License', 'wp-configurator-pro' ) . '"/>';
								} else {
									wp_nonce_field( 'wpc_license_nonce', 'wpc_license_nonce' );

									$this->fields_html .= '<input type="submit" class="button-secondary" name="edd_license_activate" value="' . __( 'Activate License', 'wp-configurator-pro' ) . '"/>';

								}
							}

							break;

						default:
							break;
					}

					$this->fields_html .= '</div>'; // .wpc-pull-right

					$this->fields_html .= '</div>'; // .wpc-options
				} elseif ( 'title' === $field_type && ! empty( $title ) ) {
					$this->fields_html .= '<h3 class="title">' . esc_html( $title ) . '<span class="' . esc_attr( WPC_Utils::icon( 'angle-down' ) ) . '"></span></h3><div class="fields-group-inner">';
				} elseif ( 'control-start' === $field_type ) {
					$this->fields_html .= '<div class="fields-group ' . esc_attr( ( 0 === $key ? 'active' : '' ) ) . '">';
				} elseif ( 'control-end' === $field_type ) {
					$this->fields_html .= '</div></div>';
				}
			}

				$this->fields_html .= '</div>'; // .wpc-options-wrap

				$this->fields_html .= '<input name="wpc_reset_settings" type="submit" value="' . esc_attr__( 'Reset settings', 'wp-configurator-pro' ) . '" class="button-primary button-red submit-btn"/>';

				$this->fields_html .= '<input name="wpc_update_settings" type="submit" value="' . esc_attr__( 'Save settings', 'wp-configurator-pro' ) . '" class="button-primary submit-btn"/>';

			$this->fields_html .= '</form>';

			echo $this->fields_html;
		}

		public function is_selected( $value, $current = '', $multiple = false ) {

			if ( $multiple ) {
				return in_array( $current, $value, true );
			} else {
				return ( $value == $current );
			}
		}

		public function save_form_fields( $fields ) {

			if ( isset( $_POST['wpc_update_settings'] ) ) {
				foreach ( $fields as $key => $field ) {

					if ( isset( $field['id'] ) ) {

						$field_id = isset( $field['id'] ) ? $field['id'] : '';
						$std      = isset( $field['std'] ) ? $field['std'] : '';

						$value = isset( $_POST[ $field_id ] ) ? $_POST[ $field_id ] : $std;

						update_option( $field_id, $value, true );
					}
				}
			}
		}

		public function reset_form_fields( $fields ) {

			if ( isset( $_POST['wpc_reset_settings'] ) ) {
				foreach ( $fields as $key => $field ) {

					if ( isset( $field['id'] ) ) {

						$field_id = isset( $field['id'] ) ? $field['id'] : '';
						$std      = isset( $field['std'] ) ? $field['std'] : '';

						update_option( $field_id, $std, true );
					}
				}
			}
		}

	}
}
