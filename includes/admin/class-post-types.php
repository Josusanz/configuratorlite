<?php
/**
 * Core post type class.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @since  2.0
 * @version  3.2.5
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Post_Types' ) ) {
	class WPC_Post_Types {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'register_post_types' ) );
			add_action( 'template_redirect', array( $this, 'redirect_to_product' ) );

			add_action( 'wpc_custom_column_shortcode', array( $this, 'custom_column_shortcode' ), 10, 2 );

			add_filter( 'manage_amz_configurator_posts_columns', array( $this, 'configurator_posts_columns' ) );
			add_action( 'manage_amz_configurator_posts_custom_column', array( $this, 'configurator_posts_custom_column' ), 10, 2 );

			add_filter( 'manage_wpc_user_config_posts_columns', array( $this, 'user_config_posts_columns' ) );
			add_action( 'manage_wpc_user_config_posts_custom_column', array( $this, 'user_config_posts_custom_column' ), 10, 2 );

			add_action( 'add_inline_data', array( $this, 'add_inline_data' ), 10, 2 );

			add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
			add_action( 'add_meta_boxes', array( $this, 'remove_meta_boxes' ), 10 );

			add_action( 'save_post', array( $this, 'save_post' ) );

		}

		/**
		 * Register core post types.
		 */
		public static function register_post_types() {
			if ( post_type_exists( 'amz_configurator' ) && post_type_exists( 'wpc_user_config' ) ) {
				return;
			}

			/* Configurator Post Type */

			$args = array(
				'labels'              => array(
					'name'               => esc_html__( 'Configurators', 'wp-configurator-pro' ),
					'singular_name'      => esc_html__( 'Configurator', 'wp-configurator-pro' ),
					'add_new'            => esc_html__( 'New Configurator', 'wp-configurator-pro' ),
					'add_new_item'       => esc_html__( 'Add New Configurator', 'wp-configurator-pro' ),
					'edit_item'          => esc_html__( 'Edit Configurator', 'wp-configurator-pro' ),
					'new_item'           => esc_html__( 'Add New Configurator', 'wp-configurator-pro' ),
					'view_item'          => esc_html__( 'View Configurator', 'wp-configurator-pro' ),
					'search_items'       => esc_html__( 'Search Configurator', 'wp-configurator-pro' ),
					'not_found'          => esc_html__( 'No configurations found', 'wp-configurator-pro' ),
					'all_items'          => esc_html__( 'All configurators', 'wp-configurator-pro' ),
					'not_found_in_trash' => esc_html__( 'No configurators found in Trash', 'wp-configurator-pro' ),
					'parent_item_colon'  => '',
					'menu_name'          => esc_html__( 'Configurator', 'wp-configurator-pro' ),
				),
				'public'              => true,
				'query_var'           => 'wp-configurator-pro',
				'hierarchical'        => true,
				'menu_icon'           => 'dashicons-image-filter',
				'rewrite'             => array(
					'slug' => 'configurator',
				),
				'exclude_from_search' => true,
				'supports'            => array( 'title' ),
			);

			/**
			 * Filter: Configurator post type arguements.
			 *
			 * * @since 3.0
			 *
			 * @param string   $args Arguements.
			 */
			register_post_type( 'amz_configurator', apply_filters( 'wpc_configurator_post_type', $args ) );

			/* User Customization Post Type */

			$args = array(
				'labels'              => array(
					'name'               => esc_html__( 'User Customization', 'wp-configurator-pro' ),
					'singular_name'      => esc_html__( 'User Customization', 'wp-configurator-pro' ),
					'add_new'            => esc_html__( 'New Customization', 'wp-configurator-pro' ),
					'add_new_item'       => esc_html__( 'Add New Customization', 'wp-configurator-pro' ),
					'edit_item'          => esc_html__( 'Edit Customization', 'wp-configurator-pro' ),
					'new_item'           => esc_html__( 'Add New Customization', 'wp-configurator-pro' ),
					'view_item'          => esc_html__( 'View Customization', 'wp-configurator-pro' ),
					'search_items'       => esc_html__( 'Search Customization', 'wp-configurator-pro' ),
					'not_found'          => esc_html__( 'No customization found', 'wp-configurator-pro' ),
					'all_items'          => esc_html__( 'Config Mail List', 'wp-configurator-pro' ),
					'not_found_in_trash' => esc_html__( 'No customization found in Trash', 'wp-configurator-pro' ),
					'parent_item_colon'  => '',
					'menu_name'          => esc_html__( 'Config Mail List', 'wp-configurator-pro' ),
				),
				'public'              => true,
				'query_var'           => 'wpc-user-config',
				'hierarchical'        => true,
				'menu_icon'           => 'dashicons-image-filter',
				'rewrite'             => array(
					'slug' => 'wpc-user-config',
				),
				'show_in_menu'        => 'edit.php?post_type=amz_configurator',
				'exclude_from_search' => true,
				'supports'            => array( 'editor' ),
			);

			/**
			 * Filter: User config mail list post type arguements.
			 *
			 * * @since 2.6.1
			 *
			 * @param string   $args Arguements.
			 */
			register_post_type( 'wpc_user_config', apply_filters( 'wpc_user_config_post_type', $args ) );


			/**
			 * Hook: After core post types registered.
			 *
			 * * @since 3.5.3
			 *
			 */
			do_action( 'wpc_register_post_type' );
		}

		public function redirect_to_product( $template ) {
			$queried_post_type = get_query_var( 'post_type' );

			if ( is_single() && 'amz_configurator' == $queried_post_type ) {

				$id = get_the_ID();

				$product_id = WPC_Utils::get_meta_value( $id, '_wpc_product_id', 0 );

				if ( ! empty( $product_id ) && WPC_WOO_ACTIVE ) {
					wp_safe_redirect( get_permalink( $product_id ) );
					exit;
				}
			}

			return $template;
		}

		public function configurator_posts_columns( $columns ) {
			if ( empty( $columns ) && ! is_array( $columns ) ) {
				$columns = array();
			}

			unset( $columns['title'], $columns['comments'], $columns['date'] );

			$show_columns          = array();
			$show_columns['cb']    = '<input type = "checkbox" />';
			$show_columns['title'] = esc_html__( 'Title', 'wp-configurator-pro' );

			$show_columns['shortcode'] = esc_html__( 'Shortcode', 'wp-configurator-pro' );
			$show_columns['date']      = esc_html__( 'Date', 'wp-configurator-pro' );

			return array_merge( $show_columns, $columns );
		}

		public function configurator_posts_custom_column( $column, $post_id ) {

			if ( 'shortcode' === $column ) {
				$style = WPC_Utils::get_meta_value( $post_id, '_wpc_config_style', true );

				do_action( 'wpc_custom_column_shortcode', $post_id, $style );

			}
		}

		public function user_config_posts_columns( $columns ) {
			if ( empty( $columns ) && ! is_array( $columns ) ) {
				$columns = array();
			}

			unset( $columns['title'], $columns['comments'], $columns['date'] );

			$show_columns                   = array();
			$show_columns['cb']             = '<input type = "checkbox" />';
			$show_columns['title']          = esc_html__( 'Title', 'wp-configurator-pro' );
			$show_columns['configurator']   = esc_html__( 'Configurator', 'wp-configurator-pro' );
			$show_columns['status']         = esc_html__( 'Status', 'wp-configurator-pro' );
			$show_columns['customer_email'] = esc_html__( 'Customer Email', 'wp-configurator-pro' );
			$show_columns['requested_at']   = esc_html__( 'Requested at', 'wp-configurator-pro' );

			return array_merge( $show_columns, $columns );
		}

		public function user_config_posts_custom_column( $column, $post_id ) {
			if ( 'configurator' === $column ) {
				$config_id = WPC_Utils::get_meta_value( $post_id, '_wpc_user_config_id', 0 );
				echo '<strong><a class="row-title" href="' . esc_url( get_permalink( $config_id ) ) . '">' . esc_html( get_the_title( $config_id ) ) . '</a></strong>';
			} elseif ( 'status' === $column ) {

				$status_lists = WPC_Utils::get_email_status_lists();

				$status = WPC_Utils::get_meta_value( $post_id, '_wpc_user_config_status', 'processing' );

				if ( isset( $status_lists[ $status ] ) ) {
					echo '<span class="wpc-user-config-status wpc-user-config-status-' . esc_attr( $status ) . '">' . esc_html( $status_lists[ $status ] ) . '</span>';
				}
			} elseif ( 'customer_email' === $column ) {
				$email = WPC_Utils::get_meta_value( $post_id, '_wpc_user_config_email', '' );

				echo '<a href="mailto: ' . sanitize_email( $email ) . ' ">' . esc_html( $email ) . '</span>';
			} elseif ( 'requested_at' === $column ) {
				$requested_at = WPC_Utils::get_meta_value( $post_id, '_wpc_user_config_date_created', '' );

				echo sprintf(
					/* translators: 1: Post date, 2: Post time. */
					esc_html__( '%1$s at %2$s', 'wp-configurator-pro' ),
					esc_html( date_i18n( 'Y/m/d', strtotime( $requested_at ) ) ),
					esc_html( date_i18n( 'g:i a', strtotime( $requested_at ) ) )
				);
			}
		}

		public function custom_column_shortcode( $post_id, $style ) {
			if ( 'accordion' === $style ) {
				echo '<code>[wpc_config id="' . esc_attr( $post_id ) . '"]</code>';
			}
		}

		public function add_inline_data( $post, $post_type_object ) {
			if ( 'amz_configurator' === $post->post_type ) {

				$config_style          = isset( $post->_wpc_config_style ) ? $post->_wpc_config_style : 'style1';
				$form                  = isset( $post->_wpc_form ) ? $post->_wpc_form : 'quote-form';
				$base_price            = isset( $post->_wpc_base_price ) ? $post->_wpc_base_price : '';
				$load_configurator_in  = isset( $post->_wpc_load_configurator_in ) ? $post->_wpc_load_configurator_in : 'direct';
				$configurator_template = isset( $post->_wpc_configurator_template ) ? $post->_wpc_configurator_template : 'entire_product_page';
				$description           = isset( $post->_wpc_description ) ? $post->_wpc_description : '';

				echo '<div class="_wpc_config_style">' . esc_html( $config_style ) . '</div>';
				echo '<div class="_wpc_form">' . esc_html( $form ) . '</div>';
				echo '<div class="_wpc_base_price">' . esc_html( $base_price ) . '</div>';
				echo '<div class="_wpc_load_configurator_in">' . esc_html( $load_configurator_in ) . '</div>';
				echo '<div class="_wpc_configurator_template">' . esc_html( $configurator_template ) . '</div>';
				echo '<div class="_wpc_description">' . esc_html( $description ) . '</div>';
			}
		}

		public function register_meta_boxes() {

			add_meta_box(
				'wpc-user-config-request-details',
				esc_html__( 'Request Details', 'wp-configurator-pro' ),
				array( $this, 'render_request_details' ),
				'wpc_user_config',
				'normal',
				'high'
			);

			add_meta_box(
				'wpc-user-config-summary',
				esc_html__( 'Summary', 'wp-configurator-pro' ),
				array( $this, 'render_summary' ),
				'wpc_user_config',
				'normal',
				'high'
			);

			add_meta_box(
				'wpc-user-config-additional-details',
				esc_html__( 'Additional Details', 'wp-configurator-pro' ),
				array( $this, 'render_additional_details' ),
				'wpc_user_config',
				'normal',
				'high'
			);

			add_meta_box(
				'wpc-user-config-invoice',
				esc_html__( 'Invoice', 'wp-configurator-pro' ),
				array( $this, 'render_invoice' ),
				'wpc_user_config',
				'normal',
				'high'
			);

			add_meta_box(
				'wpc-user-config-actions',
				esc_html__( 'Request Actions', 'wp-configurator-pro' ),
				array( $this, 'render_action' ),
				'wpc_user_config',
				'side',
				'high'
			);
		}

		/** 
		 * Remove bloat.
		 */
		public function remove_meta_boxes() {
			remove_meta_box( 'submitdiv', 'wpc_user_config', 'side' );
		}

		public function render_request_details( $post ) {
			include WPC_INCLUDE_DIR . '/admin/views/html-config-mail-request-details.php';
		}

		public function render_additional_details( $post ) {
			include WPC_INCLUDE_DIR . '/admin/views/html-config-mail-additional-details.php';
		}

		public function render_summary( $post ) {
			include WPC_INCLUDE_DIR . '/admin/views/html-config-mail-summary.php';
		}

		public function render_invoice( $post ) {
			include WPC_INCLUDE_DIR . '/admin/views/html-config-mail-invoice.php';
		}

		public function render_action( $post ) {
			include WPC_INCLUDE_DIR . '/admin/views/html-config-mail-action.php';
		}

		public function save_post( $post_id ) {

			$old_requested_at = WPC_Utils::get_meta_value( $post_id, '_wpc_user_config_date_created', '' );
			$old_status       = WPC_Utils::get_meta_value( $post_id, '_wpc_user_config_status', 'processing' );

			if ( isset( $_POST['wpc_user_config_meta_nonce'] ) && ! wp_verify_nonce( $_POST['wpc_user_config_meta_nonce'], 'wpc_user_config_save_data' ) ) {
				die( esc_html__( 'Security check', 'wp-configurator-pro' ) );
			} else {

				if ( array_key_exists( '_wpc_user_config_request_date', $_POST ) || array_key_exists( '_wpc_user_config_request_date_hour', $_POST ) || array_key_exists( '_wpc_user_config_request_date_minute', $_POST ) || array_key_exists( '_wpc_user_config_request_date_second', $_POST ) ) {

					$requested_at = gmdate( 'Y-m-d H:i:s', strtotime( $_POST['_wpc_user_config_request_date'] . ' ' . (int) $_POST['_wpc_user_config_request_date_hour'] . ':' . (int) $_POST['_wpc_user_config_request_date_minute'] . ':' . (int) $_POST['_wpc_user_config_request_date_second'] ) );

					if ( $old_requested_at !== $requested_at ) {
						update_post_meta(
							$post_id,
							'_wpc_user_config_date_created',
							wp_unslash( $requested_at )
						);
					}
				}

				if ( array_key_exists( '_wpc_user_config_status', $_POST ) ) {

					$status = wp_unslash( $_POST['_wpc_user_config_status'] );

					if ( $old_status !== $status ) {
						update_post_meta(
							$post_id,
							'_wpc_user_config_status',
							$status
						);

						/**
						 * Hook: User config post status updated.
						 *
						 * * @since 3.2.2
						 *
						 * @param array $post_id Post ID.
						 */
						do_action( 'wpc_user_config_status_' . $status, $post_id, $old_status );

						/**
						 * Hook: User config post status updated.
						 *
						 * * @since 3.2.4
						 *
						 * @param array $post_id Post ID.
						 */
						do_action( 'wpc_user_config_status_' . $old_status . '_to_' . $status, $post_id, $old_status );

					}
				}
			}

		}

	}
}

new WPC_Post_Types();
