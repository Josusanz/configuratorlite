<?php
/**
 * AJAX callbacks.
 *
 * @package  wp-configurator-pro/includes/frontend/
 * @since  2.0
 * @version  3.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Ajax_Callback' ) ) {

	/**
	 * Frontend AJAX callbacks.
	 */
	class WPC_Ajax_Callback {

		/**
		 * Constructor.
		 */
		public function __construct() {

			add_action( 'wp_ajax_wpc_get_quote_submit', array( $this, 'get_quote_submit' ) );
			add_action( 'wp_ajax_nopriv_wpc_get_quote_submit', array( $this, 'get_quote_submit' ) );

			add_action( 'wp_ajax_wpc_before_submit_form', array( $this, 'before_submit_form' ) );
			add_action( 'wp_ajax_nopriv_wpc_before_submit_form', array( $this, 'before_submit_form' ) );

			add_action( 'wp_ajax_wpc_create_config', array( $this, 'create_config' ) );

			add_action( 'wp_ajax_wpc_update_post', array( $this, 'update_post' ) );

			add_action( 'wp_ajax_wpc_complete_tour', array( $this, 'complete_tour' ) );

			add_action( 'wp_ajax_wpc_save_invoice', array( $this, 'save_invoice' ) );
			add_action( 'wp_ajax_wpc_apply_invoice_action', array( $this, 'apply_invoice_action' ) );

		}

		/**
		 * It helps to add the custom hidden input data using ajax.
		 *
		 * @return void
		 */
		public function before_submit_form() {

			/**
			 * Hook: Before submitting form, helps to add the custom hidden input data using ajax.
			 *
			 * * @since 3.2
			*/
			do_action( 'wpc_before_submit_form' );

			die();
		}

		/**
		 * Save Get a Quote and Contact Form 7 user configuration mail in `Config Mail List` post type.
		 *
		 * @param array $args Configuration options.
		 * @return object
		 */
		public function save_user_customisation( $args = array() ) {

			$post_args = array(
				/* Translators: %s: Request ID */
				'post_title'  => sprintf( esc_html__( 'New Request: #%s', 'wp-configurator-pro' ), $args['request_id'] ),
				'post_status' => 'publish',
				'post_type'   => 'wpc_user_config',
				'post_author' => 1,
			);

			$post = wp_insert_post( $post_args );

			set_post_thumbnail( $post, $args['attachments'] );

			return $post;

		}

		/**
		 * Send get a quote email to the administrator and customer using AJAX.
		 *
		 * @return void
		 */
		public function get_quote_submit() {

			$errors = new WP_Error();

			$values = array();

			$values['encoded']         = ( isset( $_POST['wpc-encoded'] ) && ! empty( $_POST['wpc-encoded'] ) ) ? $_POST['wpc-encoded'] : '';
			$values['active_tree_set'] = ( isset( $_POST['wpc-active-tree-set'] ) && ! empty( $_POST['wpc-active-tree-set'] ) ) ? json_decode( stripslashes( $_POST['wpc-active-tree-set'] ), true ) : array();
			$values['name']            = isset( $_POST['name'] ) ? $_POST['name'] : '';
			$values['email']           = isset( $_POST['email'] ) ? $_POST['email'] : '';
			$values['phone']           = isset( $_POST['phone'] ) ? $_POST['phone'] : '';
			$values['message']         = isset( $_POST['message'] ) ? $_POST['message'] : '';
			$values['country']         = isset( $_POST['country'] ) ? $_POST['country'] : '';
			$values['address']         = isset( $_POST['address'] ) ? $_POST['address'] : '';
			$values['city']            = isset( $_POST['city'] ) ? $_POST['city'] : '';
			$values['state']           = isset( $_POST['state'] ) ? $_POST['state'] : '';
			$values['zip']             = isset( $_POST['zip'] ) ? $_POST['zip'] : '';
			$values['gdpr']            = isset( $_POST['gdpr'] ) ? $_POST['gdpr'] : '';
			$values['config_id']       = isset( $_POST['wpc-config-id'] ) ? $_POST['wpc-config-id'] : '';
			$values['product_id']      = isset( $_POST['wpc-product-id'] ) ? $_POST['wpc-product-id'] : '';
			$values['request_id']      = isset( $_POST['wpc-request-id'] ) ? $_POST['wpc-request-id'] : '';
			$values['image_data']      = isset( $_POST['wpc-config-image'] ) ? $_POST['wpc-config-image'] : '';
			$values['redirect']        = isset( $_POST['redirect'] ) ? $_POST['redirect'] : '';

			/**
			 * Filter: Get a quote mail post values.
			 *
			 * * @since 2.4
			 *
			 * @param array $values Post values.
			 */
			$values = apply_filters( 'wpc_quote_form_mail_post_values', $values );

			$values['info'] = apply_filters( 'wpc_user_config_additional_details', '', $values );

			if ( isset( $values['config_id'] ) ) {

				if ( empty( $values['name'] ) && apply_filters( 'wpc_quote_form_name_is_required', true ) ) {
					$errors->add( 'name', esc_html__( 'Name field is empty.', 'wp-configurator-pro' ) );
				}

				if ( empty( $values['email'] ) && apply_filters( 'wpc_quote_form_email_is_required', true ) ) {
					$errors->add( 'email', esc_html__( 'Email field is empty.', 'wp-configurator-pro' ) );
				}

				if ( empty( $values['phone'] ) && apply_filters( 'wpc_quote_form_phone_is_required', false ) ) {
					$errors->add( 'phone', esc_html__( 'Phone field is empty.', 'wp-configurator-pro' ) );
				}

				if ( empty( $values['message'] ) && apply_filters( 'wpc_quote_form_message_is_required', true ) ) {
					$errors->add( 'message', esc_html__( 'Message field is empty.', 'wp-configurator-pro' ) );
				}

				$billing_fields = get_option( 'wpc_get_quote_billing_fields', 'disable' );

				if ( WPC_Utils::str_to_bool( $billing_fields ) ) {
					if ( empty( $values['country'] ) ) {
						$errors->add( 'country', esc_html__( 'Country field is empty.', 'wp-configurator-pro' ) );
					}

					if ( empty( $values['address'] ) ) {
						$errors->add( 'address', esc_html__( 'Address field is empty.', 'wp-configurator-pro' ) );
					}

					if ( empty( $values['city'] ) ) {
						$errors->add( 'city', esc_html__( 'City field is empty.', 'wp-configurator-pro' ) );
					}

					if ( empty( $values['state'] ) ) {
						$errors->add( 'state', esc_html__( 'State field is empty.', 'wp-configurator-pro' ) );
					}

					if ( empty( $values['zip'] ) ) {
						$errors->add( 'zip', esc_html__( 'Postal code is empty.', 'wp-configurator-pro' ) );
					}
				}

				$gdpr_implementation = get_option( 'wpc_gdpr_implementation', 'disable' );

				if ( WPC_Utils::str_to_bool( $gdpr_implementation ) ) {
					if ( empty( $values['gdpr'] ) ) {
						$errors->add( 'gdpr', esc_html__( 'Terms and conditions not accepted.', 'wp-configurator-pro' ) );
					}
				}

				/**
				 * Hook: Before submitting form, check validation.
				 *
				 * * @since 2.4
				 *
				 * @param array       $values Post values.
				 * @param object     $errors Error Class.
				*/
				do_action( 'wpc_quote_form_field_validation', $values, $errors );

				$file_details = array(
					'name' => $values['request_id'] . '-attachment',
					'ext'  => 'png',
					'type' => 'image/png',
				);

				// Process image attachment.
				$attachments_data = WPC_Utils::save_encoded_data_as_attachment( $values['image_data'], $file_details );

				if ( ! empty( $errors->get_error_codes() ) ) {

					echo wp_json_encode(
						array(
							'error'  => true,
							'notice' => $errors,
						)
					);

					/**
					 * Hook: Mail sending failed.
					 *
					 * * @since 2.5.1
					 *
					 * @param array       $values Post values.
					 * @param object     $errors Error Class.
					*/
					do_action( 'wpc_quote_form_mail_sent_failed', $values, $errors );

					die();
				} else {

					$values['summary'] = WPC_Utils::build_summary( $values );

					$has_admin_email_error = $this->process_admin_email( $values, $attachments_data );

					$has_customer_email_error = $this->process_customer_email( $values, $attachments_data );

					if ( $has_admin_email_error || $has_customer_email_error ) {
						$errors->add( 'disabled', esc_html__( 'The e-mail could not be sent. Possible reason: your host may have disabled the mail() function.', 'wp-configurator-pro' ) );
					}

					if ( ! empty( $errors->get_error_codes() ) ) {
						echo wp_json_encode(
							array(
								'error'  => true,
								'notice' => $errors,
							)
						);
					} else {
						/**
						 * Filter: Quote form success message.
						 *
						 * * @since 2.5.1
						 *
						 * @param string   $success_message Mail template details.
						 */
						$success_notice = apply_filters(
							'wpc_quote_form_success_message',
							get_option( 'wpc_get_quote_success_notice', esc_html__( 'Successfully requested for a Quote, Check your e-mail for the verifications.', 'wp-configurator-pro' ) )
						);

						$greetings_page = get_option( 'wpc_get_quote_greetings_page', '0' );

						echo wp_json_encode(
							array(
								'error'    => false,
								'notice'   => $success_notice,
								'redirect' => get_permalink( $greetings_page ),
							)
						);

						/**
						 * Filter: Save Get a Quote user configuration mail in `Config Mail List` post type arguements.
						 *
						 * * @since 2.0
						 * * @version 2.6
						 *
						 * @param array   $args Form details.
						 */
						$args = apply_filters(
							'wpc_save_user_customisation_args',
							array(
								'request_id'  => $values['request_id'],
								'attachments' => apply_filters( 'wpc_save_user_customisation_attachment_id', $attachments_data['id'], $values ),
							)
						);

						$post = $this->save_user_customisation( $args );

						$values['requested_at'] = get_the_date( 'Y-m-d H:i:s', $post );

						if ( $post ) {
							$this->update_mail_details_in_meta( $post, $values );
						}

						/**
						* Hook: After sending a get a quote email.
						*
						* * @since 2.5.1
						* * @version 3.2.5
						*
						* @param integer    $post Post ID.
						* @param array      $values Post values.
						* @param integer    $attachments_data Configuration image ID.
						*/
						do_action( 'wpc_quote_form_after_mail_sent', $post, $values, $attachments_data['id'] );
					}
				}
			}

			die();
		}

		/**
		 * Process admin email if no error occurs.
		 *
		 * It creates user configuations as post in Config mail list post type.
		 *
		 * @param array $values Mail required values.
		 * @param array $attachments_data Configured image.
		 * @return bool
		 */
		public function process_admin_email( $values = array(), $attachments_data = array() ) {

			$error = false;

			if ( apply_filters( 'wpc_get_quote_disable_admin_mail', false ) ) {
				return $error;
			}

			add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
			add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );

			// Get all email.
			$mail_to          = get_option( 'wpc_get_quote_mail_to', 'all-admin' );
			$mail_custom_user = get_option( 'wpc_get_quote_mail_custom_user', '' );

			$emails = array();

			if ( 'all-admin' === $mail_to || empty( $mail_custom_user ) ) {
				$users = get_users( 'role=Administrator' );
				foreach ( $users as $user ) {
					$emails[] = $user->user_email;
				}
			} elseif ( 'custom-user' === $mail_to || ! empty( $mail_custom_user ) ) {
				$mail_custom_user = explode( '|', $mail_custom_user );

				if ( ! empty( $mail_custom_user ) ) {
					foreach ( $mail_custom_user  as $key => $username ) {
						$user = username_exists( $username ) ? get_user_by( 'login', $username ) : false;

						if ( $user ) {
							$emails[] = $user->user_email;
						}
					}
				}
			}

			/**
			 * Filter: Admin email lists.
			 *
			 * * @since 3.4.3
			 *
			 * @param array   $emails Admin email subject.
			 * @param array   $values Mail post values.
			 * @param array   $attachments_data Mail attachment data.
			 */
			$emails = apply_filters( 'wpc_get_quote_admin_emails', $emails, $values, $attachments_data );

			// Mail attachment image file.
			$attachments = ( $attachments_data ) ? array( $attachments_data['path'] ) : '';

			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-Type:text/html;charset=UTF-8' . "\r\n";

			/* translators: %s Site name. */
			$subject = get_option( 'wpc_get_quote_mail_subject', esc_html__( 'New Request: #{request_id} request has been received!', 'wp-configurator-pro' ) );
			$subject = $this->replace_placeholder( $subject, $values );

			/**
			 * Filter: Admin email subject.
			 *
			 * * @since 2.5.1
			 *
			 * @param string   $subject Admin email subject.
			 */
			$subject = apply_filters( 'wpc_get_quote_admin_mail_subject', $subject );

			$email_heading = get_option( 'wpc_get_quote_admin_mail_heading', esc_html__( 'Request Received', 'wp-configurator-pro' ) );

			/**
			 * Filter: Admin mail template arguements.
			 *
			 * * @since 2.5.1
			 *
			 * @param array   $args Mail template details.
			 */
			$values = array_merge(
				$values,
				apply_filters(
					'wpc_quote_form_admin_mail_template_args',
					array(
						'email_heading' => $email_heading,
					)
				)
			);

			/**
			 * Filter: Admin mail template path.
			 *
			 * * @since 3.4.9
			 *
			 * @param array   $values Mail template arguements.
			 */
			$body = WPC_Utils::get_template_html( 'email/admin-new-request-quote.php', array( 'values' => $values ), apply_filters( 'wpc_admin_email_template_path', '', $values ) );

			$emogrifier = new WPC_Emogrifier( $body );

			$body = $emogrifier->emogrify();

			$html_prune = WPC_HtmlPruner::fromHtml( $body );
			$html_prune->removeElementsWithDisplayNone();

			$body = $html_prune->render();

			if ( ! wp_mail( $emails, $subject, $body, $headers, $attachments ) ) {
				$error = true;
			}

			remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
			remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );

			return $error;
		}

		/**
		 * Process customer email if no error occurs.
		 *
		 * @param array $values Mail required values.
		 * @param array $attachments_data Configured image.
		 * @return bool
		 */
		public function process_customer_email( $values = array(), $attachments_data = array() ) {

			$error = false;

			if ( apply_filters( 'wpc_get_quote_disable_customer_mail', false ) ) {
				return $error;
			}

			add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
			add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );

			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-Type:text/html;charset=UTF-8' . "\r\n";

			/* translators: %s Site name. */
			$subject = get_option( 'wpc_get_quote_customer_mail_subject', esc_html__( 'Your {site_title} request has been received!', 'wp-configurator-pro' ) );
			$subject = $this->replace_placeholder( $subject, $values );

			/**
			 * Filter: Customer email subject.
			 *
			 * * @since 2.5.1
			 *
			 * @param string   $subject Admin email subject.
			 */
			$subject = apply_filters( 'wpc_get_quote_customer_mail_subject', $subject );

			$email_heading = get_option( 'wpc_get_quote_customer_mail_heading', esc_html__( 'Thank you for your request', 'wp-configurator-pro' ) );

			// Mail attachment image file.
			$attachments = ( $attachments_data ) ? array( $attachments_data['path'] ) : '';

			/**
			 * Filter: Customer mail template arguements.
			 *
			 * * @since 2.5.1
			 *
			 * @param array   $args Mail template details.
			 */
			$values = array_merge(
				$values,
				apply_filters(
					'wpc_quote_form_customer_mail_template_args',
					array(
						'email_heading' => $email_heading,
					)
				)
			);

			/**
			 * Filter: Admin mail template path.
			 *
			 * * @since 3.4.9
			 *
			 * @param array   $values Mail template arguements.
			 */
			$body = WPC_Utils::get_template_html( 'email/customer-new-request-quote.php', array( 'values' => $values ), apply_filters( 'wpc_customer_email_template_path', '', $values ) );

			$emogrifier = new WPC_Emogrifier( $body );

			$body = $emogrifier->emogrify();

			$html_prune = WPC_HtmlPruner::fromHtml( $body );
			$html_prune->removeElementsWithDisplayNone();

			$body = $html_prune->render();

			if ( ! wp_mail( $values['email'], $subject, $body, $headers, $attachments ) ) {
				$error = true;
			}

			remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
			remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );

			return $error;
		}

		/**
		 * Add the required values to the meta data.
		 *
		 * @param integer $post Post ID.
		 * @param array   $values Post values.
		 * @return void
		 */
		public function update_mail_details_in_meta( $post = 0, $values = array() ) {
			update_post_meta( $post, '_wpc_user_config_request_id', $values['request_id'] );
			update_post_meta( $post, '_wpc_user_config_encoded', $values['encoded'] );
			update_post_meta( $post, '_wpc_user_config_active_tree_set', $values['active_tree_set'] );
			update_post_meta( $post, '_wpc_user_config_name', $values['name'] );
			update_post_meta( $post, '_wpc_user_config_email', $values['email'] );
			update_post_meta( $post, '_wpc_user_config_phone', $values['phone'] );
			update_post_meta( $post, '_wpc_user_config_message', $values['message'] );
			update_post_meta( $post, '_wpc_user_config_id', $values['config_id'] );
			update_post_meta( $post, '_wpc_user_config_summary', $values['summary'] );
			update_post_meta( $post, '_wpc_user_config_date_created', $values['requested_at'] );
			update_post_meta( $post, '_wpc_user_config_additional_info', $values['info'] );

			$billing_fields = get_option( 'wpc_get_quote_billing_fields', 'disable' );

			if ( 'enable' === $billing_fields ) {
				update_post_meta( $post, '_wpc_user_config_country', $values['country'] );
				update_post_meta( $post, '_wpc_user_config_address', $values['address'] );
				update_post_meta( $post, '_wpc_user_config_city', $values['city'] );
				update_post_meta( $post, '_wpc_user_config_state', $values['state'] );
				update_post_meta( $post, '_wpc_user_config_zip', $values['zip'] );
			}
		}

		/**
		 * Replace the placeholder text from the get a quote mail.
		 *
		 * Available placeholders: {request_id}, {site_title}
		 *
		 * @param string $string Content.
		 * @param array  $values Mail required values.
		 * @return string
		 */
		public function replace_placeholder( $string, $values ) {

			$string = str_replace( array( '{request_id}', '{site_title}' ), array( esc_html( $values['request_id'] ), esc_html( get_bloginfo( 'name', 'display' ) ) ), $string );

			return $string;
		}

		/**
		 * Get the from name for outgoing emails.
		 *
		 * @return string
		 */
		public function get_from_name() {
			/**
			 * Filter: Email from name.
			 *
			 * * @since 2.5
			 *
			 * @param string   $from_name Email from name.
			 */
			$from_name = apply_filters( 'wpc_email_from_name', get_option( 'wpc_email_from_name' ) );
			return wp_specialchars_decode( esc_html( $from_name ), ENT_QUOTES );
		}

		/**
		 * Get the from address for outgoing emails.
		 *
		 * @return string
		 */
		public function get_from_address() {
			/**
			 * Filter: Email from email address.
			 *
			 * * @since 2.5
			 *
			 * @param string   $from_name Email from email address.
			 */
			$from_email = apply_filters( 'wpc_email_from_address', get_option( 'wpc_email_from_address' ) );
			return sanitize_email( $from_email );
		}

		/**
		 * Remove brackets in cf7 shortcode tags.
		 *
		 * @param string $string String.
		 * @return string
		 */
		public function remove_tag_string( $string = '' ) {
			return str_replace( array( '[', ']' ), '', $string );
		}

		/**
		 * Create a configurator post.
		 *
		 * @return void
		 */
		public function create_config() {

			$title = ( isset( $_POST['title'] ) && ! empty( $_POST['title'] ) ) ? $_POST['title'] : '';

			if ( ! $title ) {
				$data['error']           = true;
				$data['notice']['title'] = esc_html__( 'Please enter a title', 'wp-configurator-pro' );
			} else {
				$args = array(
					'post_type'   => 'amz_configurator',
					'post_title'  => $title,
					'post_status' => 'publish',
					'meta_input'  => array(
						'_wpc_data_version' => WPC_DATABASE_VERSION,
						'_wpc_config_style' => 'accordion',
					),
				);

				$post = wp_insert_post( $args );

				if ( $post ) {
					$data['error']             = false;
					$data['redirect']          = admin_url( 'edit.php?post_type=amz_configurator&page=wpc-editor&post=' . $post );
					$data['notice']['success'] = esc_html__( 'Created Successfully', 'wp-configurator-pro' );
				}
			}

			echo wp_json_encode( $data );

			die();
		}

		/**
		 * Update configurator post data.
		 *
		 * @return void
		 */
		public function update_post() {
			$id              = ( isset( $_POST['id'] ) && ! empty( $_POST['id'] ) ) ? $_POST['id'] : '';
			$nonce           = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';
			$title           = ( isset( $_POST['title'] ) && ! empty( $_POST['title'] ) ) ? $_POST['title'] : '';
			$views           = ( isset( $_POST['views'] ) && ! empty( $_POST['views'] ) ) ? wp_list_pluck( $_POST['views'], 'name', 'id' ) : array();
			$status          = ( isset( $_POST['status'] ) && ! empty( $_POST['status'] ) ) ? $_POST['status'] : '';
			$components      = ( isset( $_POST['components'] ) && ! empty( $_POST['components'] ) ) ? json_decode( stripslashes( $_POST['components'] ), true ) : '';
			$post_meta       = ( isset( $_POST['post_meta'] ) && ! empty( $_POST['post_meta'] ) ) ? json_decode( stripslashes( $_POST['post_meta'] ) ) : array();
			$css_js_settings = ( isset( $_POST['css_js_settings'] ) && ! empty( $_POST['css_js_settings'] ) ) ? $_POST['css_js_settings'] : array();
			$images          = ( isset( $_POST['images'] ) && ! empty( $_POST['images'] ) ) ? json_decode( stripslashes( $_POST['images'] ), true ) : '';
			$data_version    = isset( $_POST['data_version'] ) ? $_POST['data_version'] : '';

			if ( version_compare( $data_version, WPC_DATABASE_VERSION, '<' ) ) {
				echo wp_json_encode(
					array(
						'error'  => true,
						'notice' => esc_html__( 'The current data version is old, please update the database to continue.', 'wp-configurator-pro' ),
					)
				);
				die();
			}

			if ( ! wp_verify_nonce( $nonce, 'wpc-update-post' ) ) {
				echo wp_json_encode(
					array(
						'error'  => true,
						'notice' => esc_html__( 'Nonce failed', 'wp-configurator-pro' ),
					)
				);
				die();
			}

			update_post_meta( $id, '_wpc_views', $views );

			if ( isset( $post_meta ) ) {
				foreach ( $post_meta as $key => $value ) {
					if ( is_object( $value ) ) {
						$value = (array) $value;
					}
					update_post_meta( $id, $key, $value );
				}
			}

			if ( isset( $css_js_settings ) ) {
				foreach ( $css_js_settings as $key => $value ) {
					update_post_meta( $id, $key, $value );
				}
			}

			update_post_meta( $id, '_wpc_components', $components );
			update_post_meta( $id, '_wpc_editor_images', $images );

			$old_title  = get_the_title( $id );
			$old_status = get_post_status( $id );

			if ( $title !== $old_title || $status !== $old_status ) {
				$id = wp_update_post(
					array(
						'ID'          => $id,
						'post_title'  => $title,
						'post_name'   => $title,
						'post_type'   => 'amz_configurator',
						'post_status' => $status,
					)
				);
			}

			if ( $id ) {
				$btn_text = ( 'publish' === get_post_status( $id ) ) ? esc_html__( 'Update', 'wp-configurator-pro' ) : esc_html__( 'Publish', 'wp-configurator-pro' );

				echo wp_json_encode(
					array(
						'error'    => false,
						'notice'   => esc_html__( 'Saved successfully', 'wp-configurator-pro' ),
						'btn_text' => $btn_text,
					)
				);
			}

			die();

		}

		/**
		 * Update the user meta if completes the tour.
		 *
		 * @return void
		 */
		public function complete_tour() {
			$current_user_id = get_current_user_id();

			update_user_meta( $current_user_id, 'wpc_tour_completed', true );

			die();
		}

		/**
		 * Update the user meta if completes the tour.
		 *
		 * @return void
		 */
		public function save_invoice() {

			$id      = ( isset( $_POST['id'] ) && ! empty( $_POST['id'] ) ) ? $_POST['id'] : '';
			$content = ( isset( $_POST['content'] ) && ! empty( $_POST['content'] ) ) ? $_POST['content'] : '';

			update_post_meta( $id, '_wpc_invoice_raw_content', wp_kses_post( $content ) );

			echo wp_json_encode(
				array(
					'id'     => $id,
					'notice' => wp_kses_post( $content ),
				)
			);

			die();
		}

		/**
		 * Update the user meta if completes the tour.
		 *
		 * @return void
		 */
		public function apply_invoice_action() {

			$id     = ( isset( $_POST['id'] ) && ! empty( $_POST['id'] ) ) ? $_POST['id'] : '';
			$action = ( isset( $_POST['invoice_action'] ) && ! empty( $_POST['invoice_action'] ) ) ? $_POST['invoice_action'] : '';

			$customer_email = WPC_Utils::get_meta_value( $id, '_wpc_user_config_email', '' );

			if ( 'send_request_details' === $action ) {
				add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
				add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );

				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-Type:text/html;charset=UTF-8' . "\r\n";

				/* translators: %s Site name. */
				$subject = esc_html__( '{site_title} Invoice', 'wp-configurator-pro' );
				$subject = $this->replace_placeholder( $subject, $values );

				$email_heading = esc_html__( 'Invoice', 'wp-configurator-pro' );

				// Mail attachment image file.
				$post_thumbnail_id = get_post_thumbnail_id( $id );

				$attachments = WPC_Utils::get_image( $post_thumbnail_id );

				$body = WPC_Utils::get_template_html( 'email/invoice.php', array( 'id' => $id ) );

				$emogrifier = new WPC_Emogrifier( $body );

				$body = $emogrifier->emogrify();

				$html_prune = WPC_HtmlPruner::fromHtml( $body );
				$html_prune->removeElementsWithDisplayNone();

				$body = $html_prune->render();

				if ( wp_mail( $customer_email, $subject, $body, $headers, $attachments ) ) {

					echo wp_json_encode(
						array(
							'error'  => false,
							'notice' => esc_html__( 'Invoice sent successfully', 'wp-configurator-pro' ),
						)
					);
				}

				remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
				remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
			}

			die();
		}

	}

	$GLOBALS['wpc_ajax_callback'] = new WPC_Ajax_Callback();

}
