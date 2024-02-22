<?php
/**
 * Configurator components data.
 *
 * @package  wp-configurator-pro/includes/
 * @since  2.0
 * @version  3.5.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Data' ) ) {

	/**
	 * Manipulate Configurator data.
	 */
	class WPC_Data {

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
		protected $base_price;


		/**
		 * Active uid from url.
		 *
		 * @var array
		 */
		public $active_uid_from_url = array();		


		/**
		 * Anchestor Uid.
		 *
		 * @var string
		 */
		public $anchestor_id = '';


		/**
		 * It holds default active UID's separated with commas.
		 *
		 * @var string
		 */
		protected $active_uid = array();


		/**
		 * Configurator active layers tree sets.
		 *
		 * @var array
		 */
		protected $active_tree_sets = array();


		/**
		 * Configurator total views.
		 *
		 * @var array
		 */
		protected $total_views = array();


		/**
		 * Responsible view for cart thumbnail.
		 *
		 * @var array
		 */
		protected $cart_thumbnail_view = array();


		/**
		 * Configurator hotspots.
		 *
		 * @var array
		 */
		protected $hotspots = array();

		/**
		 * Configurator deselect child allow uids.
		 *
		 * @var array
		 */
		protected $deselect_child_uid = array();


		/**
		 * Configurator inspirations.
		 *
		 * @var array
		 */
		protected $inspiration = array();


		/**
		 * Configurator layers.
		 *
		 * @var array
		 */
		protected $layers = array();


		/**
		 * Configurator top layers.
		 *
		 * @var array
		 */
		protected $top_layers = array();


		/**
		 * Configurator editor images.
		 *
		 * @var array
		 */
		protected $editor_images = array();


		/**
		 * Configurator editor image max width.
		 *
		 * @var int
		 */
		protected $max_image_width = 0;


		/**
		 * Configurator editor image max height.
		 *
		 * @var int
		 */
		protected $max_image_height = 0;


		/**
		 * Configurator layer components.
		 *
		 * @var array
		 */
		protected $components = array();


		/**
		 * Configurator layer css.
		 *
		 * @var array
		 */
		protected $extras = array();


		/**
		 * Constructor.
		 *
		 * @param int $id Configurator ID.
		 */
		public function __construct( $id ) {

			do_action( 'wpc_config_data_start_manipulate', $id );

			$this->set_id( $id );
			$this->set_active_uid_from_url();
			$this->set_anchestor_id();
			$this->set_product_id();
			$this->set_base_price();
			$this->set_views();
			$this->set_cart_thumbnail_view();
			$this->set_images();
			$this->set_layers();
			$this->set_active_tree_sets();
			$this->set_deselect_siblings();
			$this->set_group_action_to_child_layers();

			do_action( 'wpc_config_data_initialized', $this );
		}

		/**
		 * Set configurator ID.
		 *
		 * @param int $id Configurator ID.
		 * @return void
		 */
		protected function set_id( $id ) {
			if ( $this->is_config_post( $id ) ) {
				$this->id = absint( $id );
			} else {
				$this->id = false;
			}
		}

		/**
		 * Returns active uid from url.
		 *
		 * @return array
		 */
		protected function set_active_uid_from_url() {
			$active_uid = $this->get_active();

			$key = isset( $_GET['key'] ) ? $_GET['key'] : '';

			$this->active_uid_from_url = ! empty( $key ) ? array_unique( explode( ',', base64_decode( $key ) ) ) : '';

			return $this->active_uid_from_url;
		}

		/**
		 * Set anchestor Uid.
		 *
		 * @return void
		 */
		protected function set_anchestor_id() {
			$this->anchestor_id = WPC_Utils::generate_uid();
		}

		/**
		 * Return anchestor Uid.
		 *
		 * @return string
		 */
		public function get_anchestor_id() {
			return $this->anchestor_id;
		}

		/**
		 * Set product ID.
		 *
		 * @return void
		 */
		protected function set_product_id() {
			$this->product_id = absint( WPC_Utils::get_meta_value( $this->id, '_wpc_product_id', false ) );
		}

		/**
		 * Set configurator base price.
		 *
		 * @return void
		 */
		protected function set_base_price() {
			$this->base_price = (float) WPC_Utils::get_meta_value( $this->id, '_wpc_base_price', '0' );
		}

		/**
		 * Set configurator total views.
		 *
		 * @return void
		 */
		protected function set_views() {
			$this->total_views = WPC_Utils::get_meta_value( $this->id, '_wpc_views', array( 'front' => esc_html__( 'Front', 'wp-configurator-pro' ) ) );
		}

		/**
		 * Set cart thumbnail view.
		 *
		 * @return void
		 */
		protected function set_cart_thumbnail_view() {
			$default = is_array( $this->total_views ) ? array_key_first( $this->total_views ) : 'front';

			$this->cart_thumbnail_view = WPC_Utils::get_meta_value( $this->id, '_wpc_responsible_view_cart_thumbnail', $default );
		}

		/**
		 * Set layer images list.
		 *
		 * @return void
		 */
		protected function set_images() {

			$include_on_image_dimension_calculation = apply_filters( 'wpc_include_on_image_dimension_calculation', array( 'image' ) );

			$this->editor_images = WPC_Utils::get_meta_value( $this->id, '_wpc_editor_images', array() );

			if ( ! empty( $this->editor_images ) && is_array( $this->editor_images ) ) {
				foreach ( $this->editor_images as $key => $image ) {
					if ( ! isset( $image['key'] ) || ( isset( $image['key'] ) && ! in_array( $image['key'], $include_on_image_dimension_calculation, true ) ) ) {
						continue;
					}

					if ( isset( $image['width'] ) && $image['width'] > $this->max_image_width ) {
						$this->max_image_width = $image['width'];
					}

					if ( isset( $image['height'] ) && $image['height'] > $this->max_image_height ) {
						$this->max_image_height = $image['height'];
					}
				}
			}
		}

		/**
		 * Get image max width.
		 *
		 * @return int
		 */
		public function get_image_max_width() {
			return $this->max_image_width;
		}

		/**
		 * Get image max height.
		 *
		 * @return int
		 */
		public function get_image_max_height() {
			return $this->max_image_height;
		}

		/**
		 * Set components layers as single dimentional format.
		 *
		 * @return array
		 */
		protected function set_layers() {
			$this->build_layer( $this->get_components() );

			return $this->layers;
		}

		/**
		 * Set active tree set.
		 *
		 * @return void
		 */
		protected function set_active_tree_sets() {
			$active_uid = $this->get_active();

			if ( ! empty( $active_uid ) && is_array( $active_uid ) ) {
				foreach ( $active_uid as $key => $uid ) {
					$tree_uid = $this->is_multiple( $uid ) ? $uid : $this->get_parent_uid( $uid );

					$this->active_tree_sets[ $tree_uid ] = $this->get_tree( $uid );
				}
			}
		}

		/**
		 * Set active tree set.
		 *
		 * @return void
		 */
		protected function set_deselect_siblings() {
			$deselect_child = $this->get_deselect_child();

			if ( ! empty( $deselect_child ) && is_array( $deselect_child ) ) {
				foreach ( $deselect_child as $key => $uid ) {

					$siblings_children = $this->get_siblings_children( $uid );

					if ( $siblings_children ) {
						$this->layers[ $uid ]['deselect_siblings'] = $siblings_children;
					}
				}
			}
		}

		/**
		 * If group has initial applies all the child layers as well.
		 *
		 * @return void
		 */
		protected function set_group_action_to_child_layers() {

			// Needs to run the group layer at last.
			$group_has_initial_state = isset( $this->group_has_initial_state ) ? array_reverse( $this->group_has_initial_state ) : false;

			if ( ! $group_has_initial_state ) {
				return;
			}

			if ( ! empty( $group_has_initial_state ) && is_array( $group_has_initial_state ) ) {
				foreach ( $group_has_initial_state as $uid => $initial_state ) {
					$this->apply_action_to_child_layers( $uid, array( $initial_state ) );
				}
			}
		}

		/**
		 * If layer has children applies initial state to all the child as well.
		 *
		 * @param string $parent_uid Parent layer uid.
		 * @return void
		 */
		protected function apply_action_to_child_layers( $parent_uid = '' ) {

			$children = isset( $this->layers[ $parent_uid ]['children'] ) ? $this->layers[ $parent_uid ]['children'] : false;

			$parent_actions = $this->get_layer_action( $parent_uid );

			if ( ! empty( $children ) && is_array( $children ) ) {
				foreach ( $children as $key => $uid ) {

					$type = $this->get_type( $uid );

					if ( 'sub_group' === $type ) {
						$group_initial_state = isset( $this->layers[ $uid ]['settings']['group_initial_state'] ) ? $this->layers[ $uid ]['settings']['group_initial_state'] : '';

						$action_pairs = WPC_Utils::get_layer_action_pairs( $group_initial_state );
					} else {
						$layer_initial_state = isset( $this->layers[ $uid ]['settings']['layer_initial_state'] ) ? $this->layers[ $uid ]['settings']['layer_initial_state'] : '';

						$action_pairs = WPC_Utils::get_layer_action_pairs( $layer_initial_state );
					}

					if ( $action_pairs && is_array( $action_pairs ) ) {
						$layer_action[ $action_pairs[0] ] = $action_pairs[1];
					} else {
						$layer_action = false;
					}

					$this->layers[ $uid ]['action'] = isset( $layer_action ) && $layer_action ? array_merge( $parent_actions, $layer_action ) : $parent_actions;

					// If the layer is active, add selected initial state.
					if ( in_array( $uid, $this->get_active(), true ) ) {
						$this->layers[ $uid ]['action'] = array_merge( $this->layers[ $uid ]['action'], array( 'is_selected' => true ) );
					}

					$has_child = isset( $this->layers[ $uid ]['children'] ) ? $this->layers[ $uid ]['children'] : false;

					if ( $has_child ) {
						$this->apply_action_to_child_layers( $uid );
					}
				}
			}
		}

		/**
		 * Returns layer children depends on deselect type.
		 *
		 * @param string $uid Layer uid.
		 * @return array
		 */
		public function get_siblings_children( $uid = '' ) {

			$siblings = array();

			$level = $this->get_level( $uid );

			if ( 1 === $level ) {
				return false;
			}

			$deselect_type = $this->get_deselect_type( $uid );
			$tree          = $this->get_tree( $uid );

			$tree_count = count( $tree );

			if ( 'everything' === $deselect_type ) {
				$parent = $tree[0];
			} else {
				$parent = $this->get_parent_uid( $uid );
			}

			$children = $this->layers[ $parent ]['children'];

			$siblings = $this->get_childrens( $children, $siblings, $deselect_type );

			if ( 'everything' === $deselect_type ) {
				$siblings = array_merge( array_filter( array_map( array( $this, 'is_not_group_layer' ), $children ) ), $siblings );
			}

			return $siblings;
		}

		/**
		 * Check wheather it is not group or sub group layer.
		 *
		 * @param string $uid Layer uid.
		 * @return boolean
		 */
		public function is_not_group_layer( $uid = '' ) {

			$type = $this->layers[ $uid ]['type'];
			if ( 'group' !== $type && 'sub_group' !== $type ) {
				return $uid;
			}
		}

		/**
		 * Returns sibling children.
		 *
		 * @param array  $children Layer children.
		 * @param array  $siblings Layer siblings.
		 * @param string $deselect_type Deselect type.
		 * @return array
		 */
		public function get_childrens( $children = array(), $siblings = array(), $deselect_type = '' ) {

			if ( ! empty( $children ) && is_array( $children ) ) {
				foreach ( $children as $key => $uid ) {

					if ( isset( $this->layers[ $uid ]['children'] ) ) {

						$siblings = array_merge( $siblings, array_filter( array_map( array( $this, 'is_not_group_layer' ), $this->layers[ $uid ]['children'] ) ) );

						if (
							'everything' === $deselect_type ||
							'siblings_with_children' === $deselect_type
						) {
							$siblings = $this->get_childrens( $this->layers[ $uid ]['children'], $siblings, $deselect_type );
						}
					}
				}

				return $siblings;
			}
		}

		/**
		 * Returns any of the direct child uid
		 *
		 * @param string $uid Layer uid.
		 * @return boolean
		 */
		public function get_any_child( $uid = '' ) {
			$parent_uid = $this->get_parent_uid( $uid );

			$siblings = $this->get_children( $parent_uid );

			if ( ! empty( $siblings ) && is_array( $siblings ) ) {
				foreach ( $siblings as $key => $value ) {
					if ( apply_filters( 'wpc_any_child', true, $value, $this ) && $uid !== $value ) {
						return $value;
					}
				}
			}

			return false;
		}

		/**
		 * Returns configurator ID.
		 *
		 * @return int
		 */
		public function get_id() {
			return $this->id;
		}

		/**
		 * Returns product ID.
		 *
		 * @return int
		 */
		public function get_product_id() {
			return $this->product_id;
		}

		/**
		 * Check it is configurator post.
		 *
		 * @param int $id Configurator ID.
		 * @return boolean
		 */
		public function is_config_post( $id ) {
			$post_type = get_post_type( $id );

			return ( 'amz_configurator' === $post_type ) ? true : false;
		}

		/**
		 * Returns active tree set.
		 *
		 * @return array
		 */
		public function get_active_tree_sets() {
			return $this->active_tree_sets;
		}

		/**
		 * Build layers.
		 *
		 * @param array   $layers Components.
		 * @param integer $level layer level.
		 * @param array   $parent_tree Parent tree.
		 * @param array   $parent_index Parent index.
		 * @param string  $parent Parent layer uid.
		 * @return void
		 */
		public function build_layer( $layers = array(), $level = 0, $parent_tree = array(), $parent_index = array(), $parent = '' ) {

			if ( ! isset( $this->layers ) ) {
				$this->layers = array();
			}

			$level++;

			if ( ! empty( $layers ) && is_array( $layers ) ) {
				foreach ( $layers as $key => $layer ) {

					$type = $layer['type'];

					unset( $layer['actions'] );

					if ( 1 === $level ) {
						$parent_tree  = array( $layer['uid'] );
						$parent_index = array( $key );
						$index        = array();

						$this->set_top_layers( $layer['uid'] );
					} else {
						$index = array( $key );
					}

					$this->layers[ $layer['uid'] ] = $layer;

					$tree = array( $layer['uid'] );

					$current_tree = array_values( array_unique( array_merge( $parent_tree, $tree ) ) );

					$current_tree_index = array_merge( $parent_index, $index );

					if ( 1 < $level ) {
						$count  = count( $current_tree ) - 2;
						$parent = $current_tree[ $count ];
					} else {
						$parent = false;

						$this->layers[ $layer['uid'] ]['random'] = $this->anchestor_id;
					}

					$this->layers[ $layer['uid'] ]['index'] = $current_tree_index;

					$this->layers[ $layer['uid'] ]['tree'] = $current_tree;

					$this->layers[ $layer['uid'] ]['parent'] = $parent;

					$this->layers[ $layer['uid'] ]['level'] = $level;

					$tags = isset( $layer['settings']['tags'] ) ? $layer['settings']['tags'] : array();

					if ( ! empty( $tags ) ) {
						$this->layers[ $parent ]['tags_of_children'] = isset( $this->layers[ $parent ]['tags_of_children'] ) ? array_unique( array_merge( $this->layers[ $parent ]['tags_of_children'], $tags ) ) : $tags;
					}

					if ( empty( $this->active_uid_from_url ) && isset( $layer['settings']['active'] ) && WPC_Utils::str_to_bool( $layer['settings']['active'] ) ) {
						$this->set_active( $layer['uid'] );
					}

					if ( isset( $layer['settings'] ) && isset( $layer['settings']['views'] ) ) {
						$this->set_hotspots( $layer['uid'], $layer['settings']['views'] );
					}

					if ( isset( $layer['settings'] ) && isset( $layer['settings']['deselect_child'] ) && WPC_Utils::str_to_bool( $layer['settings']['deselect_child'] ) ) {
						$this->set_deselect_child( $layer['uid'] );
					}

					if ( isset( $layer['children'] ) ) {
						$parent = $layer['uid'];
					}

					if ( 'group' === $type || 'sub_group' === $type ) {

						$this->layers[ $layer['uid'] ]['initial_state'] = isset( $layer['settings']['group_initial_state'] ) ? $layer['settings']['group_initial_state'] : '';

						$group_initial_state = isset( $layer['settings']['group_initial_state'] ) ? $layer['settings']['group_initial_state'] : '';

						$this->layers[ $layer['uid'] ]['action'] = $this->set_layer_action( $type, array( $group_initial_state ) );

						if ( $group_initial_state ) {
							$this->group_has_initial_state[ $layer['uid'] ] = $group_initial_state;
						}
					} else {
						$layer_initial_state = isset( $layer['settings']['layer_initial_state'] ) ? $layer['settings']['layer_initial_state'] : '';

						$this->layers[ $layer['uid'] ]['action'] = $this->set_layer_action( $type, array( $layer_initial_state ) );

						$this->layers[ $layer['uid'] ]['action']['is_selected'] = in_array( $layer['uid'], $this->get_active(), true ) ? true : false;

					}

					$this->layers[ $layer['uid'] ]['settings']['active'] = in_array( $layer['uid'], $this->get_active(), true ) ? true : false;

					$this->layers[ $layer['uid'] ] = apply_filters( 'wpc_config_data_layer', $this->layers[ $layer['uid'] ] );

					$this->extra_data( $layer['uid'] );

					if ( isset( $layer['children'] ) ) {
						$this->layers[ $layer['uid'] ]['children'] = wp_list_pluck( $layer['children'], 'uid' );

						$this->build_layer( $layer['children'], $level, array_merge( $parent_tree, $tree ), array_merge( $parent_index, $index ) );
					}

					$this->layers = apply_filters( 'wpc_config_data_manipulate_layers', $this->layers, $this->layers[ $layer['uid'] ], 'in_data' );
				}
			}

		}

		public function extra_data( $uid = '' ) {
			$this->extras = apply_filters( 'wpc_config_layer_extra_data', $this->extras, $uid, $this );
		}

		public function get_extra_data() {
			return apply_filters( 'wpc_config_extra_data', $this->extras, $this );
		}

		public function set_layer_action( $type, $initial_states = array() ) {

			$actions = array();

			if ( 'group' === $type || 'sub_group' === $type ) {
				$layer_actions = WPC_Utils::get_group_actions();
			} else {
				$layer_actions = WPC_Utils::get_layer_actions();
			}

			if ( ! empty( $initial_states ) && is_array( $initial_states ) ) {
				foreach ( $initial_states as $key => $initial_state ) {

					$pairs = WPC_Utils::get_layer_action_pairs( $initial_state );

					if ( $pairs ) {
						$actions[ $pairs[0] ] = $pairs[1];

						$index = array_search( $pairs[0], $layer_actions );

						unset( $layer_actions[ $index ] );
					}
				}
			}

			if ( ! empty( $layer_actions ) && is_array( $layer_actions ) ) {
				foreach ( $layer_actions as $key => $value ) {
					if ( 'is_closed' === $value ) {
						$actions[ $value ] = in_array( 'opened', $initial_states, true ) ? false : true;
					} else {
						$actions[ $value ] = in_array( 'deactivate', $initial_states, true ) ? true : false;
					}
				}
			}

			return $actions;
		}

		/**
		 * Returns layer actions
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_layer_action( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['action'] ) ? $this->layers[ $uid ]['action'] : false;
		}

		/**
		 * Group all top layer uids as array.
		 *
		 * @param string $uid Component layer uid.
		 * @return void
		 */
		protected function set_top_layers( $uid = '' ) {
			$this->top_layers[] = $uid;
		}

		/**
		 * Returns all top layer uids as array.
		 *
		 * @return array
		 */
		public function get_top_layers() {
			return $this->top_layers;
		}

		/**
		 * Set active uid.
		 *
		 * @param string $uid Component layer uid.
		 * @return void
		 */
		protected function set_active( $uid = '' ) {
			$this->active_uid[] = $uid;
		}

		/**
		 * Set hotspots uid.
		 *
		 * @param string $uid Component layer uid.
		 * @param string $views Layer views.
		 * @return void
		 */
		protected function set_hotspots( $uid = '', $views = array() ) {
			if ( ! empty( $views ) && is_array( $views ) ) {
				foreach ( $views as $view_key => $view ) {
					if ( isset( $view['hs_enable'] ) && WPC_Utils::str_to_bool( $view['hs_enable'] ) ) {
						$this->hotspots[ $view_key ][] = $uid;
					}
				}
			}
		}

		/**
		 * Set hotspots uid.
		 *
		 * @param string $uid Component layer uid.
		 * @return void
		 */
		protected function set_deselect_child( $uid = '' ) {
			$this->deselect_child_uid[] = $uid;
		}

		/**
		 * Get deselect child uid.
		 *
		 * @return array
		 */
		public function get_deselect_child() {
			return $this->deselect_child_uid;
		}

		/**
		 * Return active uid.
		 *
		 * @return array
		 */
		public function get_active() {

			if ( ! empty( $this->active_uid_from_url ) ) {
				return $this->active_uid_from_url;
			} else {
				return $this->active_uid;
			}
		}

		/**
		 * Return active uid in string format.
		 *
		 * @return array
		 */
		public function get_active_uid_string() {
			return implode( ',', $this->get_active() );
		}

		/**
		 * Get hotspots uid.
		 *
		 * @return array
		 */
		public function get_hotspots() {
			return $this->hotspots;
		}

		/**
		 * Returns components layers as single dimentional format.
		 *
		 * @return array
		 */
		public function get_layers() {
			return apply_filters( 'wpc_config_data_layers', $this->layers, $this );
		}

		/**
		 * Returns layer component.
		 *
		 * @return array
		 */
		public function get_components() {
			$this->components = array_map( 'array_filter', WPC_Utils::array_filter_recursive( WPC_Utils::get_meta_value( $this->id, '_wpc_components', array() ) ) );

			return $this->components;
		}

		/**
		 * Returns layer images list.
		 *
		 * @return array
		 */
		public function get_images() {
			return $this->editor_images;
		}

		/**
		 * Returns configurator/product title.
		 *
		 * @return array
		 */
		public function get_title() {
			return ( $this->product_id ) ? get_the_title( $this->product_id ) : get_the_title( $this->id );
		}

		/**
		 * The layer has parent layer?
		 *
		 * @param string $uid Component layer uid.
		 * @return bool
		 */
		public function has_parent( $uid = '' ) {
			return isset( $this->layers[ $uid ]['parent'] ) ? true : false;
		}

		/**
		 * The layer has children?
		 *
		 * @param string $uid Component layer uid.
		 * @return bool
		 */
		public function has_children( $uid = '' ) {
			return isset( $this->layers[ $uid ]['children'] ) ? true : false;
		}

		/**
		 * Returns layer
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_layer( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) ? $this->layers[ $uid ] : false;
		}

		/**
		 * Returns layer name
		 *
		 * @param string $uid Component layer uid.
		 * @return string
		 */
		public function get_name( $uid = '' ) {
			if ( isset( $this->layers[ $uid ] ) ) {
				if( isset( $this->layers[ $uid ]['settings'] ) && 'label' === $this->control_type( $uid ) && isset( $this->layers[ $uid ]['settings']['label'] ) ) {		
					return $this->layers[ $uid ]['settings']['label'];
				} else if ( isset( $this->layers[ $uid ]['name'] ) ) {
					return $this->layers[ $uid ]['name'];
				} else {
					return false;
				}
			}
		}

		/**
		 * Returns layer description
		 *
		 * @param string $uid Component layer uid.
		 * @return string
		 */
		public function get_description( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['description'] ) ? $this->layers[ $uid ]['settings']['description'] : false;
		}

		/**
		 * Returns layer settings
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_layer_settings( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) ? $this->layers[ $uid ]['settings'] : false;
		}

		/**
		 * Returns layer price
		 *
		 * @param string $uid Component layer uid.
		 * @return float
		 */
		public function get_price( $uid = '' ) {
			$regular_price = isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['price'] ) ? (float) $this->layers[ $uid ]['settings']['price'] : false;

			$sale_price = isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['sale_price'] ) ? (float) $this->layers[ $uid ]['settings']['sale_price'] : false;

			return $sale_price ? (float) $sale_price : (float) $regular_price;
		}

		/**
		 * Returns layer allows required
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function control_type( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['control_type'] ) ? $this->layers[ $uid ]['settings']['control_type'] : false;
		}

		/**
		 * Returns layer icon
		 *
		 * @param string $uid Component layer uid.
		 * @return integer
		 */
		public function get_icon( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['icon'] ) ? (int) $this->layers[ $uid ]['settings']['icon'] : false;
		}

		/**
		 * Returns layer label
		 *
		 * @param string $uid Component layer uid.
		 * @return string
		 */
		public function get_label( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['label'] ) ? $this->layers[ $uid ]['settings']['label'] : false;
		}

		/**
		 * Returns layer color
		 *
		 * @param string $uid Component layer uid.
		 * @return string
		 */
		public function get_color( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['color'] ) ? $this->layers[ $uid ]['settings']['color'] : false;
		}

		/**
		 * Returns layer switch view
		 *
		 * @param string $uid Component layer uid.
		 * @return string
		 */
		public function get_switch_view( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['switch_view'] ) ? $this->layers[ $uid ]['settings']['switch_view'] : false;
		}


		/**
		 * Returns deselect siblings.
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_deselect_siblings( $uid ) {
			return isset( $this->layers[ $uid ]['deselect_siblings'] ) ? $this->layers[ $uid ]['deselect_siblings'] : false;
		}


		/**
		 * Check the layer is active.
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function is_active( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['active'] ) ? WPC_Utils::str_to_bool( $this->layers[ $uid ]['settings']['active'] ) : false;
		}

		/**
		 * Returns layer allows multiple
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function is_multiple( $uid = '' ) {

			$parent_uid = $this->get_parent_uid( $uid );

			return isset( $this->layers[ $parent_uid ] ) && isset( $this->layers[ $parent_uid ]['settings'] ) && isset( $this->layers[ $parent_uid ]['settings']['multiple'] ) ? WPC_Utils::str_to_bool( $this->layers[ $parent_uid ]['settings']['multiple'] ) : false;
		}

		/**
		 * Returns layer allows required
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function is_required( $uid = '' ) {

			$parent_uid = $this->get_parent_uid( $uid );

			return isset( $this->layers[ $parent_uid ] ) && isset( $this->layers[ $parent_uid ]['settings'] ) && isset( $this->layers[ $parent_uid ]['settings']['required'] ) ? WPC_Utils::str_to_bool( $this->layers[ $parent_uid ]['settings']['required'] ) : false;
		}

		/**
		 * Check the layer control is allow to show.
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function is_hide_control( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['hide_control'] ) ? WPC_Utils::str_to_bool( $this->layers[ $uid ]['settings']['hide_control'] ) : false;
		}

		/**
		 * Check it enabled the hotspot.
		 *
		 * @param string $uid Component layer uid.
		 * @param string $view View.
		 * @return bool
		 */
		public function is_hotspot( $uid = '', $view = '' ) {
			$hotspot = isset( $this->layers[ $uid ]['settings']['views'] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ]['hs_enable'] ) ? WPC_Utils::str_to_bool( $this->layers[ $uid ]['settings']['views'][ $view ]['hs_enable'] ) : false;

			return $hotspot;
		}

		/**
		 * Check the layer is allow deselect child.
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function is_deselect_child( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['deselect_child'] ) ? WPC_Utils::str_to_bool( $this->layers[ $uid ]['settings']['deselect_child'] ) : false;
		}

		/**
		 * Check the layer deselect type.
		 *
		 * @param string $uid Component layer uid.
		 * @return string
		 */
		public function get_deselect_type( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['settings'] ) && isset( $this->layers[ $uid ]['settings']['deselect_type'] ) ? $this->layers[ $uid ]['settings']['deselect_type'] : false;
		}

		/**
		 * Returns layer type
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_type( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['type'] ) ? $this->layers[ $uid ]['type'] : false;
		}

		/**
		 * Returns chilren layers uid.
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_children( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['children'] ) ? $this->layers[ $uid ]['children'] : false;
		}

		/**
		 * Returns parent Uid
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_parent_uid( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) ? $this->layers[ $uid ]['parent'] : false;
		}

		/**
		 * Returns layer tree
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_tree( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['tree'] ) ? $this->layers[ $uid ]['tree'] : false;
		}

		/**
		 * Returns layer tree
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_indexes( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['index'] ) ? $this->layers[ $uid ]['index'] : false;
		}

		/**
		 * Returns layer level
		 *
		 * @param string $uid Component layer uid.
		 * @return array
		 */
		public function get_level( $uid = '' ) {
			return isset( $this->layers[ $uid ] ) && isset( $this->layers[ $uid ]['level'] ) ? $this->layers[ $uid ]['level'] : false;
		}

		/**
		 * Returns layer view settings
		 *
		 * @param string $uid Component layer uid.
		 * @param string $view View.
		 * @return array
		 */
		public function get_view_settings( $uid = '', $view = '' ) {
			$view = isset( $this->layers[ $uid ]['settings']['views'] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ] ) ? $this->layers[ $uid ]['settings']['views'][ $view ] : false;

			return $view;
		}

		/**
		 * Returns layer view image ID.
		 *
		 * @param string $uid Component layer uid.
		 * @param string $view View.
		 * @return integer
		 */
		public function get_image( $uid = '', $view = '' ) {
			$image = isset( $this->layers[ $uid ]['settings']['views'] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ]['image'] ) ? (int) $this->layers[ $uid ]['settings']['views'][ $view ]['image'] : false;

			return $image;
		}

		/**
		 * Returns layer view image width.
		 *
		 * @param string $uid Component layer uid.
		 * @param string $view View.
		 * @return integer
		 */
		public function get_width( $uid = '', $view = '' ) {

			$image_id = isset( $this->layers[ $uid ]['settings']['views'] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ]['image'] ) ? $this->layers[ $uid ]['settings']['views'][ $view ]['image'] : 0;

			$width = ! empty( $image_id ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ]['width'] ) ? (int) $this->layers[ $uid ]['settings']['views'][ $view ]['width'] : ( isset( $this->editor_images[ $image_id ]['width'] ) ? $this->editor_images[ $image_id ]['width'] : 0 );

			return $width;
		}

		/**
		 * Returns layer view image height.
		 *
		 * @param string $uid Component layer uid.
		 * @param string $view View.
		 * @return integer
		 */
		public function get_height( $uid = '', $view = '' ) {

			$image_id = isset( $this->layers[ $uid ]['settings']['views'] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ] ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ]['image'] ) ? $this->layers[ $uid ]['settings']['views'][ $view ]['image'] : 0;

			$height = ! empty( $image_id ) && isset( $this->layers[ $uid ]['settings']['views'][ $view ]['height'] ) ? (int) $this->layers[ $uid ]['settings']['views'][ $view ]['height'] : ( isset( $this->editor_images[ $image_id ]['height'] ) ? $this->editor_images[ $image_id ]['height'] : 0 );

			return $height;
		}

		/**
		 * Update layer settings.
		 *
		 * @param array $args Layer settings.
		 * @return void
		 */
		public function update_components( $args = array() ) {

			if ( ! empty( $args ) && is_array( $args ) ) {
				foreach ( $args as $uid => $settings ) {
					$indexes = $this->get_indexes( $uid );

					if ( ! empty( $indexes ) && is_array( $indexes ) ) {
						foreach ( $indexes as $key => $index ) {
							if ( 0 === $key ) {
								$layer = $this->components[ $index ];
							} else {
								$layer = $layer['children'][ $index ];
							}

							if( ! isset( $layer['settings'] ) || null == $layer['settings'] ) {
								$layer['settings'] = array();
							}

							if ( ( count( $indexes ) - 1 ) === $key ) {
								$layer['settings'] = array_merge( $layer['settings'], $settings );
							}
						}
					}

					$replace[ $uid ] = $layer;
				}

				$components = $this->set_layer_settings( $this->components, $replace );

				update_post_meta( $this->id, '_wpc_components', $components );
			}
			
		}

		/**
		 * Modify layer setting.
		 *
		 * @param array $layers Layer component.
		 * @param array $replace Layer setting.
		 * @return array
		 */
		public function set_layer_settings( $layers = array(), $replace = array() ) {

			$components = array();

			if ( ! empty( $layers ) && is_array( $layers ) ) {
				foreach ( $layers as $key => $layer ) {

					$uid = $layer['uid'];

					$components[ $key ] = $layer;

					if ( array_key_exists( $uid, $replace ) ) {
						$components[ $key ] = $replace[ $uid ];
					}

					if ( isset( $layer['children'] ) ) {
						$components[ $key ]['children'] = $this->set_layer_settings( $layer['children'], $replace );
					}
				}
			}

			return $components;
		}

		/**
		 * Returns configurator total views.
		 *
		 * @return array
		 */
		public function get_base_price() {
			return apply_filters( 'wpc_base_price_in_data', $this->base_price, $this->id, $this->product_id );
		}

		/**
		 * Returns configurator total views.
		 *
		 * @return array
		 */
		public function get_views() {
			return $this->total_views;
		}

		/**
		 * Returns cart thumbnail view.
		 *
		 * @return array
		 */
		public function get_cart_thumbnail_view() {
			return $this->cart_thumbnail_view;
		}

		/**
		 * Returns image url.
		 *
		 * @param integer $image_id Image ID.
		 * @return string
		 */
		public function get_src( $image_id = 0 ) {
			$src = isset( $this->editor_images[ $image_id ] ) && isset( $this->editor_images[ $image_id ]['src'] ) ? $this->editor_images[ $image_id ]['src'] : false;

			return $src;
		}

		/**
		 * Returns refined inspiration posts.
		 *
		 * @return array
		 */
		public function get_inspiration_posts() {

			$posts = get_posts(
				array(
					'post_type'      => 'wpc_inspirations',
					'posts_per_page' => -1,
					'meta_query'     => array(
						array(
							'key'   => '_wpc_config_id',
							'value' => $this->id,
						),
					),
				)
			);

			$terms = array();

			if ( ! empty( $posts ) && is_array( $posts ) ) {
				foreach ( $posts as $key => $post ) {

					$id = $post->ID;

					$term_obj_list = get_the_terms( $post->ID, 'wpc_inspirations_cat' );

					$term_ids = ( $term_obj_list ) ? wp_list_pluck( $term_obj_list, 'term_id' ) : false;
					$term_id  = ( $term_ids ) ? $term_ids[0] : $this->default_inspiration_term_id();

					$term = get_term_by( 'term_id', $term_id, 'wpc_inspirations_cat' );

					$this->inspiration['posts'][ $term_id ][ $id ]['id']          = $id;
					$this->inspiration['posts'][ $term_id ][ $id ]['title']       = get_the_title( $id );
					$this->inspiration['posts'][ $term_id ][ $id ]['description'] = get_the_excerpt( $id );
					$this->inspiration['posts'][ $term_id ][ $id ]['image']       = WPC_Utils::get_image( get_post_thumbnail_id( $id ) );
					$this->inspiration['posts'][ $term_id ][ $id ]['key']         = WPC_Utils::get_meta_value( $id, '_wpc_inspiration_encoded_key', '' );
					$this->inspiration['posts'][ $term_id ][ $id ]['price']       = WPC_Utils::get_meta_value( $id, '_wpc_inspiration_price', '' );

					if ( $term ) {
						$terms[ $term_id ]['slug'] = $term->slug;
						$terms[ $term_id ]['name'] = $term->name;
					}
				}
			}	
			
			$this->inspiration = $this->inspiration + array( 'terms' => $terms );

			return $this->inspiration;

		}

		/**
		 * Returns default inspiration term ID.
		 *
		 * @return integer
		 */
		public function default_inspiration_term_id() {
			return (int) get_option( 'default_term_wpc_inspirations_cat' );
		}

	}
}

if ( ! function_exists( 'wpc_get_configurator' ) ) {

	/**
	 * Return configurator instance.
	 *
	 * @param integer $configurator Configurator ID.
	 * @return object
	 */
	function wpc_get_configurator( $configurator = 0 ) {

		if ( ! array_key_exists( $configurator, $GLOBALS ) ) {
			$GLOBALS[ $configurator ] = new WPC_Data( $configurator );
		}

		return $GLOBALS[ $configurator ];
	}
}

