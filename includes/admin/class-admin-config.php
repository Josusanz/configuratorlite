<?php
/**
 * Admin Configurations.
 *
 * @package  wp-configurator-pro/includes/admin/
 * @since  2.0
 * @version  3.5.2
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Admin_Config' ) ) {
	/**
	 * Admin configuration.
	 */
	class WPC_Admin_Config {

		public $styles = array();

		/**
		 * Constructor.
		 */
		public function __construct() {

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_filter( 'wpcf7_collect_mail_tags', array( $this, 'mail_tags' ), 10, 2 );

			add_filter( 'page_row_actions', array( $this, 'page_row_actions' ), 10, 2 );

			add_action( 'admin_action_wpc_duplicate_config_post', array( $this, 'duplicate_post' ) );

			add_filter( 'plugin_action_links_' . WPC_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );

			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

			add_action( 'before_delete_post', array( $this, 'delete_inspiration_with_configurator' ), 99, 2 );

			add_action( 'admin_footer', array( $this, 'create_configurator_popup_template' ) );

			add_action( 'quick_edit_custom_box', array( $this, 'quick_edit' ), 10, 2 );

			add_action( 'save_post', array( $this, 'quick_edit_save' ), 10, 2 );

			add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 10 );

			add_filter( 'ajax_query_attachments_args', array( $this, 'remove_configurator_thumbnail' ), 10, 1 );

			add_action( 'get_sample_permalink_html', array( $this, 'sample_permalink_html' ), 10, 5 );

			add_action( 'edit_form_after_title', array( $this, 'edit_form_after_title' ) );

			add_filter( 'wpcf7_editor_panels', array( $this, 'wpcf7_editor_panels' ), 10, 1 );

			add_action( 'wpcf7_save_contact_form', array( $this, 'wpcf7_save_contact_form' ), 10, 3 );

			add_filter( 'wpcf7_pre_construct_contact_form_properties', array( $this, 'pre_construct_contact_form_properties' ), 10, 1 );

			add_filter( 'wpc_editor_layer_control_conditions_tags', array( $this, 'editor_layer_control_conditions_tags' ), 10, 1 );
			add_filter( 'wpc_editor_layer_control_conditions_info_image', array( $this, 'editor_layer_control_conditions_info_image' ), 10, 1 );
			add_filter( 'wpc_editor_layer_control_conditions_description', array( $this, 'editor_layer_control_conditions_description' ) );

		}

		public function editor_layer_control_conditions_tags( $conditions = array() ) {

			$styles = WPC_Utils::get_styles();

			foreach ( $styles as $style => $value ) {
				if ( ! apply_filters( 'wpc_' . $style . '_allow_control_item_filter', false ) ) {
					$conditions['term'][] = array( 'style', $style, '!=' );
				}
			}

			return $conditions;
		}

		public function editor_layer_control_conditions_info_image( $conditions = array() ) {

			$styles = WPC_Utils::get_styles();

			foreach ( $styles as $style => $value ) {
				if ( ! apply_filters( 'wpc_' . $style . '_allow_control_info_popup', false ) ) {
					$conditions['term'][] = array( 'style', $style, '!=' );
				}
			}

			return $conditions;
		}

		public function editor_layer_control_conditions_description( $conditions = array() ) {

			$styles = WPC_Utils::get_styles();

			foreach ( $styles as $style => $value ) {
				if ( apply_filters( 'wpc_' . $style . '_allow_layer_description', false ) ) {
					$conditions['term'][] = array( 'style', $style, '==' );
				}
			}

			return $conditions;
		}

		public function pre_construct_contact_form_properties( $builtin_properties = array() ) {
			$builtin_properties['user_config_tags'] = array();

			return $builtin_properties;
		}

		public function wpcf7_editor_panels( $panels = array() ) {

			$panels['user_config_tags'] = array(
				'title'    => esc_html__( 'Configurator ( Config Mail List and Invoices )', 'wp-configurator-pro' ),
				'callback' => array( $this, 'wpcf7_editor_template' ),
			);

			return $panels;

		}

		public function wpcf7_save_contact_form( $contact_form, $args, $context ) {

			$properties['user_config_tags'] = isset( $_POST['wpc-user-config'] ) ? $_POST['wpc-user-config'] : array();

			$contact_form->set_properties( $properties );

		}

		public function wpcf7_editor_template( $post ) {

			include WPC_INCLUDE_DIR . 'admin/views/html-cf7-editor-template.php';
		}


		/**
		 * Check if we're saving, the trigger an action based on the post type.
		 *
		 * @param  int    $post_id Post ID.
		 * @param  object $post Post object.
		 */
		public function quick_edit_save( $post_id, $post ) {

			if ( isset( $_REQUEST['_wpc_quick_edit_save_product'] ) ) {
				$config_id    = isset( $_REQUEST['_wpc_config_id'] ) ? $_REQUEST['_wpc_config_id'] : '';
				$config_style = isset( $_REQUEST['_wpc_config_style'] ) ? $_REQUEST['_wpc_config_style'] : '';

				update_post_meta( $post_id, '_wpc_config_id', $config_id );
				update_post_meta( $post_id, '_wpc_config_style', $config_style );

				update_post_meta( (int) $config_id, '_wpc_product_id', $post_id );
				update_post_meta( (int) $config_id, '_wpc_config_style', $config_style );
			}

			if ( isset( $_REQUEST['_wpc_quick_edit_save_configurator'] ) ) {
				$config_style          = isset( $_REQUEST['_wpc_config_style'] ) ? $_REQUEST['_wpc_config_style'] : '';
				$form                  = isset( $_REQUEST['_wpc_form'] ) ? $_REQUEST['_wpc_form'] : '';
				$description           = isset( $_REQUEST['_wpc_description'] ) ? $_REQUEST['_wpc_description'] : '';
				$base_price            = isset( $_REQUEST['_wpc_base_price'] ) ? $_REQUEST['_wpc_base_price'] : '';
				$load_configurator_in  = isset( $_REQUEST['_wpc_load_configurator_in'] ) ? $_REQUEST['_wpc_load_configurator_in'] : '';
				$configurator_template = isset( $_REQUEST['_wpc_configurator_template'] ) ? $_REQUEST['_wpc_configurator_template'] : '';

				update_post_meta( $post_id, '_wpc_config_style', $config_style );
				update_post_meta( $post_id, '_wpc_form', $form );
				update_post_meta( $post_id, '_wpc_description', $description );
				update_post_meta( $post_id, '_wpc_base_price', $base_price );
				update_post_meta( $post_id, '_wpc_load_configurator_in', $load_configurator_in );
				update_post_meta( $post_id, '_wpc_configurator_template', $configurator_template );
			}
		}

		/**
		 * Remove Customize menus from the Toolbar.
		 *
		 * @param WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance.
		 * @return void
		 */
		public function admin_bar_menu( $wp_admin_bar ) {

			$current_post_type = $this->get_current_post_type();

			if ( 'wpc_user_config' === $current_post_type || 'wpc_inspirations' === $current_post_type ) {
				$wp_admin_bar->remove_node( 'view' );
			}
		}

		/**
		 * Remove configurator thumbnail in the media library preview.
		 *
		 * @param array $query WP_Query arguements.
		 * @return array
		 */
		public function remove_configurator_thumbnail( $query ) {
			$query['meta_query'] = array(
				array(
					'key'     => 'config_attachment',
					'compare' => 'NOT EXISTS',
				)
			);

			return apply_filters( 'wpc_thumbnail_query_args', $query );
		}

		/**
		 * Remove sample permalink HTML markup.
		 *
		 * @param string  $html      Sample permalink HTML markup.
		 * @param int     $post_id   Post ID.
		 * @param string  $new_title New sample permalink title.
		 * @param string  $new_slug  New sample permalink slug.
		 * @param WP_Post $post      Post object.
		 * @return string
		 */
		public function sample_permalink_html( $html, $post_id, $new_title, $new_slug, $post ) {
			if ( 'wpc_user_config' === $post->post_type ) {
				return '';
			}

			return $html;
		}

		/**
		 * Add Edit Configurator HTML markup.
		 *
		 * @param WP_Post $post      Post object.
		 * @return string
		 */
		public function edit_form_after_title( $post ) {
			if ( 'amz_configurator' === $post->post_type ) {
				?>
				<div id="wpc-post-editor-area">
					<a id="wpc-go-to-edit-page-link" href="<?php echo esc_url( admin_url( 'edit.php?post_type=amz_configurator&page=wpc-editor&post=' . esc_attr( $post->ID ) ) ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Edit with Configurator', 'wp-configurator-pro' ); ?></a>
				<?php
			}
		}

		/**
		 * Add additional Contact form mail content placeholder.
		 *
		 * @param array $mailtags Contact form mail content placeholder.
		 * @return array
		 */
		public function mail_tags( $mailtags ) {
			$mailtags['request-id']         = 'request-id';
			$mailtags['configurator-title'] = 'configurator-title';
			$mailtags['product-title']      = 'product-title';
			$mailtags['summary']            = 'configurator-options';
			$mailtags['view-config-btn']    = 'view-config-btn';

			return $mailtags;
		}

		/**
		 * Register CSS and Scripts.
		 *
		 * @param array $hook_suffix The current admin page.
		 * @return void
		 */
		public function enqueue_scripts( $hook_suffix ) {

			// Load CSS.
			if ( 'amz_configurator_page_wpc-editor' !== $hook_suffix ) {
				wp_enqueue_style( 'wpc-admin', WPC_ASSETS_URL . 'backend/css/admin.css', array( 'wp-color-picker' ), '3.5.2' );
			}

			if ( is_rtl() ) {
				wp_enqueue_style( 'wpc-rtl', WPC_ASSETS_URL . 'backend/css/rtl.css', array(), '2.4.2' );
			}

			// Load JS.
			wp_enqueue_script( 'wpc-admin-script', WPC_ASSETS_URL . 'backend/js/admin.js', array( 'wp-color-picker' ), '3.2.2', true );

			if ( 'amz_configurator_page_wpc-settings' === $hook_suffix || 'amz_configurator' === $this->get_current_post_type() ) {

				// Load CSS.
				wp_enqueue_media();
				wp_enqueue_style( 'wpc-icon', WPC_ASSETS_URL . 'icon/wpc-icon.css', array(), '3.0' );

			}

			if ( 'amz_configurator_page_wpc-settings' === $hook_suffix ) {
				wp_enqueue_script( 'wpc-media-upload', WPC_ASSETS_URL . 'backend/js/media-upload.js', array( 'jquery' ), '2.0', true );
			}

			wp_localize_script(
				'wpc-admin-script',
				'wpc_i18n',
				array(
					'edit_invoice' => esc_html__( 'Edit Invoice', 'wp-configurator-pro' ),
					'save_invoice' => esc_html__( 'Save Invoice', 'wp-configurator-pro' ),
				)
			);

		}

		/**
		 * Post row actions.
		 *
		 * @since 1.0
		 * @access public
		 *
		 * @param array    $actions An array of row action links.
		 * @param \WP_Post $post    The post object.
		 *
		 * @return array An updated array of row action links.
		 */
		public function page_row_actions( $actions, $post ) {

			if ( 'wpc_inspirations' === $post->post_type ) {
				unset( $actions['view'] );
			}

			if ( 'wpc_user_config' === $post->post_type ) {

				$config_id  = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_id', '' );
				$product_id = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_product_id', '' );
				$encoded    = WPC_Utils::get_meta_value( $post->ID, '_wpc_user_config_encoded', '' );

				$allowed_html = array(
					'div'  => array(
						'class' => array(),
					),
					'span' => array(
						'class' => array(),
					),
					'ul'   => array(
						'class' => array(),
					),
					'li'   => array(
						'class' => array(),
					),
				);

				$permalink = ( WPC_WOO_ACTIVE ) && ! empty( $product_id ) ? get_permalink( $product_id ) : get_permalink( $config_id );

				$share_link = add_query_arg(
					array(
						'key' => $encoded,
					),
					$permalink
				);

				$actions['view'] = sprintf( '<a href="%1$s">%2$s</a>', esc_url( $share_link ), esc_html__( 'View Configuration', 'wp-configurator-pro' ) );
			}

			if ( ( 'amz_configurator' === $post->post_type ) && current_user_can( 'edit_posts' ) ) {

				unset( $actions['edit'] );

				$duplicate_link = add_query_arg(
					array(
						'action' => 'wpc_duplicate_config_post',
						'_nonce' => wp_create_nonce( 'wpc_duplicate_config_post_ajax' ),
						'post'   => esc_attr( $post->ID ),
					),
					admin_url()
				);

				$actions['duplicate'] = sprintf( '<a href="%1$s">%2$s</a>', esc_url( $duplicate_link ), __( 'Duplicate', 'wp-configurator-pro' ) );

				/* translators: %d: configurator ID. */
				$actions = array_merge( array( 'id' => sprintf( __( 'ID: %d', 'wp-configurator-pro' ), $post->ID ) ), $actions );

				/**
				 * Filter: Page row actions.
				 *
				 * * @since 3.0
				 *
				 * @param array   $actions Page row actions.
				 */
				$actions = apply_filters( 'wpc_page_row_actions', $actions, $post );

				// If database update required, remove actions.
				$update_link = add_query_arg(
					array(
						'action' => 'wpc_update_database',
						'_nonce' => wp_create_nonce( 'wpc_update_database' ),
					),
					admin_url( 'index.php' )
				);

				if ( WPC_Utils::required_meta_update( $post->ID ) ) {
					$actions = array( 'update' => sprintf( '<a href="%1$s">%2$s</a>', esc_url( $update_link ), __( 'Update database', 'wp-configurator-pro' ) ) );
				}
			}

			return $actions;

		}

		/**
		 * Whenever delete the configurator delete related inspirations along with.
		 *
		 * @param int    $post_id Post ID.
		 * @param object $post Post Object.
		 * @return void
		 */
		public function delete_inspiration_with_configurator( $post_id, $post ) {

			if ( 'amz_configurator' !== $post->post_type ) {
				return;
			} else {
				$posts = get_posts(
					array(
						'post_type'      => 'wpc_inspirations',
						'posts_per_page' => -1,
						'meta_query'     => array(
							array(
								'key'   => '_wpc_config_id',
								'value' => $post_id,
							),
						),
					)
				);

				if ( $posts ) {
					foreach ( $posts as $key => $post ) {
						wp_delete_post( $post->ID );
					}
				}
			}
		}

		public function quick_edit( $column_name, $post_type ) {

			if ( 'shortcode' === $column_name && 'amz_configurator' === $post_type ) {
				include WPC_INCLUDE_DIR . '/admin/views/html-quick-edit-configurator.php';
			}
		}

		public function create_configurator_popup_template() {
			include WPC_INCLUDE_DIR . '/admin/views/tmpl-create-configurator-popup.php';
		}

		/**
		 * Return current page post type.
		 *
		 * @return string
		 */
		public function get_current_post_type() {

			global $post, $typenow, $current_screen;

			if ( $post && $post->post_type ) {
				return $post->post_type;

			} elseif ( $typenow ) {
				return $typenow;

			} elseif ( $current_screen && $current_screen->post_type ) {
				return $current_screen->post_type;

			} elseif ( isset( $_REQUEST['post_type'] ) ) {
				return sanitize_key( $_REQUEST['post_type'] );
			}

			return null;

		}

		/**
		 * Duplicate a post as a draft and redirects to the edit post screen.
		 *
		 * @return void
		 */
		public function duplicate_post() {

			// Verify nonce.
			$nonce = isset( $_REQUEST['_nonce'] ) ? $_REQUEST['_nonce'] : '';
			if ( $nonce && ! wp_verify_nonce( $nonce, 'wpc_duplicate_config_post_ajax' ) || ! current_user_can( 'edit_posts' ) ) {
				wp_die( __( 'Security check', 'wp-configurator-pro' ) );
			}

			global $wpdb;

			if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) || ( isset( $_REQUEST['action'] ) && 'wpc_duplicate_config_post' == $_REQUEST['action'] ) ) ) {
				wp_die( esc_html__( 'No post to duplicate has been supplied!', 'wp-configurator-pro' ) );
			}

			/*
			 * get the original post id
			 */
			$post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );

			/*
			 * and all the original post data then
			 */
			$post = get_post( $post_id );

			/*
			 * if you don't want current user to be the new post author,
			 * then change next couple of lines to this: $new_post_author = $post->post_author;
			 */
			$current_user    = wp_get_current_user();
			$new_post_author = $current_user->ID;

			/*
			 * if post data exists, create the post duplicate
			 */
			if ( isset( $post ) && null !== $post ) {

				// New post arguements.
				$args = array(
					'comment_status' => $post->comment_status,
					'ping_status'    => $post->ping_status,
					'post_author'    => $new_post_author,
					'post_content'   => $post->post_content,
					'post_excerpt'   => $post->post_excerpt,
					'post_name'      => $post->post_name,
					'post_parent'    => $post->post_parent,
					'post_password'  => $post->post_password,
					'post_status'    => 'draft',
					/* translators: %s: Post title. */
					'post_title'     => sprintf( esc_html__( '%s (Copy)', 'wp-configurator-pro' ), $post->post_title ),
					'post_type'      => $post->post_type,
					'to_ping'        => $post->to_ping,
					'menu_order'     => $post->menu_order,
				);

				/*
				 * insert the post by wp_insert_post() function
				 */
				$new_post_id = wp_insert_post( $args );

				/*
				 * get all current post terms ad set them to the new post draft
				 */
				$taxonomies = get_object_taxonomies( $post->post_type );
				foreach ( $taxonomies as $taxonomy ) {
					$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
					wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
				}

				/*
				 * duplicate all post meta just in two SQL queries
				 */
				$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
				if ( count( $post_meta_infos ) != 0 ) {
					$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
					foreach ( $post_meta_infos as $meta_info ) {
						$meta_key = $meta_info->meta_key;

						$meta_value      = addslashes( $meta_info->meta_value );
						$sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
					}
					$sql_query .= implode( ' UNION ALL ', $sql_query_sel );
					$wpdb->query( $sql_query );
				}

				/*
				 * finally, redirect to the edit post screen for the new draft
				 */
				wp_redirect( admin_url( 'edit.php?post_type=amz_configurator&page=wpc-editor&post=' . esc_attr( $new_post_id ) ) );
				exit;
			} else {
				wp_die( esc_html__( 'Post creation failed, could not find original post.', 'wp-configurator-pro' ) );
			}
		}

		/**
		 * Filters the action links displayed for each plugin in the Plugins list table.
		 *
		 * @param array $actions An array of plugin action links.
		 * @return array
		 */
		public function plugin_action_links( $actions = array() ) {

			$new_action['settings'] = '<a href="' . admin_url( 'edit.php?post_type=amz_configurator&page=wpc-settings' ) . '">' . esc_html__( 'Settings', 'wp-configurator-pro' ) . '</a>';

			$status = get_option( 'wpc_license_status' );
			if ( ! $status || 'valid' !== $status ) {
				$new_action['license'] = '<a href="' . admin_url( 'edit.php?post_type=amz_configurator&page=wpc-settings&tab=license' ) . '">' . esc_html__( 'Activate License', 'wp-configurator-pro' ) . '</a>';

			}

			return array_merge( $new_action, $actions );
		}

		/**
		 * Filters the array of row meta for each plugin in the Plugins list table.
		 *
		 * @param array  $plugin_meta An array of the plugin's metadata, including the version, author, author URI, and plugin URI.
		 * @param string $plugin_file Path to the plugin file relative to the plugins directory.
		 * @param array  $plugin_data An array of plugin data.
		 * @param string $status Status filter currently applied to the plugin list.
		 * @return array
		 */
		public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
			if ( false !== strpos( $plugin_file, 'wp-configurator-pro.php' ) ) {
				$plugin_meta['doc']       = '<a href="http://documentation.wpconfigurator.com/" target="_blank">' . esc_html__( 'Docs & FAQs', 'wp-configurator-pro' ) . '</a>';
				$plugin_meta['video-tut'] = '<a href="https://www.youtube.com/watch?v=D9Brv76YBMU&list=PLVpni88uzYchMGWA9y09kfK5nwZgpPdgN" target="_blank">' . esc_html__( 'Video Tutorial', 'wp-configurator-pro' ) . '</a>';
			}

			return $plugin_meta;
		}
	}

	$GLOBALS['wpc_admin_config'] = new WPC_Admin_Config();

}
