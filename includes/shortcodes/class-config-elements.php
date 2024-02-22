<?php
/**
 * Core configurator shortcode.
 *
 * @package  wp-configurator-pro/includes/shortcodes/
 * @since  2.0
 * @version  3.5.3
 *
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPCSE' ) ) {

	/**
	 * Core configurator shortcode.
	 */
	class WPCSE {

		/**
		 * Configurator Data.
		 *
		 * @var object
		 */
		public $config;

		/**
		 * Alpine Store.
		 *
		 * @var object
		 */
		public $store;

		/**
		 * Configurator ID.
		 *
		 * @var string|int
		 */
		public $id;


		/**
		 * Product ID.
		 *
		 * @var string|int
		 */
		public $product_id;


		/**
		 * Configurator base price.
		 *
		 * @var string
		 */
		public $base_price;


		/**
		 * Configurator layer components.
		 *
		 * @var array
		 */
		public $components = array();


		/**
		 * Whether the style allows multiple levels of sub group or not.
		 *
		 * @var array
		 */
		public $allow_multiple_level = true;


		/**
		 * Configurator layers.
		 *
		 * @var array
		 */
		public $layers = array();


		/**
		 * Configurator editor images.
		 *
		 * @var array
		 */
		public $editor_images = array();


		/**
		 * Configurator cart thumbnail view.
		 *
		 * @var array
		 */
		public $cart_thumbnail_view = '';


		/**
		 * Encoded active key.
		 *
		 * @var string
		 */
		public $encoded_key = '';


		/**
		 * Configurator active layers tree sets.
		 *
		 * @var array
		 */
		public $active_tree_sets = array();


		/**
		 * It holds decoded active UID's separated with commas.
		 *
		 * @var string
		 */
		protected $active_item = '';


		/**
		 * It holds default active UID's.
		 *
		 * @var array
		 */
		public $active_uid = array();


		/**
		 * It holds anchestor UID.
		 *
		 * @var string
		 */
		public $anchestor_uid = '';


		/**
		 * Get a quote email request ID.
		 *
		 * @var string
		 */
		public $request_id = '';


		/**
		 * It holds top group UID's.
		 *
		 * @var array
		 */
		public $top_layers = array();


		/**
		 * It holds default active UID's separated with commas.
		 *
		 * @var string
		 */
		public $active_uid_string = '';


		/**
		 * It holds hotspot data.
		 *
		 * @var array
		 */
		public $hotspots = array();


		/**
		 * Configurator total views.
		 *
		 * @var array
		 */
		public $total_views = array();


		/**
		 * Image maximum width.
		 *
		 * @var int
		 */
		public $image_max_width = '';


		/**
		 * Image maximum height.
		 *
		 * @var int
		 */
		public $image_max_height = '';


		/**
		 * It holds the configurator/product title.
		 *
		 * @var string
		 */
		public $title = '';


		/**
		 * Image maximum height.
		 *
		 * @var object
		 */
		public $product = null;


		/**
		 * Inspiration style.
		 *
		 * @var string
		 */
		public $inspiration_style = '';


		/**
		 * Inspiration posts.
		 *
		 * @var array
		 */
		public $inspiration_posts = array();


		/**
		 * Inspiration terms.
		 *
		 * @var array
		 */
		public $inspirations_terms = array();


		/**
		 * Share style.
		 *
		 * @var string
		 */
		public $share_style = '';


		/**
		 * Control item icon type.
		 *
		 * @var string
		 */
		public $icon_type = '';


		/**
		 * Control item icon width.
		 *
		 * @var int
		 */
		public $icon_width = 0;


		/**
		 * Control item icon height.
		 *
		 * @var int
		 */
		public $icon_height = 0;


		/**
		 * Popover style control item icon type.
		 *
		 * @var string
		 */
		public $popover_icon_type = '';


		/**
		 * Popover style control item icon width.
		 *
		 * @var int
		 */
		public $popover_icon_width = 0;


		/**
		 * Popover style control item icon height.
		 *
		 * @var int
		 */
		public $popover_icon_height = 0;


		/**
		 * Quote form country placeholder field placeholder text.
		 *
		 * @var string
		 */
		public $country_placeholder = '';


		/**
		 * Quote form address placeholder field placeholder text.
		 *
		 * @var string
		 */
		public $address_placeholder = '';


		/**
		 * Quote form city placeholder field placeholder text.
		 *
		 * @var string
		 */
		public $city_placeholder = '';


		/**
		 * Quote form state placeholder field placeholder text.
		 *
		 * @var string
		 */
		public $state_placeholder = '';


		/**
		 * Quote form zip placeholder field placeholder text.
		 *
		 * @var string
		 */
		public $zip_placeholder = '';


		/**
		 * Quote form gdpr label text.
		 *
		 * @var string
		 */
		public $gdpr_label = '';


		/**
		 * Whether Meta pixel script added or not.
		 *
		 * @var bool
		 */
		public $meta_pixel = false;


		/**
		 * Whether show/hide the summary popup.
		 *
		 * @var bool
		 */
		public $summary_popup = true;


		/**
		 * Extra data.
		 *
		 * @var int
		 */
		public $extras = array();


		/**
		 * Shortcode attributes.
		 *
		 * @var array
		 */
		public $atts = array();


		/**
		 * Want to load configurator dynamically?.
		 *
		 * @var bool
		 */
		public $dynamic = 'false';


		/**
		 * Configurator Style.
		 *
		 * @var array
		 */
		public $style = 'accordion';


		/**
		 * Control Type.
		 *
		 * @var string
		 */
		public $control_type = 'type-1';


		/**
		 * Control Items.
		 *
		 * @var array
		 */
		public $control_items = array();


		/**
		 * Configurator preview slider dot style.
		 *
		 * @var string
		 */
		public $dot_style = 'dots';


		/**
		 * Configurator preview slider dot position.
		 *
		 * @var string
		 */
		public $dot_position = 'bottom';


		/**
		 * Allow zoom.
		 *
		 * @var string
		 */
		public $zoom = 'show';


		/**
		 * Allow inspiration.
		 *
		 * @var string
		 */
		public $inspiration = 'show';


		/**
		 * Allow take photo.
		 *
		 * @var string
		 */
		public $take_photo = 'show';


		/**
		 * Allow reset.
		 *
		 * @var string
		 */
		public $reset = 'show';


		/**
		 * Want to show price details?
		 *
		 * @var string
		 */
		public $price_details = 'true';


		/**
		 * Want to show group price?
		 *
		 * @var string
		 */
		public $group_price = 'true';


		/**
		 * Want to show total price?
		 *
		 * @var string
		 */
		public $total_price = 'true';


		/**
		 * Remove price, if the value is zero?
		 *
		 * @var string
		 */
		public $remove_price_is_empty = 'false';


		/**
		 * Allow share?
		 *
		 * @var string
		 */
		public $share = 'enable';


		/**
		 * Allow facebook?
		 *
		 * @var string
		 */
		public $facebook = 'show';


		/**
		 * Allow twitter?
		 *
		 * @var string
		 */
		public $twitter = 'show';


		/**
		 * Allow pinterest?
		 *
		 * @var string
		 */
		public $pinterest = 'show';


		/**
		 * Allow linkedin?
		 *
		 * @var string
		 */
		public $linkedin = 'show';


		/**
		 * Allow reddit?
		 *
		 * @var string
		 */
		public $reddit = 'show';


		/**
		 * Allow copy to clipboard?
		 *
		 * @var string
		 */
		public $copy_clipboard = 'show';


		/**
		 * Type of form
		 *
		 * @var string
		 */
		public $form = 'get-quote';


		/**
		 * Contact form ID.
		 *
		 * @var string
		 */
		public $contact_form = '';


		/**
		 * Summary title.
		 *
		 * @var string
		 */
		public $summary_title = '';


		/**
		 * Summary button text.
		 *
		 * @var string
		 */
		public $view_summary_btn_text = '';


		/**
		 * Form title.
		 *
		 * @var string
		 */
		public $form_title = '';


		/**
		 * Get a quote trigger button text.
		 *
		 * @var string
		 */
		public $btn_text = '';


		/**
		 * Get a quote submit button text.
		 *
		 * @var string
		 */
		public $submit_btn_text = '';


		/**
		 * Name field placeholder.
		 *
		 * @var string
		 */
		public $name_placeholder = '';


		/**
		 * Email field placeholder.
		 *
		 * @var string
		 */
		public $email_placeholder = '';


		/**
		 * Phone field placeholder.
		 *
		 * @var string
		 */
		public $phone_placeholder = '';


		/**
		 * Message field placeholder.
		 *
		 * @var string
		 */
		public $message_placeholder = '';


		/**
		 * Element extra class.
		 *
		 * @var string
		 */
		public $extra_class = '';


		/**
		 * Preview slider data.
		 *
		 * @var array
		 */
		public $slider_data = array();


		/**
		 * User role.
		 *
		 * @var int
		 */
		public $role = 'editor';


		/**
		 * Inspiration default term id.
		 *
		 * @var int
		 */
		public $default_term_id = 0;

		/**
		 * Add hidden fields in Contact Form 7
		 *
		 * @param array $fields Form fields.
		 * @return array
		 */
		public function wpcf7_form_fields( $fields = array() ) {

			if ( ! isset( $this->id ) ) {
				return $fields;
			}			

			$update = isset( $_GET['update'] ) ? $_GET['update'] : 0;
			$item   = isset( $_GET['item'] ) ? $_GET['item'] : 0;

			/**
			 * Filter: Additional required hidden input fields.
			 *
			 * * @since 2.0
			 *
			 * @param string   $fields Form fields.
			 */
			$fields = array_merge(
				array(
					'wpc-encoded'         => '',
					'wpc-active-tree-set' => '',
					'wpc-config-id'       => esc_attr( $this->id ),
					'wpc-product-id'      => esc_attr( $this->product_id ),
					'wpc-request-id'      => apply_filters( 'wpc_quote_form_mail_request_id', WPC_Utils::random( 6 ) ),
					'wpc-config-image'    => '',
					'update' => $update,
					'item' => $item,
					'redirect' => esc_url( WPC_Utils::current_url() )
				),
				apply_filters( 'wpc_wpcf7_form_fields', array(), $this )
			);

			return $fields;
		}

		/**
		 * Returns show details page ID.
		 *
		 * @return integer
		 */
		public function show_details_id() {
			$post_id = WPC_Utils::get_meta_value( $this->id, '_wpc_show_details_page', '0' );
			$post_id = WPC_Utils::str_to_bool( $post_id ) ? $post_id : $this->product_id;

			return WPC_Utils::str_to_bool( $post_id ) ? $post_id : false;
		}

		/**
		 * Print floating icons content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function floating_icons( $echo = false ) {
		}

		/**
		 * Print preview carousel content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_preview_html( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/preview.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print preview carousel view content
		 *
		 * @return string
		 */
		public function get_preview_inner_html() {

			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/preview-inner.php',
				$args
			);

			return $output;

		}

		/**
		 * Print show details trigger content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function get_show_details_trigger_html( $echo = false ) {
		}

		/**
		 * Print show details popup content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function get_show_details_popup_html( $echo = false ) {
		}

		/**
		 * Print show details popup content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function get_show_details_html( $echo = false ) {
		}

		/**
		 * Preview carousel layer subset
		 *
		 * @param string $uid Layer uid.
		 * @param string $view Configurator view.
		 * @return string
		 */
		public function get_subset_html( $uid = '', $view = '' ) {

			$args = array(
				'uid'  => $uid,
				'view' => $view,
				'wpc'  => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/preview-subset.php',
				$args
			);

			return $output;
		}

		/**
		 * Preview carousel hotspot content.
		 *
		 * @param string $view Configurator view.
		 * @return void
		 */
		public function get_hotspot_html( $view = '' ) {
		}

		/**
		 * Print cart form content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function get_cart_form( $echo = false ) {
		}

		/**
		 * Print form summary content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function form_summary( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/summary-form.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print cart form summary header content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_summary_header( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/summary-header.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print quote form content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_quote_form( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/form-quote.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print contact form content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function get_contact_form( $echo = false ) {
		}

		/**
		 * Print contact form summary content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_summary_trigger( $echo = false ) {

			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/summary-trigger.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print contact form summary header content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_summary_content( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/summary-content.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print summary popup content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_summary_popup( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/summary-popup.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print summary flyin content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_summary_flyin( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/summary-flyin.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print contact form summary content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_summary_lists( $echo = false ) {

			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/summary-lists.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print contact form summary total content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_summary_total( $echo = false ) {

			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/summary-total.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print controls content.
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_controls_html( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print controls inner content.
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_controls_inner_html( $echo = false ) {

			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-inner-' . $this->control_type . '.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Return sub control content.
		 *
		 * @param array  $layer Layer.
		 * @param string $parent_uid Layer Parent uid.
		 * @return string
		 */
		public function get_sub_controls_separated( $layer = array(), $parent_uid = '' ) {

			$args = array(
				'layer'      => $layer,
				'parent_uid' => $parent_uid,
				'wpc'        => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-sub-layers-separated.php',
				$args
			);

			return $output;

		}

		/**
		 * Return sub control content.
		 *
		 * @param array  $layer Layer.
		 * @param string $parent_uid Layer Parent uid.
		 * @return string
		 */
		public function get_sub_controls_included( $layer = array(), $parent_uid = '' ) {

			$args = array(
				'layer'      => $layer,
				'parent_uid' => $parent_uid,
				'wpc'        => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-sub-layers-included.php',
				$args
			);

			return $output;

		}

		/**
		 * Return sub control content.
		 *
		 * @param array  $layer Layer.
		 * @param string $parent_uid Layer Parent uid.
		 * @return string
		 */
		public function get_sub_controls_items_separated( $layer = array(), $parent_uid = '' ) {

			$args = array(
				'layer'      => $layer,
				'parent_uid' => $parent_uid,
				'wpc'        => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-sub-layers-items-separated.php',
				$args
			);

			return $output;

		}

		/**
		 * Return sub control content.
		 *
		 * @param array  $layer Layer.
		 * @param string $parent_uid Layer Parent uid.
		 * @return string
		 */
		public function get_sub_controls_children_separated( $layer = array(), $parent_uid = '' ) {

			$args = array(
				'layer'      => $layer,
				'parent_uid' => $parent_uid,
				'wpc'        => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-sub-layers-children-separated.php',
				$args
			);

			return $output;
		}

		/**
		 * Return sub control content.
		 *
		 * @param array  $layer Layer.
		 * @param string $parent_uid Layer Parent uid.
		 * @return string
		 */
		public function get_sub_controls_and_items_separated( $layer = array(), $parent_uid = '' ) {

			$args = array(
				'layer'      => $layer,
				'parent_uid' => $parent_uid,
				'wpc'        => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-sub-layers-and-items-separated.php',
				$args
			);

			return $output;

		}

		/**
		 * Return control close content.
		 *
		 * @param string $parent_uid Layer Parent uid.
		 * @return string
		 */
		public function get_controls_close( $parent_uid = '' ) {

			$args = array(
				'parent_uid' => $parent_uid,
				'wpc'        => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-close.php',
				$args
			);

			return $output;
		}

		/**
		 * Return control close all content.
		 *
		 * @param string $parent_uid Layer Parent uid.
		 * @return string
		 */
		public function get_controls_close_all() {

			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-close-all.php',
				$args
			);

			return $output;
		}

		/**
		 * Return control close content.
		 *
		 * @param string $parent_uid Layer Parent uid.
		 * @return string
		 */
		public function get_controls_back( $parent_uid = '' ) {

			$args = array(
				'parent_uid' => $parent_uid,
				'wpc'        => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/controls-back.php',
				$args
			);

			return $output;
		}

		/**
		 * Controls list content
		 *
		 * @param array $layer Layer.
		 * @param array $force_stop To stop the loop the children.
		 * @return string
		 */
		public function get_control_item( $layer = array(), $force_stop = false ) {

			$args = array(
				'layer'      => $layer,
				'force_stop' => $force_stop,
				'wpc'        => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/control-item.php',
				$args
			);

			return $output;

		}

		/**
		 * Print total price content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function total_price_html( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/total-price.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print share content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function share_inline( $echo = false ) {
		}

		/**
		 * Print share content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function share_popup( $echo = false ) {
		}

		/**
		 * Print inspiration flyin content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function inspiration_flyin( $echo = false ) {
		}

		/**
		 * Print inspiration popup content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function inspiration_popup( $echo = false ) {
		}

		/**
		 * Print inspiration slider content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function inspiration_slider( $echo = false ) {
		}

		/**
		 * Print inspiration slider content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function inspiration_post( $echo = false ) {
		}

		/**
		 * Print inspiration slider content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function inspiration_post_admin_icons( $echo = false ) {
		}

		/**
		 * Print inspiration tab menu content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function inspiration_tab_menu( $echo = false ) {
		}

		/**
		 * Print inspiration tab content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function inspiration_tab_content( $echo = false ) {
		}

		/**
		 * Print inspiration slider tab content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function inspiration_slider_tab_content( $echo = false ) {
		}

		/**
		 * Print create inspiration popup content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function create_inspiration_popup( $echo = false ) {
		}

		/**
		 * Print update inspiration popup content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function update_inspiration_popup( $echo = false ) {
		}

		/**
		 * Print magnify popup content
		 *
		 * @param boolean $echo Print content.
		 * @return void
		 */
		public function magnify_popup( $echo = false ) {
		}

		/**
		 * Print header content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function header( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/header.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print header logo content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function header_logo( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/header-logo.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print header total price content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function header_total_price( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/header-total-price.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print header menu trigger content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function header_menu_trigger( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/header-menu-trigger.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print header menu content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function header_menu( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/header-menu.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print mobile navigation content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function mobile_nav( $echo = false ) {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/header-mobile-nav.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print mobile navigation content
		 *
		 * @param boolean $echo Print content.
		 * @return string
		 */
		public function get_flyin_logo( $echo = false ) {

			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/flyin-logo.php',
				$args
			);

			if ( $echo ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				return $output;
			}
		}

		/**
		 * Print required field content
		 *
		 * @return string
		 */
		public function get_required_fields() {
			$args = array(
				'wpc' => $this,
			);

			$output = WPC_Utils::get_template_html(
				'elements/form-required-fields.php',
				$args
			);

			return $output;
		}

		/**
		 * Initialize shortcode.
		 *
		 * @param array $atts Shortcode attributes.
		 * @return bool
		 */
		public function initialize_shortcode( $atts = array(), $code = '' ) {

			$atts = apply_filters( 'wpc_shortcode_atts', $atts );

			$this->atts = $atts;

			$this->id      = isset( $atts['id'] ) ? $atts['id'] : 0;
			$this->dynamic = isset( $atts['dynamic'] ) ? $atts['dynamic'] : 'false';

			// If dynamic is set, get the config ID dynamically.
			$this->product_id = WPC_Utils::get_meta_value( $this->id, '_wpc_product_id', false );

			if ( is_singular( 'product' ) && ( WPC_Utils::str_to_bool( $this->dynamic ) || ! WPC_Utils::str_to_bool( $this->id ) ) ) {
				$this->product_id = get_the_ID();
				$this->id         = WPC_Utils::get_meta_value( $this->product_id, '_wpc_config_id', false );
			}

			if ( ! $this->id || ! WPC_Utils::str_to_bool( $this->id ) || ! $this->is_config_post() ) {
				return false;
			}

			$this->store = '$store.config_' . $this->id;

			// Build attributes.
			$default_style                     = WPC_Utils::get_meta_value( $this->id, '_wpc_config_style', 'accordion-2' );
			$default_form                      = WPC_Utils::get_meta_value( $this->id, '_wpc_form', 'quote-form' );
			$default_contact_form              = WPC_Utils::get_meta_value( $this->id, '_wpc_contact_form', '' );
			$default_build_summary_title       = get_option( 'wpc_build_summary_title', esc_html__( 'Build Summary', 'wp-configurator-pro' ) );
			$default_price_details             = get_option( 'wpc_price_details', 'true' );
			$default_group_price               = get_option( 'wpc_group_price', 'true' );
			$default_zoom                      = get_option( 'wpc_zoom_icon', 'show' );
			$default_inspiration               = get_option( 'wpc_inspiration_icon', 'show' );
			$default_inspiration_style         = get_option( 'wpc_inspiration_style', 'flyin' );
			$default_take_photo                = get_option( 'wpc_take_photo_icon', 'show' );
			$default_reset                     = get_option( 'wpc_reset_icon', 'show' );
			$default_share                     = get_option( 'wpc_share', 'enable' );
			$default_share_style               = get_option( 'wpc_share_style', 'inline' );
			$default_facebook                  = get_option( 'wpc_facebook', 'show' );
			$default_twitter                   = get_option( 'wpc_twitter', 'show' );
			$default_pinterest                 = get_option( 'wpc_pinterest', 'show' );
			$default_linkedin                  = get_option( 'wpc_linkedin', 'show' );
			$default_reddit                    = get_option( 'wpc_reddit', 'show' );
			$default_copy_clipboard            = get_option( 'wpc_copy_clipboard', 'show' );
			$default_total_price               = get_option( 'wpc_total_price', 'true' );
			$default_view_summary_btn_text     = get_option( 'wpc_view_summary_btn_text', esc_html__( 'View Summary', 'wp-configurator-pro' ) );
			$default_get_quote_form_title      = get_option( 'wpc_get_quote_form_title', esc_html__( 'Get a Quote', 'wp-configurator-pro' ) );
			$default_get_quote_btn_text        = get_option( 'wpc_get_quote_btn_text', esc_html__( 'Get a Quote', 'wp-configurator-pro' ) );
			$default_get_quote_submit_btn_text = get_option( 'wpc_get_quote_submit_btn_text', esc_html__( 'Submit', 'wp-configurator-pro' ) );
			$default_name_placeholder          = get_option( 'wpc_get_quote_name_placeholder', esc_html__( 'Enter your name', 'wp-configurator-pro' ) );
			$default_email_placeholder         = get_option( 'wpc_get_quote_email_placeholder', esc_html__( 'Enter email address', 'wp-configurator-pro' ) );
			$default_phone_placeholder         = get_option( 'wpc_get_quote_phone_placeholder', esc_html__( 'Enter phone number', 'wp-configurator-pro' ) );
			$default_message_placeholder       = get_option( 'wpc_get_quote_message_placeholder', esc_html__( 'Type your message', 'wp-configurator-pro' ) );
			$default_country_placeholder       = get_option( 'wpc_get_quote_country_placeholder', esc_html__( 'Country/Region', 'wp-configurator-pro' ) );
			$default_address_placeholder       = get_option( 'wpc_get_quote_address_placeholder', esc_html__( 'Street Address', 'wp-configurator-pro' ) );
			$default_city_placeholder          = get_option( 'wpc_get_quote_city_placeholder', esc_html__( 'Town/City', 'wp-configurator-pro' ) );
			$default_state_placeholder         = get_option( 'wpc_get_quote_state_placeholder', esc_html__( 'State', 'wp-configurator-pro' ) );
			$default_zip_placeholder           = get_option( 'wpc_get_quote_zip_placeholder', esc_html__( 'Postal Code', 'wp-configurator-pro' ) );
			$default_gdpr_label                = get_option( 'wpc_get_quote_gdpr_label', esc_html__( 'By using this form you agree with the terms and conditions of this website.', 'wp-configurator-pro' ) );
			$default_dot_style                 = get_option( 'wpc_preview_slide_dot_style', 'dots' );
			$default_dot_position              = get_option( 'wpc_preview_slide_dot_position', 'bottom' );

			$this->style                 = isset( $atts['style'] ) ? $atts['style'] : $default_style;
			$this->price_details         = isset( $atts['price_details'] ) ? $atts['price_details'] : $default_price_details;
			$this->group_price           = isset( $atts['group_price'] ) ? $atts['group_price'] : $default_group_price;
			$this->form                  = isset( $atts['form'] ) ? $atts['form'] : $default_form;
			$this->contact_form          = isset( $atts['contact_form'] ) ? $atts['contact_form'] : $default_contact_form;
			$this->summary_title         = isset( $atts['summary_title'] ) ? $atts['summary_title'] : $default_build_summary_title;
			$this->zoom                  = isset( $atts['zoom'] ) ? $atts['zoom'] : $default_zoom;
			$this->inspiration           = isset( $atts['inspiration'] ) ? $atts['inspiration'] : $default_inspiration;
			$this->inspiration_style     = isset( $atts['inspiration_style'] ) ? $atts['inspiration_style'] : $default_inspiration_style;
			$this->take_photo            = isset( $atts['take_photo'] ) ? $atts['take_photo'] : $default_take_photo;
			$this->reset                 = isset( $atts['reset'] ) ? $atts['reset'] : $default_reset;
			$this->share                 = isset( $atts['share'] ) ? $atts['share'] : $default_share;
			$this->share_style           = isset( $atts['share_style'] ) ? $atts['share_style'] : $default_share_style;
			$this->facebook              = isset( $atts['facebook'] ) ? $atts['facebook'] : $default_facebook;
			$this->twitter               = isset( $atts['twitter'] ) ? $atts['twitter'] : $default_twitter;
			$this->pinterest             = isset( $atts['pinterest'] ) ? $atts['pinterest'] : $default_pinterest;
			$this->linkedin              = isset( $atts['linkedin'] ) ? $atts['linkedin'] : $default_linkedin;
			$this->reddit                = isset( $atts['reddit'] ) ? $atts['reddit'] : $default_reddit;
			$this->copy_clipboard        = isset( $atts['copy_clipboard'] ) ? $atts['copy_clipboard'] : $default_copy_clipboard;
			$this->total_price           = isset( $atts['total_price'] ) ? $atts['total_price'] : $default_total_price;
			$this->view_summary_btn_text = isset( $atts['view_summary_btn_text'] ) ? $atts['view_summary_btn_text'] : $default_view_summary_btn_text;
			$this->form_title            = isset( $atts['form_title'] ) ? $atts['form_title'] : $default_get_quote_form_title;
			$this->btn_text              = isset( $atts['btn_text'] ) ? $atts['btn_text'] : $default_get_quote_btn_text;
			$this->submit_btn_text       = isset( $atts['submit_btn_text'] ) ? $atts['submit_btn_text'] : $default_get_quote_submit_btn_text;
			$this->name_placeholder      = isset( $atts['name_placeholder'] ) ? $atts['name_placeholder'] : $default_name_placeholder;
			$this->email_placeholder     = isset( $atts['email_placeholder'] ) ? $atts['email_placeholder'] : $default_email_placeholder;
			$this->phone_placeholder     = isset( $atts['phone_placeholder'] ) ? $atts['phone_placeholder'] : $default_phone_placeholder;
			$this->message_placeholder   = isset( $atts['message_placeholder'] ) ? $atts['message_placeholder'] : $default_message_placeholder;
			$this->country_placeholder   = isset( $atts['country_placeholder'] ) ? $atts['country_placeholder'] : $default_country_placeholder;
			$this->address_placeholder   = isset( $atts['address_placeholder'] ) ? $atts['address_placeholder'] : $default_address_placeholder;
			$this->city_placeholder      = isset( $atts['city_placeholder'] ) ? $atts['city_placeholder'] : $default_city_placeholder;
			$this->state_placeholder     = isset( $atts['state_placeholder'] ) ? $atts['state_placeholder'] : $default_state_placeholder;
			$this->zip_placeholder       = isset( $atts['zip_placeholder'] ) ? $atts['zip_placeholder'] : $default_zip_placeholder;
			$this->gdpr_label            = isset( $atts['gdpr_label'] ) ? $atts['gdpr_label'] : $default_gdpr_label;
			$this->dot_style             = isset( $atts['dot_style'] ) ? $atts['dot_style'] : $default_dot_style;
			$this->dot_position          = isset( $atts['dot_position'] ) ? $atts['dot_position'] : $default_dot_position;			

			$this->icon_type           = get_option( 'wpc_icon_type', 'round' );
			$this->icon_width          = (int) get_option( 'wpc_icon_width', '20' );
			$this->icon_height         = (int) get_option( 'wpc_icon_height', '20' );
			$this->popover_icon_type   = get_option( 'wpc_popover_icon_type', 'semi-round' );
			$this->popover_icon_width  = (int) get_option( 'wpc_popover_icon_width', '40' );
			$this->popover_icon_height = (int) get_option( 'wpc_popover_icon_height', '40' );

			$this->meta_pixel = WPC_Utils::str_to_bool( get_option( 'wpc_meta_pixel', 'disable' ) );

			$this->summary_popup = get_option( 'wpc_summary_popup', 'show' );

			$this->control_type = apply_filters( 'wpc_' . $this->style . '_control_type', 'type-1', $this );

			$this->extra_class = isset( $atts['extra_class'] ) ? $atts['extra_class'] : '';

			$this->product = ( WPC_WOO_ACTIVE ) ? wc_get_product( $this->product_id ) : false;

			// Slider data.
			$nav               = get_option( 'wpc_preview_slide_nav', 'false' );
			$start_position    = get_option( 'wpc_preview_slide_start_position', '' );
			$touch_drag        = get_option( 'wpc_preview_slide_touch_drag', 'false' );
			$mouse_drag        = get_option( 'wpc_preview_slide_mouse_drag', 'true' );
			$touch_drag_mobile = get_option( 'wpc_preview_slide_touch_drag_mobile', 'false' );
			$mouse_drag_mobile = get_option( 'wpc_preview_slide_mouse_drag_mobile', 'false' );
			$touch_drag_tablet = get_option( 'wpc_preview_slide_touch_drag_tablet', 'false' );
			$mouse_drag_tablet = get_option( 'wpc_preview_slide_mouse_drag_tablet', 'false' );

			$slider_data['nav']               = ( $nav ) ? 'data-nav="' . esc_attr( $nav ) . '"' : '';
			$slider_data['start-position']    = ( $start_position ) ? 'data-start-position="' . esc_attr( $start_position ) . '"' : '';
			$slider_data['touch-drag']        = ( $touch_drag ) ? 'data-touch-drag="' . esc_attr( $touch_drag ) . '"' : '';
			$slider_data['mouse-drag']        = ( $mouse_drag ) ? 'data-mouse-drag="' . esc_attr( $mouse_drag ) . '"' : '';
			$slider_data['touch-drag-mobile'] = ( $touch_drag_mobile ) ? 'data-touch-drag-mobile="' . esc_attr( $touch_drag_mobile ) . '"' : '';
			$slider_data['mouse-drag-mobile'] = ( $mouse_drag_mobile ) ? 'data-mouse-drag-mobile="' . esc_attr( $mouse_drag_mobile ) . '"' : '';
			$slider_data['touch-drag-tablet'] = ( $touch_drag_tablet ) ? 'data-touch-drag="' . esc_attr( $touch_drag_tablet ) . '"' : '';
			$slider_data['mouse-drag-tablet'] = ( $mouse_drag_tablet ) ? 'data-mouse-drag="' . esc_attr( $mouse_drag_tablet ) . '"' : '';

			/**
			 * Filter: Preview slider data.
			 *
			 * * @since 2.0
			 *
			 * @param array   $slider_data Slider data.
			 */
			$this->slider_data = array_filter( apply_filters( 'wpc_preview_slider_data', $slider_data ) );

			/**
			 * Filter: Generate random Request ID.
			 *
			 * * @since 2.5.1
			 *
			 * @param string   $request_id Random request ID.
			 */
			$this->request_id = apply_filters( 'wpc_quote_form_mail_request_id', WPC_Utils::random( 6 ) );

			if ( 'cart-form' === $this->form && ( ! WPC_WOO_ACTIVE || ! $this->product ) ) {
				$this->form = 'quote-form';
			} elseif ( 'contact-form' === $this->form && ( ! WPC_CF7_ACTIVE || empty( $this->contact_form ) ) ) {
				$this->form = 'quote-form';
			}

			add_filter( 'wpcf7_form_hidden_fields', array( $this, 'wpcf7_form_fields' ) );

			$this->config[ $this->id ] = wpc_get_configurator( $this->id );

			// Get current user role.
			$this->role = WPC_Utils::user_role();

			// If the style is not registed load the default style.
			$styles = array_keys( WPC_Utils::get_styles() );

			$this->style = ( in_array( $this->style, $styles, true ) ) ? $this->style : 'accordion-2';

			$this->default_term_id = (int) get_option( 'default_term_wpc_inspirations_cat' );

			$support_multiple_level = apply_filters( 'wpc_support_multiple_level_control', array( 'accordion-2', 'popover' ) );

			$this->allow_multiple_level = in_array( $this->style, $support_multiple_level, true ) ? true : false;

			$inspirations_terms = get_terms(
				array(
					'taxonomy'   => 'wpc_inspirations_cat',
					'hide_empty' => false,
				)
			);

			$this->inspirations_terms = wp_list_pluck( $inspirations_terms, 'name', 'term_id' );

			unset( $this->inspirations_terms[ $this->default_term_id ] );

			$this->title = $this->config[ $this->id ]->get_title();

			$this->components = $this->config[ $this->id ]->get_components();

			$this->layers = $this->config[ $this->id ]->get_layers();

			$top_layers = $this->config[ $this->id ]->get_top_layers();

			$this->top_layers = array();
			foreach ( $top_layers as $key => $uid ) {
				if ( wpc_is_control_allowed( $uid, $this ) ) {
					$this->top_layers[] = $uid;
				}
			}

			$this->anchestor_uid = $this->config[ $this->id ]->get_anchestor_id();

			$this->base_price = $this->config[ $this->id ]->get_base_price();

			// Editor images.
			$this->editor_images = $this->config[ $this->id ]->get_images();

			$this->hotspots = $this->config[ $this->id ]->get_hotspots();

			// Get total views.
			$this->total_views = $this->config[ $this->id ]->get_views();

			$this->cart_thumbnail_view = $this->config[ $this->id ]->get_cart_thumbnail_view();

			$this->active_uid = $this->config[ $this->id ]->get_active();

			$this->active_tree_sets = $this->config[ $this->id ]->get_active_tree_sets();

			$this->active_uid_string = $this->config[ $this->id ]->get_active_uid_string();

			$this->inspiration_posts = $this->config[ $this->id ]->get_inspiration_posts();

			$this->extras = $this->config[ $this->id ]->get_extra_data();

			$this->image_max_width  = $this->config[ $this->id ]->get_image_max_width();
			$this->image_max_height = $this->config[ $this->id ]->get_image_max_height();

			$this->enqueue_scripts();

			/**
			 * Hook: After scripts loaded.
			 *
			 * * @since 3.1
			 * * @version 3.4.13
			 */
			do_action( 'wpc_shortcode_initialized', $this, $code );

			return true;
		}

		/**
		 * Enqueue CSS and Scripts.
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			wp_enqueue_style( 'wpc-google-fonts' );
			wp_enqueue_style( 'wpc-carousel' );
			wp_enqueue_style( 'magnify' );

			if ( is_rtl() ) {
				wp_enqueue_style( 'wpc-rtl' );
			}

			wp_enqueue_script( 'wpc-carousel' );
			wp_enqueue_script( 'wpc-html2canvas' );
			wp_enqueue_script( 'magnify' );
			wp_enqueue_script( 'jquery-base64' );
			wp_enqueue_script( 'accounting' );
			wp_enqueue_script( 'clipboard' );
			wp_enqueue_script( 'wpc-utils' );
			wp_enqueue_script( 'wpc-frontend-script' );

			$this->remove_price_is_empty = get_option( 'wpc_remove_price_is_empty', false );

			// If it's full window style, remove the unneccesary styles.
			$this->remove_all_scripts();
			$this->remove_all_styles();

			/**
			 * Hook: After scripts loaded.
			 *
			 * * @since 3.1
			 *
			 * @param int    $this->id Configurator ID.
			 */
			do_action( 'wpc_after_scripts_loaded', $this );
		}

		/**
		 * Print global data in localize script.
		 *
		 * @return void
		 */
		public function print_localize_script() {

			if ( ! empty( $this->extras ) && isset( $this->extras['css'] ) ) {
				if ( ! wp_style_is( 'wpc-frontend-inline' ) ) {
					$style = '';
					foreach ( $this->extras['css'] as $propery => $value ) {
						$style .= $propery . '{ ' . $value . ' } ';
					}

					wp_register_style( 'wpc-frontend-inline-' . $this->id, false );
					wp_enqueue_style( 'wpc-frontend-inline-' . $this->id );

					wp_add_inline_style( 'wpc-frontend-inline-' . $this->id, $style );
				}
			}

			$thumb_size = get_option( 'wpc_thumb_size', 300 );

			?>
			<script type="text/javascript">
				<?php
				echo 'var wpc_plugin = ' . wp_json_encode(
					apply_filters(
						'wpc_localize_script',
						array(
							'ajaxurl'                 => esc_url( admin_url( 'admin-ajax.php' ) ),
							'rtl'                     => is_rtl() ? 'true' : 'false',
							'thumb_size'              => empty( $thumb_size ) ? 300 : esc_html( $thumb_size ),
							'price_details'           => esc_html( $this->price_details ),
							'show_group_price'        => esc_html( $this->group_price ),
							'show_total_price'        => esc_html( $this->total_price ),
							'remove_price_is_empty'   => esc_html( $this->remove_price_is_empty ),
							'image_partially_encoded' => apply_filters( 'wpc_image_partially_encoded', 'false' ),
							'icons'                   => WPC_Utils::icon(),
							'custom_fonts'            => get_option( 'wpc_custom_fonts', array() ),
							'is_edit_url'             => isset( $_GET['update'] ),
						),
						$this
					)
				) . ';';
				?>

				var wpc_<?php echo esc_attr( $this->id ); ?>_views = <?php echo wp_json_encode( $this->total_views ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_layers = <?php echo wp_json_encode( $this->layers ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_top_layers = <?php echo wp_json_encode( $this->top_layers ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_anchestor_uid = <?php echo wp_json_encode( $this->anchestor_uid ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_editor_images = <?php echo wp_json_encode( $this->editor_images ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_inspiration_posts = <?php echo wp_json_encode( $this->inspiration_posts ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_extras = <?php echo wp_json_encode( $this->extras ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_base_price = <?php echo wp_json_encode( $this->base_price ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_cart_thumbnail_view = <?php echo wp_json_encode( array( $this->cart_thumbnail_view ) ); ?>;
				<?php
				echo 'var wpc_' . esc_attr( $this->id ) . '_image_max_dimension = ' . wp_json_encode(
					array(
						'width'  => $this->image_max_width,
						'height' => $this->image_max_height,
					)
				) . ';';
				?>
				var wpc_<?php echo esc_attr( $this->id ); ?>_tree_set = <?php echo wp_json_encode( $this->active_tree_sets ); ?>;
				var wpc_<?php echo esc_attr( $this->id ); ?>_reset_tree_set = <?php echo wp_json_encode( $this->active_tree_sets ); ?>;

				<?php
				/**
				 * Hook: Add custom localize scripts.
				 *
				 * * @since 3.4.6
				 *
				 * @param WPCSE $this WPCSE.
				 */
				do_action( 'wpc_localize_scripts', $this );
				?>
			</script>
			<?php
		}

		/**
		 * Remove Theme/3rd Party plugin scripts, if it's full window style.
		 *
		 * @return void
		 */
		public function remove_all_scripts() {

			if ( WPC_Utils::is_full_window_style( $this->style ) && apply_filters( 'wpc_remove_unwanted_scripts_in_full_window_style', true ) ) {
				$allowed_scripts = apply_filters( 'wpc_full_window_allowed_scripts', array( 'cf7', 'swv', 'wpcf7-recaptcha', 'wpc-common-script', 'wpc-carousel', 'wpc-html2canvas', 'magnify', 'jquery-base64', 'accounting', 'clipboard', 'wpc-utils', 'wpc-frontend-script' ) );

				global $wp_scripts;

				foreach ( $wp_scripts->queue as $key => $script ) {
					if ( ! in_array( $script, $allowed_scripts, true ) ) {
						unset( $wp_scripts->queue[ $key ] );
					}
				}
			}

		}

		/**
		 * Remove Theme/3rd Party plugin style, if it's full window style.
		 *
		 * @return void
		 */
		public function remove_all_styles() {

			if ( WPC_Utils::is_full_window_style( $this->style ) ) {

				global $wp_styles;

				$allowed_styles = apply_filters( 'wpc_full_window_allowed_styles', array( 'admin-bar', 'wpc-general', 'wpc-frontend-inline', 'wpc-google-fonts', 'wpc-icon', 'wpc-carousel', 'magnify', 'wpc-rtl' ) );

				foreach ( $wp_styles->queue as $key => $style ) {
					if ( ! in_array( $style, $allowed_styles, true ) ) {
						wp_dequeue_style( $style );
					}
				}
			}
		}

		/**
		 * Is configurator post or it is linked with configurator?
		 *
		 * @return boolean
		 */
		public function is_config_post() {
			$config_post = get_post_type( $this->id );

			return ( 'amz_configurator' === $config_post ) ? true : false;
		}
	}
}
