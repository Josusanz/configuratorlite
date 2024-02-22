<?php
/**
 * Utilities.
 *
 * @package  wp-configurator-pro/includes/
 * @since  3.0
 * @version  3.5.3
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Utils' ) ) {

	/**
	 * Utilities.
	 */
	class WPC_Utils {

		/**
		 * It holds media layer/global settings fields.
		 *
		 * @var array
		 */
		public static $image_fields = array();

		/**
		 * It holds list of images.
		 *
		 * @var array
		 */
		public static $editor_images = array();

		/**
		 * It holds detailed active layer tree set layers values.
		 *
		 * @var array
		 */
		public static $active_tree_array = array();

		/**
		 * It holds each layer values.
		 *
		 * @var array
		 */
		public static $layer_array = array();

		/**
		 * Returns thumbnail src/image.
		 *
		 * @param integer        $image_id Image width.
		 * @param bool           $only_src Return only src.
		 * @param integer|string $width Image width.
		 * @param integer|string $height Image height.
		 * @param bool           $placeholder Show placeholder if nothing set.
		 * @return string
		 */
		public static function get_image( $image_id = 0, $only_src = true, $width = 'full', $height = 'full', $placeholder = false, $class = array() ) {

			$output          = '';
			$image_thumb_url = '';
			$img_url         = '';
			$alt             = '';

			$image_id = ( ! $image_id ) ? get_post_thumbnail_id() : $image_id;

			// Full image URL.
			$image_thumb_url = wp_get_attachment_image_src( $image_id, 'full' );

			$width  = is_int( $width ) ? $width : 'full';
			$height = is_int( $height ) ? $height : 'full';

			if ( ! empty( $image_thumb_url ) ) {

				$width  = ( 'full' != $width ) ? $width : $image_thumb_url[1];
				$height = ( 'full' != $height ) ? $height : $image_thumb_url[2];

				$img = wpc_aq_resize( $image_thumb_url[0], $width, $height, true, true );

				// if that image not met the mentioned width/height loads full size image url.
				$img_url = ( $img ) ? $img : $image_thumb_url[0];

				$alt = self::get_meta_value( $image_id, '_wp_attachment_image_alt', true );

			} elseif ( empty( $image_thumb_url ) && $placeholder ) {

				$width  = ( 'full' != $width ) ? $width : 1920;
				$height = ( 'full' != $height ) ? $height : 1080;

				$protocol = is_ssl() ? 'https' : 'http';

				$default_placeholder = '';

				$img_url = empty( $default_placeholder ) ? $protocol . '://placehold.it/' . $width . 'x' . $height : $default_placeholder;

				$alt = esc_attr__( 'Placeholder', 'wp-configurator-pro' );

			}

			if ( $only_src ) {
				$output = $img_url;
			} else {
				$output = '<img class="' . implode( ' ', $class ) . '" src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $alt ) . '">';
			}

			return $output;

		}

		public static function get_image_dimension( $image = 0 ) {

			$metadata = wp_get_attachment_metadata( $image );

			if ( $metadata && ! empty( $metadata ) && is_array( $metadata ) ) {
				return array(
					'width'  => $metadata['width'],
					'height' => $metadata['height'],
				);
			}
		}

		/**
		 * Returns meta value.
		 *
		 * @param integer $id Post ID.
		 * @param string  $meta_key Meta key.
		 * @param string  $meta_default Default value.
		 * @return string
		 */
		public static function get_meta_value( $id = '', $meta_key = '', $meta_default = '' ) {

			$value = get_post_meta( $id, $meta_key, true );
			$value = ( null !== $value && '' !== $value ) ? $value : $meta_default;

			return $value;
		}

		/**
		 * Returns option value.
		 *
		 * @param string $key Meta key.
		 * @param string $default Default value.
		 * @return string
		 */
		public static function get_option( $key = '', $default = '' ) {

			$value = get_option( $key, $default );
			$value = ( null !== $value && '' !== $value ) ? $value : $default;

			return $value;
		}

		/**
		 * Returns random string.
		 *
		 * @param integer $length Length.
		 * @return string
		 */
		public static function random( $length = 4 ) {
			$string = '';

			$characters        = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$characters_length = strlen( $characters );

			for ( $i = 0; $i < $length; $i++ ) {
				$string .= $characters[ rand( 0, $characters_length - 1 ) ];
			}

			return $string;
		}

		/**
		 * Returns random 8 character string.
		 *
		 * @param integer $length Length.
		 * @return string
		 */
		public static function generate_uid() {
			return self::random() . '-' . self::random();
		}

		/**
		 * Notation to numbers.
		 *
		 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
		 *
		 * @param string $size Size value.
		 * @return int
		 */
		public static function let_to_num( $size ) {
			$l   = substr( $size, -1 );
			$ret = (int) substr( $size, 0, -1 );
			switch ( strtoupper( $l ) ) {
				case 'P':
					$ret *= 1024;
					// No break.
				case 'T':
					$ret *= 1024;
					// No break.
				case 'G':
					$ret *= 1024;
					// No break.
				case 'M':
					$ret *= 1024;
					// No break.
				case 'K':
					$ret *= 1024;
					// No break.
			}
			return $ret;
		}

		/**
		 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
		 * Non-scalar values are ignored.
		 *
		 * @param string|array $var Data to sanitize.
		 * @return string|array
		 */
		public static function clean( $var ) {
			if ( is_array( $var ) ) {
				return array_map( array( 'WPC_Utils', 'clean' ), $var );
			} else {
				return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
			}
		}

		/**
		 * Cleanup string.
		 *
		 * @param string $string String.
		 * @return string
		 */
		public static function simplify_string( $string = '' ) {
			return strtolower( preg_replace( '/[\W_]+/u', '', $string ) );
		}

		/**
		 * Refine encoded image data.
		 *
		 * @param string|array $image_data Encoded image data.
		 * @return string
		 */
		public static function get_encoded_image_src( $image_data = '' ) {

			if ( is_array( $image_data ) ) {

				$image_data = count( $image_data ) > 1 ? $image_data : array_merge( array( 'data:image/png;base64' ), $image_data );

				$image_data = implode( ', ', $image_data );
			} else {
				if ( ! ( strpos( $image_data, 'data:image' ) !== false ) ) {
					$image_data = 'data:image/png;base64, ' . $image_data;
				}
			}

			return $image_data;
		}

		/**
		 * Sanitize hex/rgba/hsla color code.
		 *
		 * @param string $color Color value.
		 * @return string
		 */
		public static function sanitize_color( $color = '' ) {
			if ( preg_match( '/^rgba\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*(\d*(?:\.\d+)?)\)$/', $color, $match ) ||
			preg_match( '/^hsla\((\d+),\s*([\d.]+)%,\s*([\d.]+)%,\s*(\d*(?:\.\d+)?)\)$/', $color, $match )
			) {
				return $match[0];
			} else {
				return sanitize_hex_color( $color );
			}
		}

		/**
		 * If the data version is old, raise a notice.
		 *
		 * @return void
		 */
		public static function update_notice() {
			?>
			<p class="wpc-notice wpc-error wpc-update-notice"><?php esc_html_e( 'Update Required: Please update your Configurator database to the latest version.', 'wp-configurator-pro' ); ?></p>
			<?php
		}

		/**
		 * Returns list of google fonts.
		 *
		 * @return array
		 */
		public static function get_google_fonts() {

			$google_font_version = get_option( 'wpc_google_font_version', '1.0' );
			$fonts               = get_option( 'wpc_google_fonts', array() );

			if ( ! $google_font_version || version_compare( $google_font_version, WPC_GOOGLE_FONT_VERSION, '<' ) ) {
				$request  = wp_remote_get( esc_url_raw( WPC_ASSETS_URL . 'fonts.json' ) );
				$response = wp_remote_retrieve_body( $request );

				if ( 'OK' !== wp_remote_retrieve_response_message( $response ) || 200 !== wp_remote_retrieve_response_code( $response )
				) {
					$fonts_list = json_decode( $response );

					if ( ! empty( $fonts_list ) && is_array( $fonts_list ) ) {

						$fonts = array_combine( $fonts_list, $fonts_list );

						update_option( 'wpc_google_fonts', $fonts );
						update_option( 'wpc_google_font_version', WPC_GOOGLE_FONT_VERSION );
					}
				}
			}

			/**
			 * Filter: List of fonts.
			 *
			 * * @since 2.5
			 *
			 * @param array   $fonts Google fonts.
			 */
			$custom_fonts = apply_filters( 'wpc_fonts_lists', array() );

			update_option( 'wpc_custom_fonts', $custom_fonts );

			$fonts = $fonts + $custom_fonts;

			return $fonts;
		}

		/**
		 * Returns users objects.
		 *
		 * @param  string $role User role.
		 * @return object
		 */
		public static function get_users( $role = 'administrator' ) {

			$list = array();

			$args = array(
				'role' => $role,
			);

			$users = get_users( $args );

			if ( ! empty( $users ) && is_array( $users ) ) {
				foreach ( $users as $user ) {
					$user_info         = get_userdata( $user->ID );
					$list[ $user->ID ] = $user->user_email;
				}
			}

			return $list;
		}

		/**
		 * Returns active tree set detailed values.
		 *
		 * @param integer $config_id Configurator ID.
		 * @param array   $active_tree_set Active tree set.
		 * @return array
		 */
		public static function get_active_tree_detailed_array( $config_id = 0, $active_tree_set = array() ) {

			// Configurator data.
			$components = self::get_meta_value( $config_id, '_wpc_components', array() );

			self::$active_tree_array = array();
			self::$layer_array       = array();

			$layers = self::get_layer_data( $components );

			self::build_active_tree_set( $layers, $active_tree_set );

			$active_tree_array = self::$active_tree_array;

			self::$active_tree_array = array();

			return $active_tree_array;
		}

		/**
		 * Converts the multidimensional configurator layers array to single dimensional array.
		 *
		 * @param array $layers Each layer values.
		 * @param array $active_tree_set Active layer tree set.
		 * @return array
		 */
		public static function build_active_tree_set( $layers = array(), $active_tree_set = array() ) {

			$parent_ids = array();

			if ( ! empty( $active_tree_set ) && is_array( $active_tree_set ) ) {
				foreach ( $active_tree_set as $tree_key => $set ) {

					$active = array();
					$price  = 0;

					$active_uid = $set[ ( count( $set ) - 1 ) ];

					if ( apply_filters( 'wpc_skip_active_layer', false, $active_uid, $layers ) ) {
						continue;
					}

					if ( ! empty( $set ) && is_array( $set ) ) {
						foreach ( $set as $key => $uid ) {
							$first = ( 0 === $key );
							$last  = ( ( count( $set ) - 1 ) === $key );

							if ( $first ) {
								$top_layer_id = $uid;
							}

							if ( $first && ! in_array( $uid, $parent_ids ) ) {

								$parent_ids[] = $uid;

								self::$active_tree_array[ $top_layer_id ]           = array();
								self::$active_tree_array[ $top_layer_id ]['title']  = $layers[ $uid ]['name'];
								self::$active_tree_array[ $top_layer_id ]['active'] = array();
								self::$active_tree_array[ $top_layer_id ]['price']  = 0;

							}

							$regular_price = isset( $layers[ $uid ]['settings'] ) && isset( $layers[ $uid ]['settings']['price'] ) ? $layers[ $uid ]['settings']['price'] : 0;

							$sale_price = isset( $layers[ $uid ]['settings'] ) && isset( $layers[ $uid ]['settings']['sale_price'] ) ? $layers[ $uid ]['settings']['sale_price'] : 0;

							$price = $sale_price ? $sale_price : $regular_price;

							if ( ! $first ) {
								$active[ $key ]['uid']        = $uid;
								$active[ $key ]['type']       = $layers[ $uid ]['type'];
								$active[ $key ]['title']      = $layers[ $uid ]['name'];
								$active[ $key ]['price']      = $regular_price;
								$active[ $key ]['sale_price'] = $sale_price;

								$active[ $key ] = apply_filters( 'wpc_active_tree_set', $active[ $key ], $uid, $layers );
							}

							/* If the price is set get the layer price and add it to build group total price */
							if ( $last && isset( $layers[ $uid ]['settings'] ) && $regular_price ) {

								$price = floatval( $price ) + floatval( self::$active_tree_array[ $top_layer_id ]['price'] );

								self::$active_tree_array[ $top_layer_id ]['price'] = $price;
							}

							/* Add the active uid arrays to the corresponding top layer uid sets */
							if ( $last ) {
								self::$active_tree_array[ $top_layer_id ]['active'][] = $active;
							}
						}
					}
				}

				return self::$active_tree_array;
			}

		}

		/**
		 * Converts the multidimensional configurator layers array to single dimensional array.
		 *
		 * @param array   $layers Layers.
		 * @param integer $level Layer level.
		 * @param array   $parent_tree Layer tree upto parent layer.
		 * @param string  $parent Parent uid.
		 * @return void
		 */
		public static function build_layer_array( $layers = array(), $level = 0, $parent_tree = array(), $parent = '' ) {

			if ( ! isset( self::$layer_array ) ) {
				self::$layer_array = array();
			}

			$level++;

			if ( ! empty( $layers ) && is_array( $layers ) ) {
				foreach ( $layers as $key => $layer ) {
					if ( 1 === $level ) {
						$parent_tree = array( $layer['uid'] );
						$parent      = self::generate_uid();
					}

					$tree = array( $layer['uid'] );

					self::$layer_array[ $layer['uid'] ] = $layer;

					self::$layer_array[ $layer['uid'] ]['tree'] = array_values( array_unique( array_merge( $parent_tree, $tree ) ) );

					self::$layer_array[ $layer['uid'] ]['parent'] = $parent;

					self::$layer_array[ $layer['uid'] ]['level'] = $level;

					unset( self::$layer_array[ $layer['uid'] ]['actions'] );

					if ( isset( $layer['children'] ) ) {

						self::$layer_array[ $layer['uid'] ]['children'] = wp_list_pluck( $layer['children'], 'uid' );

						$parent = $layer['uid'];
						self::build_layer_array( $layer['children'], $level, array_merge( $parent_tree, $tree ), $parent );
					}

					self::$layer_array = apply_filters( 'wpc_config_data_manipulate_layers', self::$layer_array, self::$layer_array[ $layer['uid'] ], 'in_cart' );
				}
			}

		}

		/**
		 * Converts the multidimensional configurator layers array to single dimensional array.
		 *
		 * @param array $layers Each layers values.
		 * @return array
		 */
		public static function get_layer_data( $layers = array() ) {

			self::build_layer_array( $layers );

			return self::$layer_array;

		}

		/**
		 * Get layer actions( Eg: Image layer )
		 *
		 * @return array
		 */
		public static function get_layer_actions() {
			return apply_filters( 'wpc_layer_actions', array( 'is_selected', 'is_deactivated' ) );
		}

		/**
		 * Get group and sub group layer actions
		 *
		 * @return array
		 */
		public static function get_group_actions() {
			return apply_filters( 'wpc_group_actions', array( 'is_closed', 'is_deactivated' ) );
		}

		/**
		 * Get layer action pair.
		 *
		 * @param string $action Initial state.
		 * @return array
		 */
		public static function get_layer_action_pairs( $action = '' ) {

			$action_pairs = apply_filters(
				'wpc_layer_action_pairs',
				array(
					'deactivate' => array(
						0 => 'is_deactivated',
						1 => true,
					),
					'selected'   => array(
						0 => 'is_selected',
						1 => true,
					),
					'deselected' => array(
						0 => 'is_selected',
						1 => false,
					),
				)
			);

			return isset( $action_pairs[ $action ] ) ? $action_pairs[ $action ] : false;
		}

		/**
		 * It helps to convert the string to boolean.
		 *
		 * @param string $string String to convert.
		 * @return bool
		 */
		public static function str_to_bool( $string ) {
			switch ( strtolower( $string ) ) {
				case 'true':
				case 'yes':
				case '1':
				case 'show':
				case 'enable':
				case 'activate':
					return true;
				case 'false':
				case 'no':
				case '0':
				case 'hide':
				case 'disable':
				case 'deactivate':
				case '':
				case null:
					return false;
				default:
					return (bool) $string;
			}
		}

		/**
		 * Change the text case.
		 *
		 * @param string $string String.
		 * @param string $case Change the text case.
		 * @return bool
		 */
		public static function change_case( $string = '', $case = 'kebab' ) {
			switch ( $case ) {
				case 'kebab':
					return strtolower( trim( str_replace( array( ' ', '_' ), '-', $string ) ) );
				default:
					return $string;
			}
		}

		public static function get_rebuild_editor_images( $config_id = 0, $views = array(), $editor_images = array() ) {

			self::$image_fields = self::get_image_fields();

			$components = get_post_meta( $config_id, '_wpc_components', true );

			self::rebuild_layer_editor_images( $components, $views, $editor_images );

			$settings = get_post_meta( $config_id, '', true );

			self::rebuild_global_editor_images( $settings, $views, $editor_images );

			return self::$editor_images;
		}

		public static function rebuild_layer_editor_images( $layers = array(), $views = array(), $editor_images = array() ) {

			if ( ! empty( $layers ) && is_array( $layers ) ) {
				foreach ( $layers as $key => $layer ) {

					if ( ! empty( self::$image_fields ) && is_array( self::$image_fields ) ) {
						foreach ( self::$image_fields as $type => $groups ) {

							if ( ! empty( $groups ) && is_array( $groups ) ) {
								foreach ( $groups as $setting_type => $fields ) {

									if ( 'layer' !== $setting_type ) {
										continue;
									}

									if ( ! empty( $fields ) && is_array( $fields ) ) {
										foreach ( $fields as $field ) {

											if ( 'non_view_control' === $type ) {
												if ( isset( $layer['settings'] ) && isset( $layer['settings'][ $field ] ) && ! empty( $layer['settings'][ $field ] ) ) {
													$image_id = $layer['settings'][ $field ];

													if ( $image_id ) {
														self::set_editor_image( $layer, $field, $editor_images, $image_id );
													}
												}
											} elseif ( 'view_control' === $type ) {
												if ( ! empty( $views ) && is_array( $views ) ) {
													foreach ( $views as $view_key => $view ) {

														if ( isset( $layer['settings'] ) && isset( $layer['settings']['views'] ) && isset( $layer['settings']['views'][ $view_key ] ) && isset( $layer['settings']['views'][ $view_key ][ $field ] ) && ! empty( $layer['settings']['views'][ $view_key ][ $field ] ) ) {

															$image_id = $layer['settings']['views'][ $view_key ][ $field ];

															if ( $image_id ) {
																self::set_editor_image( $layer, $field, $editor_images, $image_id, $view_key );
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
					if ( isset( $layer['children'] ) ) {
						self::rebuild_layer_editor_images( $layer['children'], $views, $editor_images );
					}
				}
			}
		}

		public static function rebuild_global_editor_images( $settings = array(), $views = array(), $editor_images = array() ) {

			if ( ! empty( self::$image_fields ) && is_array( self::$image_fields ) ) {
				foreach ( self::$image_fields as $type => $value ) {

					if ( ! empty( $value ) && is_array( $value ) ) {
						foreach ( $value as $setting_type => $fields ) {

							if ( ! empty( $fields ) && is_array( $fields ) ) {
								foreach ( $fields as $field ) {

									if ( 'global' === $setting_type ) {
										if ( 'non_view_control' === $type ) {

											// Image single control image( Eg: Control icon ).
											if ( isset( $settings[ $field ] ) && isset( $settings[ $field ][0] ) && ! empty( $settings[ $field ][0] ) ) {
												$image_id = unserialize( $settings[ $field ][0] );

												if ( $image_id ) {
													self::set_editor_image( $settings, $field, $editor_images, $image_id );
												}
											}
										} elseif ( 'view_control' === $type ) {

											if ( ! empty( $views ) && is_array( $views ) ) {
												// Import view control images.
												foreach ( $views as $view_key => $view ) {

													$unserialize = unserialize( $settings[ $field ][0] );

													// Image single control image( Eg: Control icon ).
													if ( $unserialize && isset( $unserialize[ $view_key ] ) && ! empty( $unserialize[ $view_key ] ) ) {
														$image_id = $unserialize[ $view_key ];

														if ( $image_id ) {
															self::set_editor_image( $settings, $field, $editor_images, $image_id );
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		/**
		 * Build the editor images array for meta.
		 *
		 * @param array  $layer Layer.
		 * @param array  $key Settings ID.
		 * @param array  $editor_images Old editor images.
		 * @param string $image_id Uploaded new image ID.
		 * @return void
		 */
		public static function set_editor_image( $layer = array(), $key = '', $editor_images = array(), $image_id = '', $view = '' ) {

			if ( isset( $layer['uid'] ) ) {
				self::$editor_images[ $image_id ]['uid'] = $layer['uid'];
			}

			if ( $key ) {
				self::$editor_images[ $image_id ]['key'] = $key;
			}

			$image_data = wp_get_attachment_image_src( $image_id, 'full' );

			if ( $image_data && is_array( $image_data ) ) {
				$src    = isset( $image_data[0] ) ? $image_data[0] : '';
				$width  = isset( $image_data[1] ) ? $image_data[1] : '';
				$height = isset( $image_data[2] ) ? $image_data[2] : '';

				if ( $view ) {
					$width = isset( $layer['settings']['views'][ $view ] ) && isset( $layer['settings']['views'][ $view ][ 'width' ] ) ? $layer['settings']['views'][ $view ][ 'width' ] : $width;
					$height = isset( $layer['settings']['views'][ $view ] ) && isset( $layer['settings']['views'][ $view ][ 'height' ] ) ? $layer['settings']['views'][ $view ][ 'height' ] : $height;
				}

				if ( $src ) {
					self::$editor_images[ $image_id ]['src']    = $src;
					self::$editor_images[ $image_id ]['width']  = $width;
					self::$editor_images[ $image_id ]['height'] = $height;
				}
			}
		}

		public static function get_registered_layer_types() {

			do_action( 'wpc/editor/register_controls' );

			return array_keys( WPC()->editor_controls->get_layer_types() );
		}

		/**
		 * Returns the summary content for get a quote mail and config mail post.
		 *
		 * @param array $args Summary arguements.
		 * @return string
		 */
		public static function build_summary( $args = array() ) {

			$active_tree_array = self::get_active_tree_detailed_array( $args['config_id'], $args['active_tree_set'] );

			$base_price = self::get_meta_value( $args['config_id'], '_wpc_base_price', '0' );

			$price_details = get_option( 'wpc_price_details', 'true' );
			$group_price   = get_option( 'wpc_group_price', 'true' );
			$total_price   = get_option( 'wpc_total_price', 'true' );

			/**
			 * Filter: Email and Config mail post summary arguements.
			 *
			 * * @since 2.6
			 * * @version 2.6.2
			 *
			 * @param array   $args Form details.
			 */
			$args = apply_filters(
				'wpc_mail_summary_args',
				array(
					'config_id'         => $args['config_id'],
					'active_tree_array' => $active_tree_array,
					'base_price'        => apply_filters( 'wpc_base_price_in_summary', floatval( $base_price ), $args['config_id'], $args['product_id'] ),
					'price_details'     => $price_details,
					'show_group_price'  => $group_price,
					'show_total_price'  => $total_price,
					'values'            => $args,
				)
			);

			/**
			 * Filter: Mail summary template path.
			 *
			 * * @since 3.4.9
			 *
			 * @param array   $args Mail summary arguements.
			 */
			$body = self::get_template_html( 'summary.php', $args, apply_filters( 'wpc_email_summary_template_path', '', $args ) );

			return $body;

		}

		/**
		 * Return the attachment data depends on post name
		 *
		 * @param string $post_name Post name.
		 * @return object
		 */
		public static function get_attachment_by_post_name( $post_name ) {
			$args = array(
				'posts_per_page' => 1,
				'post_type'      => 'attachment',
				'name'           => trim( $post_name ),
			);

			$get_attachment = new WP_Query( $args );

			if ( ! $get_attachment || ! isset( $get_attachment->posts, $get_attachment->posts[0] ) ) {
				return false;
			}

			return $get_attachment->posts[0];
		}

		/**
		 * Create attachment based on encoded data
		 *
		 * @param string|array $data Encoded data.
		 * @param array        $detail File details.
		 * @return array|bool
		 */
		public static function save_encoded_data_as_attachment( $data = '', $detail = array() ) {

			if ( empty( $data ) ) {
				return false;
			}

			if ( is_array( $data ) ) {
				$data = implode( ', ', $data );
			} elseif ( ! ( strpos( $data, 'data:audio' ) !== false ) && ! ( strpos( $data, 'data:image' ) !== false ) ) {
				$data = 'data:' . esc_html( $detail['type'] ) . ';base64, ' . $data;
			}

			$filtered_data = substr( $data, strpos( $data, ',' ) + 1 );
			$decoded_data  = base64_decode( $filtered_data );

			self::create_dir();

			$upload_dir = self::upload_dir_path();

			$file_name = isset( $detail['name'] ) ? $detail['name'] : self::random( 8 );
			$file_path = $upload_dir . $file_name . '.' . $detail['ext'];

			// Create a random file.
			$file = fopen( $file_path, 'w' );

			// Insert the image data in to the random file.
			$image_src = file_put_contents( $file_path, $decoded_data );

			// Create attachment and upload into the `wp_upload_dir`.
			$filetype = wp_check_filetype( basename( $file_path ), null );

			$attachment = array(
				'guid'           => self::upload_dir_url() . basename( $file_path ),
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_path ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
				'meta_input'     => array(
					'config_attachment' => true
				)
			);

			$attach_id = wp_insert_attachment( $attachment, $file_path );

			// Include image.php.
			require_once ABSPATH . 'wp-admin/includes/image.php';

			// Define attachment metadata.
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

			// Assign metadata to attachment.
			wp_update_attachment_metadata( $attach_id, $attach_data );

			return array(
				'id'   => $attach_id,
				'path' => $file_path,
			);

		}

		/**
		 * Create a directory
		 *
		 * @param string $path Directory path
		 * @param string $rules .htaccess file content
		 * @return void
		 */
		public static function create_dir( $path = '', $rules = '' ) {

			$path = ( $path ) ? $path : self::upload_dir_path();

			$allowed_filetypes = apply_filters( 'wpc_protected_directory_allowed_filetypes', array( 'jpg', 'jpeg', 'png', 'gif', 'mp3', 'ogg', 'webp', 'svg' ) );

			if ( ! $rules ) {
				$rules = "Options -Indexes\n";
				$rules .= "deny from all\n";
				$rules .= "<FilesMatch '\.(" . implode( '|', $allowed_filetypes ) . ")$'>\n";
					$rules .= "Order Allow,Deny\n";
					$rules .= "Allow from all\n";
				$rules .= "</FilesMatch>\n";
			}			

			$file = array(
				'base' => $path,
				'file' => '.htaccess',
				'content' => $rules
			);

			$file = apply_filters( 'wpc_default_create_directory', $file );

			if ( wp_mkdir_p( $file['base'] ) && ! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) ) {
				$file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'wb' ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
				if ( $file_handle ) {
					fwrite( $file_handle, $file['content'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
					fclose( $file_handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
				}
			}
		}

		/**
		 * Returns the configurator uploads directory path
		 *
		 * @return string
		 */
		public static function upload_dir_path() {
			$upload_dir = wp_upload_dir();

			return $upload_dir['basedir'] . '/configurator_uploads/';
		}

		/**
		 * Returns the configurator uploads directory url
		 *
		 * @return string
		 */
		public static function upload_dir_url() {
			$upload_dir = wp_upload_dir();

			return $upload_dir['url'] . '/configurator_uploads/';
		}

		/**
		 * Returns the current url.
		 *
		 * @return string
		 */
		public static function current_url() {
			global $wp;

			$current_url = home_url( add_query_arg( array( $_GET ), $wp->request ) );

			return $current_url;
		}

		/**
		 * Returns is this the full window style?
		 *
		 * @param string $style Configurator style.
		 * @return boolean
		 */
		public static function is_full_window_style( $style = '' ) {
			if ( ! is_singular( 'amz_configurator' ) && ! is_singular( 'product' ) ) {
				return;
			}

			$config_id = false;

			if ( is_singular( 'amz_configurator' ) ) {
				$config_id = get_the_ID();
			} else {
				$product_id = get_the_ID();
				$config_id  = self::get_meta_value( $product_id, '_wpc_config_id', 0 );
			}

			$style                = ! empty( $style ) ? $style : self::get_meta_value( $config_id, '_wpc_config_style', 0 );
			$load_configurator_in = self::get_meta_value( $config_id, '_wpc_load_configurator_in', 'direct' );

			if ( ( 'direct' === $load_configurator_in || isset( $_GET['configure'] ) ) && in_array( $style, apply_filters( 'wpc_full_window_style', array() ), true ) ) {
				return true;
			}
		}

		/**
		 * Return the configurator style applied in the global settings.
		 *
		 * @return string
		 */
		public static function get_style() {
			if ( ! is_singular( 'amz_configurator' ) && ! is_singular( 'product' ) ) {
				return;
			}

			$config_id = false;

			if ( is_singular( 'amz_configurator' ) ) {
				$config_id = get_the_ID();
			} else {
				$product_id = get_the_ID();
				$config_id  = self::get_meta_value( $product_id, '_wpc_config_id', 0 );
			}

			$style                = self::get_meta_value( $config_id, '_wpc_config_style', 0 );
			$load_configurator_in = self::get_meta_value( $config_id, '_wpc_load_configurator_in', 'direct' );

			if ( ( 'direct' === $load_configurator_in || isset( $_GET['configure'] ) ) && in_array( $style, apply_filters( 'wpc_full_window_style', array() ), true ) ) {
				return apply_filters( 'wpc_get_style', $style );
			} else {
				return '';
			}
		}

		/**
		 * Returns the user role.
		 *
		 * @param array $user_id User ID.
		 * @return string
		 */
		public static function user_role( $user_id = '' ) {

			$user_id = ( isset( $user_id ) && ! empty( $user_id ) ) ? $user_id : get_current_user_id();

			$user_info = get_userdata( $user_id );
			$role      = ( $user_info && $user_info->roles ) ? $user_info->roles[0] : '';

			return $role;
		}

		/**
		 * Print scripts.
		 *
		 * @param array $handle Script handle.
		 * @param array $object_name Object key.
		 * @param array $l10n Data.
		 * @return void
		 */
		public static function localize_script( $handle, $object_name, $l10n ) {
			
			foreach ( (array) $l10n as $key => $value ) {
				if ( ! is_scalar( $value ) ) {
					continue;
				}

				$l10n[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );
			}

			$script  = '<script id="' . esc_attr( $handle ) . '-js-extra">';
			$script .= "var $object_name = " . wp_json_encode( $l10n ) . ';';
			$script .= '</script>';

			echo $script; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Locate a template and return the path for inclusion.
		 *
		 * @param string $template_name Template name.
		 * @param string $template_path Template path.
		 * @param string $default_path Default path.
		 * @return string
		 */
		public static function locate_template( $template_name, $template_path = '', $default_path = '' ) {
			
			$theme_template_path = WPC()->template_path();			

			if ( ! $default_path ) {
				$default_path = apply_filters( 'wpc_template_default_path', WPC()->plugin_path() . '/templates/' );
			}

			// Look within passed path within the theme - this is priority.
			$template = locate_template(
				array(
					trailingslashit( $theme_template_path ) . $template_name,
					$template_name,
				)
			);

			// look in other path
			if ( $template_path && ! $template ) {				
				$template = trailingslashit( $template_path ) . $template_name;
			}

			// Get default template.
			if ( ! $template ) {
				$template = $default_path . $template_name;
			}

			// Return what we found.
			return apply_filters( 'wpc_locate_template', $template, $template_name, $theme_template_path, $template_path );
		}

		/**
		 * Get other templates passing attributes and including the file.
		 *
		 * @param string $template_name Template name.
		 * @param array  $args          Arguments.
		 * @param string $template_path Template path.
		 * @param string $default_path  Default path.
		 * @return void
		 */
		public static function get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

			$template = self::locate_template( $template_name, $template_path, $default_path );

			extract( $args ); // @codingStandardsIgnoreLine

			include $template;
		}

		/**
		 * Like get_template, but returns the HTML instead of outputting.
		 *
		 * @param string $template_name Template name.
		 * @param array  $args          Arguments..
		 * @param string $template_path Template path.
		 * @param string $default_path  Default path.
		 * @return string
		 */
		public static function get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
			ob_start();
			self::get_template( $template_name, $args, $template_path, $default_path );
			return ob_get_clean();
		}

		/**
		 * Get template part (for templates).
		 *
		 * @param mixed  $slug Template slug.
		 * @param string $name Template name.
		 */
		public static function get_template_part( $slug, $name = '' ) {

			$template = '';

			// Look in yourtheme/slug-name.php and yourtheme/configurator/slug-name.php.
			if ( $name ) {
				$template = locate_template( array( "{$slug}-{$name}.php", WPC()->template_path() . "{$slug}-{$name}.php" ) );
			}

			// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/configurator/slug.php.
			if ( ! $template ) {
				$template = locate_template( array( "{$slug}.php", WPC()->template_path() . "{$slug}.php" ) );
			}

			// Get default slug-name.php.
			if ( ! $template && $name && file_exists( WPC()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
				$template = WPC()->plugin_path() . "/templates/{$slug}-{$name}.php";
			}

			if ( ! $template && file_exists( WPC()->plugin_path() . "/templates/{$slug}.php" ) ) {
				$template = WPC()->plugin_path() . "/templates/{$slug}.php";
			}

			// Allow 3rd party plugins to filter template file from their plugin.
			$template = apply_filters( 'wpc_get_template_part', $template, $slug, $name );

			if ( $template ) {
				load_template( $template, false );
			}

		}

		/**
		 * Scan the template files.
		 *
		 * @param  string $template_path Path to the template directory.
		 * @return array
		 */
		public static function scan_template_files( $template_path ) {
			$files  = @scandir( $template_path ); // @codingStandardsIgnoreLine.
			$result = array();

			if ( ! empty( $files ) && is_array( $files ) ) {

				foreach ( $files as $key => $value ) {

					if ( ! in_array( $value, array( '.', '..' ), true ) ) {

						if ( is_dir( $template_path . DIRECTORY_SEPARATOR . $value ) ) {
							$sub_files = self::scan_template_files( $template_path . DIRECTORY_SEPARATOR . $value );
							if ( ! empty( $sub_files ) && is_array( $sub_files ) ) {
								foreach ( $sub_files as $sub_file ) {
									$result[] = $value . DIRECTORY_SEPARATOR . $sub_file;
								}
							}
						} else {
							$result[] = $value;
						}
					}
				}
			}
			return $result;
		}

		/**
		 * Retrieve metadata from a file. Based on WP Core's get_file_data function.
		 *
		 * @param  string $file Path to the file.
		 * @return string
		 */
		public static function get_file_version( $file ) {

			// Avoid notices if file does not exist.
			if ( ! file_exists( $file ) ) {
				return '';
			}

			// We don't need to write to the file, so just open for reading.
			$fp = fopen( $file, 'r' ); // @codingStandardsIgnoreLine.

			// Pull only the first 8kiB of the file in.
			$file_data = fread( $fp, 8192 ); // @codingStandardsIgnoreLine.

			// PHP will close file handle, but we are good citizens.
			fclose( $fp ); // @codingStandardsIgnoreLine.

			// Make sure we catch CR-only line endings.
			$file_data = str_replace( "\r", "\n", $file_data );
			$version   = '';

			if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( '@version', '/' ) . '(.*)$/mi', $file_data, $match ) && $match[1] ) {
				$version = _cleanup_header_comment( $match[1] );
			}

			return $version;
		}

		/**
		 * Returns the summary content for get a quote mail and config mail post.
		 *
		 * @param array $args Summary arguements.
		 * @return string
		 */
		public static function field( $args = array() ) {

			$id               = isset( $args['id'] ) ? $args['id'] : '';
			$type             = isset( $args['type'] ) ? $args['type'] : 'text';
			$default          = isset( $args['default'] ) ? $args['default'] : '';
			$disabled         = isset( $args['disabled'] ) ? $args['disabled'] : false;
			$disabled_options = isset( $args['disabled_options'] ) ? $args['disabled_options'] : array();
			$label            = isset( $args['label'] ) ? $args['label'] : '';
			$placeholder      = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
			$multiple         = isset( $args['multiple'] ) ? $args['multiple'] : false;
			$desc             = isset( $args['desc'] ) ? $args['desc'] : '';
			$options          = isset( $args['options'] ) ? $args['options'] : array();
			$error            = isset( $args['error'] ) ? $args['error'] : false;
			$class            = isset( $args['class'] ) ? $args['class'] : '';
			$tag              = isset( $args['tag'] ) ? $args['tag'] : 'div';
			$attr             = isset( $args['attr'] ) ? $args['attr'] : array();
			$show             = isset( $args['show'] ) ? $args['show'] : '';

			$attr_html = array();

			if ( ! empty( $attr ) && is_array( $attr ) ) {
				foreach ( $attr as $key => $value ) {
					$attr_html[] = $key . '=' . $value;
				}
			}

			if ( ! $id || ! $type ) {
				return;
			}

			if ( ! empty( $show ) ) {
				echo '<template x-if="' . $show . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			if ( 'hidden' !== $type && 'wrap_start' !== $type && 'wrap_end' !== $type ) {
				echo '<div class="wpc-field-group wpc-' . esc_attr( $type ) . '">';
			}

			if ( 'hidden' !== $type && 'button' !== $type && 'checkbox' !== $type && 'cancel' !== $type && $label ) {
				echo '<label class="wpc-field-label">' . esc_html( $label ) . '</label>';
			}

			switch ( $type ) {
				case 'select':
					if ( $options ) {
						echo '<select class="wpc-field-select ' . esc_attr( $class ) . '" ' . ( ( $disabled ) ? 'disabled' : '' ) . ' name="' . esc_attr( $id ) . '" ' . esc_html( implode( ' ', $attr_html ) ) . '>';
						if ( ! empty( $options ) && is_array( $options ) ) {
							foreach ( $options as $key => $value ) {
								echo '<option value="' . esc_attr( $key ) . '" ' . ( in_array( $key, $disabled_options, true ) ? 'disabled' : '' ) . '>' . esc_html( $value ) . '</option>';
							}
						}
						echo '</select>';
					}
					break;
				case 'text':
					echo '<input class="wpc-field-text ' . esc_attr( $class ) . '" name="' . esc_attr( $id ) . '" type="text" value="' . esc_attr( $default ) . '" placeholder="' . esc_attr( $placeholder ) . '" ' . esc_html( implode( ' ', $attr_html ) ) . '>';
					break;
				case 'textarea':
					echo '<textarea class="wpc-field-textarea ' . esc_attr( $class ) . '" name="' . esc_attr( $id ) . '" placeholder="' . esc_attr( $placeholder ) . '" ' . esc_html( implode( ' ', $attr_html ) ) . '>' . esc_html( $default ) . '</textarea>';
					break;
				case 'checkbox':
					if ( $multiple ) {
						if ( ! empty( $options ) && is_array( $options ) ) {
							foreach ( $options as $key => $value ) {
								echo '<input class="wpc-field-text ' . esc_attr( $class ) . '" name="' . esc_attr( $id ) . '[]" value="' . esc_attr( $key ) . '" type="checkbox"' . esc_html( implode( ' ', $attr_html ) ) . '>';
								echo '<label class="wpc-field-label">' . esc_html( $value ) . '</label>';
							}
						}
					} else {
						echo '<input class="wpc-field-text ' . esc_attr( $class ) . '" name="' . esc_attr( $id ) . '" value="true" type="checkbox"' . esc_html( implode( ' ', $attr_html ) ) . '>';
						echo '<label class="wpc-field-label">' . esc_html( $label ) . '</label>';
					}
					break;
				case 'hidden':
					echo '<input class="' . esc_attr( $class ) . '" name="' . esc_attr( $id ) . '" type="hidden" value="' . esc_attr( $default ) . '" ' . esc_html( implode( ' ', $attr_html ) ) . '>';
					break;
				case 'button':
					echo '<button class="wpc-field-nutton ' . esc_attr( $class ) . '" type="submit" name="' . esc_attr( $id ) . '" ' . esc_html( implode( ' ', $attr_html ) ) . '>' . esc_html( $label ) . '</button>';
					break;
				case 'cancel':
					echo '<a ' . esc_html( implode( ' ', $attr_html ) ) . '>' . esc_html( $label ) . '</a>';
					break;
				case 'wrap_start':
					echo '<' . esc_html( $tag ) . ' ' . implode( '', $attr_html ) . '>';
					break;
				case 'wrap_end':
					echo '</' . esc_html( $tag ) . '>';
					break;
				default:
					break;
			}

			if ( 'hidden' !== $type && 'button' !== $type ) {
				if ( $desc ) {
					echo '<span class="wpc-field-desc">' . esc_html( $desc ) . '</span>';
				}

				if ( $error ) {

					$error_id = isset( $error['id'] ) ? $error['id'] : $id;
					$store    = isset( $error['store'] ) ? $error['store'] : false;

					$error_attr['class'] = 'class="error ' . esc_attr( $error_id ) . '-error"';

					if ( $store ) {
						$error_attr['alpine:text'] = 'x-text="' . $store . '.getNotice(\'' . $error_id . '\')"';
					}

					echo '<span ' . implode( ' ', $error_attr ) . '></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}

			if ( 'hidden' !== $type && 'wrap_start' !== $type && 'wrap_end' !== $type ) {
				echo '</div>'; // .wpc-field-group
			}

			if ( ! empty( $show ) ) {
				echo '</template>';
			}
		}

		/**
		 * Returns configurator style.
		 *
		 * @return array
		 */
		public static function get_default_styles() {
			return array(
				'style1'      => esc_html__( 'Style 1(Pro)', 'wp-configurator-pro' ),
				'style2'      => esc_html__( 'Style 2(Pro)', 'wp-configurator-pro' ),
				'style3'      => esc_html__( 'Style 3(Pro)', 'wp-configurator-pro' ),
				'accordion'   => esc_html__( 'Accordion Style 1', 'wp-configurator-pro' ),
				'accordion-2' => esc_html__( 'Accordion Style 2(Pro)', 'wp-configurator-pro' ),
				'popover'     => esc_html__( 'Popover(Pro)', 'wp-configurator-pro' ),
			);
		}

		/**
		 * Returns configurator style.
		 *
		 * @return array
		 */
		public static function get_styles() {

			$style = self::get_default_styles();

			/**
			 * Filter: List of available styles.
			 *
			 * * @since 2.0
			 *
			 * @param array   $style Configurator style.
			 */
			return apply_filters( 'wpc_config_styles', $style );

		}

		/**
		 * Returns list of configurators.
		 *
		 * @return array
		 */
		public static function get_configurators() {

			$configurators_ids = array( 0 => esc_html__( 'Choose Configurator', 'wp-configurator-pro' ) );

			$args = array(
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'post_type'           => 'amz_configurator',
				'order'               => 'DESC',
				'orderby'             => 'date',
				'posts_per_page'      => -1,
			);

			$args = apply_filters( 'wpc_configurator_posts_options_args', $args );

			$configurators = get_posts( $args );

			if ( ! empty( $configurators ) ) {
				$configurators_ids = $configurators_ids + wp_list_pluck( $configurators, 'post_title', 'ID' );
			}

			wp_reset_postdata();

			/**
			 * Filter: List of available configurators.
			 *
			 * * @version 3.0
			 *
			 * @param array   $configurators_ids Available configurators.
			 */
			$configurators_ids = apply_filters( 'wpc_configurators_lists', $configurators_ids );

			return $configurators_ids;
		}

		/**
		 * Returns list of products.
		 *
		 * @return array
		 */
		public static function get_products() {

			if ( ! WPC_WOO_ACTIVE ) {
				return array();
			}

			global $wpdb;

			$products = $wpdb->get_results(
				"SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'product' AND post_status = 'publish'",
				ARRAY_A
			);

			$product_ids = array( '0' => esc_html__( 'Select Product', 'wp-configurator-pro' ) ) + wp_list_pluck( $products, 'post_title', 'ID' );

			/**
			 * Filter: List of available form styles.
			 *
			 * * @since 2.5.2
			 *
			 * @param array   $product_ids Available products.
			 */
			$product_ids = apply_filters( 'wpc_products_lists', $product_ids );

			return $product_ids;
		}

		/**
		 * Returns list of pages.
		 *
		 * @return array
		 */
		public static function get_pages() {

			$pages = get_pages();

			$page_ids = array( '0' => esc_html__( 'Select Page', 'wp-configurator-pro' ) ) + wp_list_pluck( $pages, 'post_title', 'ID' );

			/**
			 * Filter: List of available form styles.
			 *
			 * * @since 2.5.2
			 *
			 * @param array   $product_ids Available products.
			 */
			$page_ids = apply_filters( 'wpc_pages_lists', $page_ids );

			return $page_ids;
		}

		/**
		 * Returns list of available form styles.
		 *
		 * @return array
		 */
		public static function get_forms() {

			$forms = array(
				'quote-form' => esc_html__( 'Get a Quote Form', 'wp-configurator-pro' ),
			);

			$forms = ( WPC_WOO_ACTIVE ) ? array_merge( $forms, array( 'cart-form' => esc_html__( 'Cart Form(Pro)', 'wp-configurator-pro' ) ) ) : $forms;
			$forms = ( WPC_CF7_ACTIVE ) ? array_merge( $forms, array( 'contact-form' => esc_html__( 'Contact Form(Pro)', 'wp-configurator-pro' ) ) ) : $forms;

			/**
			 * Filter: List of available form styles.
			 *
			 * * @since 2.5.2
			 *
			 * @param array   $forms Available form styles.
			 */
			$forms = apply_filters( 'wpc_form_styles', $forms );

			return $forms;
		}

		/**
		 * Returns list of contact forms.
		 *
		 * @return array
		 */
		public static function get_contact_forms() {

			$contact_form_args = array(
				'post_type'      => 'wpcf7_contact_form',
				'posts_per_page' => -1,
			);

			$contact_form_ids = array( '0' => esc_html__( 'Select a Form', 'wp-configurator-pro' ) );

			$contact_forms = get_posts( $contact_form_args );

			if ( $contact_forms ) {
				$contact_form_ids = $contact_form_ids + wp_list_pluck( $contact_forms, 'post_title', 'ID' );
			}

			return $contact_form_ids;
		}

		/**
		 * Returns email status lists.
		 *
		 * @return array
		 */
		public static function get_email_status_lists() {
			return apply_filters(
				'wpc_email_status_lists',
				array(
					'pending'    => esc_html__( 'Pending payment', 'wp-configurator-pro' ),
					'processing' => esc_html__( 'Processing', 'wp-configurator-pro' ),
					'on_hold'    => esc_html__( 'On hold', 'wp-configurator-pro' ),
					'completed'  => esc_html__( 'Completed', 'wp-configurator-pro' ),
					'cancelled'  => esc_html__( 'Cancelled', 'wp-configurator-pro' ),
					'refunded'   => esc_html__( 'Refunded', 'wp-configurator-pro' ),
				)
			);
		}

		/**
		 * Is the configurator requires database update?.
		 *
		 * @param array $id Configurator ID.
		 * @return bool
		 */
		public static function is_database_upto_current_version( $id ) {
			if ( ! self::required_meta_update( $id ) && ! self::required_option_update() ) {
				return true;
			} elseif ( apply_filters( 'wpc_not_required_database_update', false ) ) {
				return true;
			}
		}

		/**
		 * Is the post needs database update?.
		 *
		 * @param array $id Configurator ID.
		 * @return bool
		 */
		public static function required_meta_update( $id ) {
			$data_version = self::get_meta_value( $id, '_wpc_data_version', false );

			if ( ! $data_version || version_compare( WPC_DATABASE_VERSION, $data_version, '>' ) ) {
				return true;
			}
			return false;
		}

		/**
		 * Is database update required?.
		 *
		 * @return bool
		 */
		public static function required_option_update() {
			$data_version = get_option( 'wpc_data_version', false );

			if ( ! $data_version || version_compare( WPC_DATABASE_VERSION, $data_version, '>' ) || apply_filters( 'wpc_required_database_update', false ) ) {
				return true;
			}
			return false;
		}

		/**
		 * Cleanup array values.
		 *
		 * @param array  $array Array value to clean.
		 * @param string $callback Function callback.
		 * @return array
		 */
		public static function array_filter_recursive( $array, $callback = null ) {

			if ( ! empty( $array ) && is_array( $array ) ) {
				foreach ( $array as $key => & $value ) {
					if ( is_array( $value ) ) {
						$value = self::array_filter_recursive( $value, $callback );
					} else {
						if ( ! is_null( $callback ) ) {
							if ( ! $callback( $value ) ) {
								unset( $array[ $key ] );
							}
						} else {
							if ( ! (bool) $value ) {
								unset( $array[ $key ] );
							}
						}
					}
				}

				unset( $value );

				return $array;
			}
		}

		/**
		 * Get full list of currency codes.
		 *
		 * Currency symbols and names should follow the Unicode CLDR recommendation (http://cldr.unicode.org/translation/currency-names)
		 *
		 * @return array
		 */
		public static function get_currencies() {

			if ( function_exists( 'get_woocommerce_currencies' ) ) {
				return get_woocommerce_currencies();
			}

			static $currencies;

			if ( ! isset( $currencies ) ) {
				$currencies = array_unique(
					apply_filters(
						'wpc_currencies',
						array(
							'AED' => __( 'United Arab Emirates dirham', 'woocommerce' ),
							'AFN' => __( 'Afghan afghani', 'woocommerce' ),
							'ALL' => __( 'Albanian lek', 'woocommerce' ),
							'AMD' => __( 'Armenian dram', 'woocommerce' ),
							'ANG' => __( 'Netherlands Antillean guilder', 'woocommerce' ),
							'AOA' => __( 'Angolan kwanza', 'woocommerce' ),
							'ARS' => __( 'Argentine peso', 'woocommerce' ),
							'AUD' => __( 'Australian dollar', 'woocommerce' ),
							'AWG' => __( 'Aruban florin', 'woocommerce' ),
							'AZN' => __( 'Azerbaijani manat', 'woocommerce' ),
							'BAM' => __( 'Bosnia and Herzegovina convertible mark', 'woocommerce' ),
							'BBD' => __( 'Barbadian dollar', 'woocommerce' ),
							'BDT' => __( 'Bangladeshi taka', 'woocommerce' ),
							'BGN' => __( 'Bulgarian lev', 'woocommerce' ),
							'BHD' => __( 'Bahraini dinar', 'woocommerce' ),
							'BIF' => __( 'Burundian franc', 'woocommerce' ),
							'BMD' => __( 'Bermudian dollar', 'woocommerce' ),
							'BND' => __( 'Brunei dollar', 'woocommerce' ),
							'BOB' => __( 'Bolivian boliviano', 'woocommerce' ),
							'BRL' => __( 'Brazilian real', 'woocommerce' ),
							'BSD' => __( 'Bahamian dollar', 'woocommerce' ),
							'BTC' => __( 'Bitcoin', 'woocommerce' ),
							'BTN' => __( 'Bhutanese ngultrum', 'woocommerce' ),
							'BWP' => __( 'Botswana pula', 'woocommerce' ),
							'BYR' => __( 'Belarusian ruble (old)', 'woocommerce' ),
							'BYN' => __( 'Belarusian ruble', 'woocommerce' ),
							'BZD' => __( 'Belize dollar', 'woocommerce' ),
							'CAD' => __( 'Canadian dollar', 'woocommerce' ),
							'CDF' => __( 'Congolese franc', 'woocommerce' ),
							'CHF' => __( 'Swiss franc', 'woocommerce' ),
							'CLP' => __( 'Chilean peso', 'woocommerce' ),
							'CNY' => __( 'Chinese yuan', 'woocommerce' ),
							'COP' => __( 'Colombian peso', 'woocommerce' ),
							'CRC' => __( 'Costa Rican col&oacute;n', 'woocommerce' ),
							'CUC' => __( 'Cuban convertible peso', 'woocommerce' ),
							'CUP' => __( 'Cuban peso', 'woocommerce' ),
							'CVE' => __( 'Cape Verdean escudo', 'woocommerce' ),
							'CZK' => __( 'Czech koruna', 'woocommerce' ),
							'DJF' => __( 'Djiboutian franc', 'woocommerce' ),
							'DKK' => __( 'Danish krone', 'woocommerce' ),
							'DOP' => __( 'Dominican peso', 'woocommerce' ),
							'DZD' => __( 'Algerian dinar', 'woocommerce' ),
							'EGP' => __( 'Egyptian pound', 'woocommerce' ),
							'ERN' => __( 'Eritrean nakfa', 'woocommerce' ),
							'ETB' => __( 'Ethiopian birr', 'woocommerce' ),
							'EUR' => __( 'Euro', 'woocommerce' ),
							'FJD' => __( 'Fijian dollar', 'woocommerce' ),
							'FKP' => __( 'Falkland Islands pound', 'woocommerce' ),
							'GBP' => __( 'Pound sterling', 'woocommerce' ),
							'GEL' => __( 'Georgian lari', 'woocommerce' ),
							'GGP' => __( 'Guernsey pound', 'woocommerce' ),
							'GHS' => __( 'Ghana cedi', 'woocommerce' ),
							'GIP' => __( 'Gibraltar pound', 'woocommerce' ),
							'GMD' => __( 'Gambian dalasi', 'woocommerce' ),
							'GNF' => __( 'Guinean franc', 'woocommerce' ),
							'GTQ' => __( 'Guatemalan quetzal', 'woocommerce' ),
							'GYD' => __( 'Guyanese dollar', 'woocommerce' ),
							'HKD' => __( 'Hong Kong dollar', 'woocommerce' ),
							'HNL' => __( 'Honduran lempira', 'woocommerce' ),
							'HRK' => __( 'Croatian kuna', 'woocommerce' ),
							'HTG' => __( 'Haitian gourde', 'woocommerce' ),
							'HUF' => __( 'Hungarian forint', 'woocommerce' ),
							'IDR' => __( 'Indonesian rupiah', 'woocommerce' ),
							'ILS' => __( 'Israeli new shekel', 'woocommerce' ),
							'IMP' => __( 'Manx pound', 'woocommerce' ),
							'INR' => __( 'Indian rupee', 'woocommerce' ),
							'IQD' => __( 'Iraqi dinar', 'woocommerce' ),
							'IRR' => __( 'Iranian rial', 'woocommerce' ),
							'IRT' => __( 'Iranian toman', 'woocommerce' ),
							'ISK' => __( 'Icelandic kr&oacute;na', 'woocommerce' ),
							'JEP' => __( 'Jersey pound', 'woocommerce' ),
							'JMD' => __( 'Jamaican dollar', 'woocommerce' ),
							'JOD' => __( 'Jordanian dinar', 'woocommerce' ),
							'JPY' => __( 'Japanese yen', 'woocommerce' ),
							'KES' => __( 'Kenyan shilling', 'woocommerce' ),
							'KGS' => __( 'Kyrgyzstani som', 'woocommerce' ),
							'KHR' => __( 'Cambodian riel', 'woocommerce' ),
							'KMF' => __( 'Comorian franc', 'woocommerce' ),
							'KPW' => __( 'North Korean won', 'woocommerce' ),
							'KRW' => __( 'South Korean won', 'woocommerce' ),
							'KWD' => __( 'Kuwaiti dinar', 'woocommerce' ),
							'KYD' => __( 'Cayman Islands dollar', 'woocommerce' ),
							'KZT' => __( 'Kazakhstani tenge', 'woocommerce' ),
							'LAK' => __( 'Lao kip', 'woocommerce' ),
							'LBP' => __( 'Lebanese pound', 'woocommerce' ),
							'LKR' => __( 'Sri Lankan rupee', 'woocommerce' ),
							'LRD' => __( 'Liberian dollar', 'woocommerce' ),
							'LSL' => __( 'Lesotho loti', 'woocommerce' ),
							'LYD' => __( 'Libyan dinar', 'woocommerce' ),
							'MAD' => __( 'Moroccan dirham', 'woocommerce' ),
							'MDL' => __( 'Moldovan leu', 'woocommerce' ),
							'MGA' => __( 'Malagasy ariary', 'woocommerce' ),
							'MKD' => __( 'Macedonian denar', 'woocommerce' ),
							'MMK' => __( 'Burmese kyat', 'woocommerce' ),
							'MNT' => __( 'Mongolian t&ouml;gr&ouml;g', 'woocommerce' ),
							'MOP' => __( 'Macanese pataca', 'woocommerce' ),
							'MRO' => __( 'Mauritanian ouguiya', 'woocommerce' ),
							'MUR' => __( 'Mauritian rupee', 'woocommerce' ),
							'MVR' => __( 'Maldivian rufiyaa', 'woocommerce' ),
							'MWK' => __( 'Malawian kwacha', 'woocommerce' ),
							'MXN' => __( 'Mexican peso', 'woocommerce' ),
							'MYR' => __( 'Malaysian ringgit', 'woocommerce' ),
							'MZN' => __( 'Mozambican metical', 'woocommerce' ),
							'NAD' => __( 'Namibian dollar', 'woocommerce' ),
							'NGN' => __( 'Nigerian naira', 'woocommerce' ),
							'NIO' => __( 'Nicaraguan c&oacute;rdoba', 'woocommerce' ),
							'NOK' => __( 'Norwegian krone', 'woocommerce' ),
							'NPR' => __( 'Nepalese rupee', 'woocommerce' ),
							'NZD' => __( 'New Zealand dollar', 'woocommerce' ),
							'OMR' => __( 'Omani rial', 'woocommerce' ),
							'PAB' => __( 'Panamanian balboa', 'woocommerce' ),
							'PEN' => __( 'Sol', 'woocommerce' ),
							'PGK' => __( 'Papua New Guinean kina', 'woocommerce' ),
							'PHP' => __( 'Philippine peso', 'woocommerce' ),
							'PKR' => __( 'Pakistani rupee', 'woocommerce' ),
							'PLN' => __( 'Polish z&#x142;oty', 'woocommerce' ),
							'PRB' => __( 'Transnistrian ruble', 'woocommerce' ),
							'PYG' => __( 'Paraguayan guaran&iacute;', 'woocommerce' ),
							'QAR' => __( 'Qatari riyal', 'woocommerce' ),
							'RON' => __( 'Romanian leu', 'woocommerce' ),
							'RSD' => __( 'Serbian dinar', 'woocommerce' ),
							'RUB' => __( 'Russian ruble', 'woocommerce' ),
							'RWF' => __( 'Rwandan franc', 'woocommerce' ),
							'SAR' => __( 'Saudi riyal', 'woocommerce' ),
							'SBD' => __( 'Solomon Islands dollar', 'woocommerce' ),
							'SCR' => __( 'Seychellois rupee', 'woocommerce' ),
							'SDG' => __( 'Sudanese pound', 'woocommerce' ),
							'SEK' => __( 'Swedish krona', 'woocommerce' ),
							'SGD' => __( 'Singapore dollar', 'woocommerce' ),
							'SHP' => __( 'Saint Helena pound', 'woocommerce' ),
							'SLL' => __( 'Sierra Leonean leone', 'woocommerce' ),
							'SOS' => __( 'Somali shilling', 'woocommerce' ),
							'SRD' => __( 'Surinamese dollar', 'woocommerce' ),
							'SSP' => __( 'South Sudanese pound', 'woocommerce' ),
							'STD' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'woocommerce' ),
							'SYP' => __( 'Syrian pound', 'woocommerce' ),
							'SZL' => __( 'Swazi lilangeni', 'woocommerce' ),
							'THB' => __( 'Thai baht', 'woocommerce' ),
							'TJS' => __( 'Tajikistani somoni', 'woocommerce' ),
							'TMT' => __( 'Turkmenistan manat', 'woocommerce' ),
							'TND' => __( 'Tunisian dinar', 'woocommerce' ),
							'TOP' => __( 'Tongan pa&#x2bb;anga', 'woocommerce' ),
							'TRY' => __( 'Turkish lira', 'woocommerce' ),
							'TTD' => __( 'Trinidad and Tobago dollar', 'woocommerce' ),
							'TWD' => __( 'New Taiwan dollar', 'woocommerce' ),
							'TZS' => __( 'Tanzanian shilling', 'woocommerce' ),
							'UAH' => __( 'Ukrainian hryvnia', 'woocommerce' ),
							'UGX' => __( 'Ugandan shilling', 'woocommerce' ),
							'USD' => __( 'United States (US) dollar', 'woocommerce' ),
							'UYU' => __( 'Uruguayan peso', 'woocommerce' ),
							'UZS' => __( 'Uzbekistani som', 'woocommerce' ),
							'VEF' => __( 'Venezuelan bol&iacute;var', 'woocommerce' ),
							'VES' => __( 'Bol&iacute;var soberano', 'woocommerce' ),
							'VND' => __( 'Vietnamese &#x111;&#x1ed3;ng', 'woocommerce' ),
							'VUV' => __( 'Vanuatu vatu', 'woocommerce' ),
							'WST' => __( 'Samoan t&#x101;l&#x101;', 'woocommerce' ),
							'XAF' => __( 'Central African CFA franc', 'woocommerce' ),
							'XCD' => __( 'East Caribbean dollar', 'woocommerce' ),
							'XOF' => __( 'West African CFA franc', 'woocommerce' ),
							'XPF' => __( 'CFP franc', 'woocommerce' ),
							'YER' => __( 'Yemeni rial', 'woocommerce' ),
							'ZAR' => __( 'South African rand', 'woocommerce' ),
							'ZMW' => __( 'Zambian kwacha', 'woocommerce' ),
						)
					)
				);
			}

			return $currencies;
		}

		/**
		 * Get Base Currency Code.
		 *
		 * @return string
		 */
		public static function currency() {

			if ( function_exists( 'get_woocommerce_currency' ) ) {
				return get_woocommerce_currency();
			}

			return apply_filters( 'wpc_currency', get_option( 'wpc_currency' ) );
		}

		/**
		 * Get Currency symbol.
		 *
		 * Currency symbols and names should follow the Unicode CLDR recommendation (http://cldr.unicode.org/translation/currency-names)
		 *
		 * @param string $currency Currency. (default: '').
		 * @return string
		 */
		public static function get_currency_symbol( $currency = '' ) {

			if ( function_exists( 'get_woocommerce_currency_symbol' ) ) {
				return get_woocommerce_currency_symbol( $currency );
			}

			if ( ! $currency ) {
				$currency = self::currency();
			}

			$symbols = apply_filters(
				'wpc_currency_symbols',
				array(
					'AED' => '&#x62f;.&#x625;',
					'AFN' => '&#x60b;',
					'ALL' => 'L',
					'AMD' => 'AMD',
					'ANG' => '&fnof;',
					'AOA' => 'Kz',
					'ARS' => '&#36;',
					'AUD' => '&#36;',
					'AWG' => 'Afl.',
					'AZN' => 'AZN',
					'BAM' => 'KM',
					'BBD' => '&#36;',
					'BDT' => '&#2547;&nbsp;',
					'BGN' => '&#1083;&#1074;.',
					'BHD' => '.&#x62f;.&#x628;',
					'BIF' => 'Fr',
					'BMD' => '&#36;',
					'BND' => '&#36;',
					'BOB' => 'Bs.',
					'BRL' => '&#82;&#36;',
					'BSD' => '&#36;',
					'BTC' => '&#3647;',
					'BTN' => 'Nu.',
					'BWP' => 'P',
					'BYR' => 'Br',
					'BYN' => 'Br',
					'BZD' => '&#36;',
					'CAD' => '&#36;',
					'CDF' => 'Fr',
					'CHF' => '&#67;&#72;&#70;',
					'CLP' => '&#36;',
					'CNY' => '&yen;',
					'COP' => '&#36;',
					'CRC' => '&#x20a1;',
					'CUC' => '&#36;',
					'CUP' => '&#36;',
					'CVE' => '&#36;',
					'CZK' => '&#75;&#269;',
					'DJF' => 'Fr',
					'DKK' => 'DKK',
					'DOP' => 'RD&#36;',
					'DZD' => '&#x62f;.&#x62c;',
					'EGP' => 'EGP',
					'ERN' => 'Nfk',
					'ETB' => 'Br',
					'EUR' => '&euro;',
					'FJD' => '&#36;',
					'FKP' => '&pound;',
					'GBP' => '&pound;',
					'GEL' => '&#x20be;',
					'GGP' => '&pound;',
					'GHS' => '&#x20b5;',
					'GIP' => '&pound;',
					'GMD' => 'D',
					'GNF' => 'Fr',
					'GTQ' => 'Q',
					'GYD' => '&#36;',
					'HKD' => '&#36;',
					'HNL' => 'L',
					'HRK' => 'kn',
					'HTG' => 'G',
					'HUF' => '&#70;&#116;',
					'IDR' => 'Rp',
					'ILS' => '&#8362;',
					'IMP' => '&pound;',
					'INR' => '&#8377;',
					'IQD' => '&#x639;.&#x62f;',
					'IRR' => '&#xfdfc;',
					'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
					'ISK' => 'kr.',
					'JEP' => '&pound;',
					'JMD' => '&#36;',
					'JOD' => '&#x62f;.&#x627;',
					'JPY' => '&yen;',
					'KES' => 'KSh',
					'KGS' => '&#x441;&#x43e;&#x43c;',
					'KHR' => '&#x17db;',
					'KMF' => 'Fr',
					'KPW' => '&#x20a9;',
					'KRW' => '&#8361;',
					'KWD' => '&#x62f;.&#x643;',
					'KYD' => '&#36;',
					'KZT' => 'KZT',
					'LAK' => '&#8365;',
					'LBP' => '&#x644;.&#x644;',
					'LKR' => '&#xdbb;&#xdd4;',
					'LRD' => '&#36;',
					'LSL' => 'L',
					'LYD' => '&#x644;.&#x62f;',
					'MAD' => '&#x62f;.&#x645;.',
					'MDL' => 'MDL',
					'MGA' => 'Ar',
					'MKD' => '&#x434;&#x435;&#x43d;',
					'MMK' => 'Ks',
					'MNT' => '&#x20ae;',
					'MOP' => 'P',
					'MRO' => 'UM',
					'MUR' => '&#x20a8;',
					'MVR' => '.&#x783;',
					'MWK' => 'MK',
					'MXN' => '&#36;',
					'MYR' => '&#82;&#77;',
					'MZN' => 'MT',
					'NAD' => '&#36;',
					'NGN' => '&#8358;',
					'NIO' => 'C&#36;',
					'NOK' => '&#107;&#114;',
					'NPR' => '&#8360;',
					'NZD' => '&#36;',
					'OMR' => '&#x631;.&#x639;.',
					'PAB' => 'B/.',
					'PEN' => 'S/',
					'PGK' => 'K',
					'PHP' => '&#8369;',
					'PKR' => '&#8360;',
					'PLN' => '&#122;&#322;',
					'PRB' => '&#x440;.',
					'PYG' => '&#8370;',
					'QAR' => '&#x631;.&#x642;',
					'RMB' => '&yen;',
					'RON' => 'lei',
					'RSD' => '&#x434;&#x438;&#x43d;.',
					'RUB' => '&#8381;',
					'RWF' => 'Fr',
					'SAR' => '&#x631;.&#x633;',
					'SBD' => '&#36;',
					'SCR' => '&#x20a8;',
					'SDG' => '&#x62c;.&#x633;.',
					'SEK' => '&#107;&#114;',
					'SGD' => '&#36;',
					'SHP' => '&pound;',
					'SLL' => 'Le',
					'SOS' => 'Sh',
					'SRD' => '&#36;',
					'SSP' => '&pound;',
					'STD' => 'Db',
					'SYP' => '&#x644;.&#x633;',
					'SZL' => 'L',
					'THB' => '&#3647;',
					'TJS' => '&#x405;&#x41c;',
					'TMT' => 'm',
					'TND' => '&#x62f;.&#x62a;',
					'TOP' => 'T&#36;',
					'TRY' => '&#8378;',
					'TTD' => '&#36;',
					'TWD' => '&#78;&#84;&#36;',
					'TZS' => 'Sh',
					'UAH' => '&#8372;',
					'UGX' => 'UGX',
					'USD' => '&#36;',
					'UYU' => '&#36;',
					'UZS' => 'UZS',
					'VEF' => 'Bs F',
					'VES' => 'Bs.S',
					'VND' => '&#8363;',
					'VUV' => 'Vt',
					'WST' => 'T',
					'XAF' => 'CFA',
					'XCD' => '&#36;',
					'XOF' => 'CFA',
					'XPF' => 'Fr',
					'YER' => '&#xfdfc;',
					'ZAR' => '&#82;',
					'ZMW' => 'ZK',
				)
			);

			$currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

			return apply_filters( 'wpc_currency_symbol', $currency_symbol, $currency );
		}

		/**
		 * Get the price format depending on the currency position.
		 *
		 * @return string
		 */
		public static function price_format() {

			if ( function_exists( 'get_woocommerce_price_format' ) ) {
				return get_woocommerce_price_format();
			}

			$currency_pos = get_option( 'wpc_currency_pos' );
			$format       = '%1$s%2$s';

			switch ( $currency_pos ) {
				case 'left':
					$format = '%1$s%2$s';
					break;
				case 'right':
					$format = '%2$s%1$s';
					break;
				case 'left_space':
					$format = '%1$s&nbsp;%2$s';
					break;
				case 'right_space':
					$format = '%2$s&nbsp;%1$s';
					break;
			}

			return apply_filters( 'wpc_price_format', $format, $currency_pos );
		}

		/**
		 * Return the decimal separator for prices.
		 *
		 * @return string
		 */
		public static function price_decimal_separator() {

			if ( function_exists( 'wc_get_price_decimal_separator' ) ) {
				return wc_get_price_decimal_separator();
			}

			$separator = apply_filters( 'wpc_price_decimal_separator', get_option( 'wpc_price_decimal_sep' ) );
			return $separator ? stripslashes( $separator ) : '.';
		}

		/**
		 * Return the thousand separator for prices.
		 *
		 * @return string
		 */
		public static function price_thousand_separator() {

			if ( function_exists( 'wc_get_price_thousand_separator' ) ) {
				return wc_get_price_thousand_separator();
			}

			return stripslashes( apply_filters( 'wpc_price_thousand_separator', get_option( 'wpc_price_thousand_sep' ) ) );
		}

		/**
		 * Return the number of decimals after the decimal point.
		 *
		 * @return int
		 */
		public static function get_price_decimals() {

			if ( function_exists( 'wc_get_price_decimals' ) ) {
				return wc_get_price_decimals();
			}

			return absint( apply_filters( 'wpc_get_price_decimals', get_option( 'wpc_price_num_decimals', 2 ) ) );
		}

		/**
		 * Format the price with a currency symbol.
		 *
		 * @param  float $price Raw price.
		 * @param  array $args  Arguments to format a price.
		 * @return string
		 */
		public static function price( $price, $args = array() ) {

			if ( function_exists( 'wc_price' ) ) {
				return wc_price( $price, $args );
			}

			$args = apply_filters(
				'wpc_price_args',
				wp_parse_args(
					$args,
					array(
						'ex_tax_label'       => false,
						'currency'           => '',
						'decimal_separator'  => self::price_decimal_separator(),
						'thousand_separator' => self::price_thousand_separator(),
						'decimals'           => self::get_price_decimals(),
						'price_format'       => self::price_format(),
					)
				)
			);

			$unformatted_price = $price;
			$negative          = $price < 0;
			$price             = apply_filters( 'wpc_raw_price', floatval( $negative ? $price * -1 : $price ) );
			$price             = apply_filters( 'wpc_formatted_price', number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] ), $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );

			if ( apply_filters( 'wpc_price_trim_zeros', false ) && $args['decimals'] > 0 ) {
				$price = wc_trim_zeros( $price );
			}

			$formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'], '<span class="currency-symbol">' . self::get_currency_symbol( $args['currency'] ) . '</span>', $price );
			$return          = '<span class="amount">' . $formatted_price . '</span>';

			/**
			 * Filters the string of price markup.
			 *
			 * @param string $return            Price HTML markup.
			 * @param string $price             Formatted price.
			 * @param array  $args              Pass on the args.
			 * @param float  $unformatted_price Price as float to allow plugins custom formatting. Since 3.2.0.
			 */
			return apply_filters( 'wpc_price', $return, $price, $args, $unformatted_price );
		}

		/**
		 * Returns layer and global media type control ID.
		 *
		 * @return array
		 */
		public static function get_image_fields() {

			$image_fields = array(
				'non_view_control' => array(
					'layer' => array( 'icon' ),
				),
				'view_control'     => array(
					'layer'  => array( 'image' ),
					'global' => array( '_wpc_view_background' ),
				),
			);

			return apply_filters( 'wpc_image_fields', $image_fields );
		}

		/**
		 * Wrapper for deprecated functions so we can apply some extra logic.
		 *
		 * @param string $function Function used.
		 * @param string $version Version the message was added in.
		 * @param string $replacement Replacement for the called function.
		 */
		public static function deprecated_function( $function = '', $version = '', $replacement = null ) {
			// @codingStandardsIgnoreStart
			if ( wp_doing_ajax() ) {
				do_action( 'deprecated_function_run', $function, $replacement, $version );
				$log_string  = "The {$function} function is deprecated since version {$version}.";
				$log_string .= $replacement ? " Replace with {$replacement}." : '';
				error_log( $log_string );
			} else {
				_deprecated_function( $function, $version, $replacement );
			}
			// @codingStandardsIgnoreEnd
		}

		/**
		 * Wrapper for deprecated hook so we can apply some extra logic.
		 *
		 * @param string $hook        The hook that was used.
		 * @param string $version     The version of WordPress that deprecated the hook.
		 * @param string $replacement The hook that should have been used.
		 * @param string $message     A message regarding the change.
		 */
		public static function deprecated_hook( $hook, $version, $replacement = null, $message = null ) {
			// @codingStandardsIgnoreStart
			if ( wp_doing_ajax() ) {
				do_action( 'deprecated_hook_run', $hook, $replacement, $version, $message );

				$message    = empty( $message ) ? '' : ' ' . $message;
				$log_string = "{$hook} is deprecated since version {$version}";
				$log_string .= $replacement ? "! Use {$replacement} instead." : ' with no alternative available.';

				error_log( $log_string . $message );
			} else {
				_deprecated_hook( $hook, $version, $replacement, $message );
			}
			// @codingStandardsIgnoreEnd
		}

		/**
		 * Returns icon class name.
		 *
		 * @param string $name Icon name.
		 * @return string|array
		 */
		public static function icon( $name = '' ) {

			/**
			 * Filter: List of icons classes.
			 *
			 * * @version 3.0
			 *
			 * @param array   $icon List of icons.
			 */
			$icons = apply_filters(
				'wpc_icons',
				array(
					'help'         => 'wpc-help',
					'blocked'      => 'wpc-blocked',
					'solid-heart'  => 'wpc-solid-heart',
					'solid-star'   => 'wpc-solid-star',
					'star'         => 'wpc-star',
					'check'        => 'wpc-check',
					'heart'        => 'wpc-heart',
					'angle-down'   => 'wpc-angle-down',
					'angle-up'     => 'wpc-angle-up',
					'minus'        => 'wpc-minus',
					'plus'         => 'wpc-plus',
					'cross-simple' => 'wpc-cross-simple',
					'tick'         => 'wpc-tick',
					'pencil'       => 'wpc-pencil',
					'trash'        => 'wpc-trash',
					'angle-right'  => 'wpc-angle-right',
					'angle-left'   => 'wpc-angle-left',
					'sort'         => 'wpc-sort',
					'info'         => 'wpc-info',
					'mail'         => 'wpc-mail',
					'image'        => 'wpc-image',
					'full-screen'  => 'wpc-full-screen',
					'chevron-down' => 'wpc-chevron-down',
					'chevron-up'   => 'wpc-chevron-up',
					'like'         => 'wpc-like',
					'camera'       => 'wpc-camera',
					'save'         => 'wpc-save',
					'reset'        => 'wpc-reset',
					'inspiration'  => 'wpc-inspiration',
					'settings'     => 'wpc-settings',
					'share'        => 'wpc-share',
					'menu'         => 'wpc-menu',
					'close'        => 'wpc-close',
					'prev-arrow'   => 'wpc-prev-arrow',
					'next-arrow'   => 'wpc-next-arrow',
					'basket'       => 'wpc-basket',
					'cross'        => 'wpc-cross',
					'arrow-left'   => 'wpc-arrow-left',
					'sidebar'      => 'wpc-sidebar',
					'arrow-right'  => 'wpc-arrow-right',
					'refresh'      => 'wpc-refresh',
					'facebook'     => 'wpc-facebook',
					'linkedin'     => 'wpc-linkedin',
					'pinterest'    => 'wpc-pinterest',
					'twitter'      => 'wpc-twitter',
					'reddit'       => 'wpc-reddit',
					'copy'         => 'wpc-copy',
				)
			);

			return isset( $icons[ $name ] ) ? $icons[ $name ] : $icons;
		}

		/**
		 * Return alpine attributes.
		 *
		 * @return array
		 */
		public static function alpine_allowed_attributes() {
			return array(
				'x-data'                      => true,
				'x-on:resize.window'          => true,
				'x-on:resize.debounce.window' => true,
				'x-on:click'                  => true,
				'x-on:click.stop'             => true,
				'x-on:click.stop.self'        => true,
				'x-on:click.self'             => true,
				'x-on:click.prevent'          => true,
				'x-on:click.prevent.stop'     => true,
				'x-on:submit'                 => true,
				'x-on:change'                 => true,
				'x-on:change.stop'            => true,
				'x-on:input'                  => true,
				'x-on:focus'                  => true,
				'x-text'                      => true,
				'x-bind:data-uid'             => true,
				'x-bind:class'                => true,
				'x-bind:style'                => true,
				'x-bind:src'                  => true,
				'x-bind:value'                => true,
				'x-bind:maxlength'            => true,
				'x-bind:selected'             => true,
				'xlink:href'                  => true,
				'x-bind:fill'                 => true,
				'x-init'                      => true,
				'x-show'                      => true,
				'x-for'                       => true,
				'x-if'                        => true,
				'x-else'                      => true,
			);
		}

		/**
		 * Returns allowed html tags.
		 *
		 * @param array $allowed_tags Allowed html tags.
		 * @return array
		 */
		public static function allowed_tags( $allowed_tags = array() ) {

			$ignore_check = true;

			if ( $ignore_check || in_array( 'div', $allowed_tags, true ) ) {
				$tags['div'] = array(
					'id'     => true,
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['div'] = array_merge( $tags['div'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'header', $allowed_tags, true ) ) {
				$tags['header'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['header'] = array_merge( $tags['header'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'footer', $allowed_tags, true ) ) {
				$tags['footer'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['footer'] = array_merge( $tags['footer'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'h1', $allowed_tags, true ) ) {
				$tags['h1'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['h1'] = array_merge( $tags['h1'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'h2', $allowed_tags, true ) ) {
				$tags['h2'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['h2'] = array_merge( $tags['h2'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'h3', $allowed_tags, true ) ) {
				$tags['h3'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['h3'] = array_merge( $tags['h3'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'h4', $allowed_tags, true ) ) {
				$tags['h4'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['h4'] = array_merge( $tags['h4'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'h5', $allowed_tags, true ) ) {
				$tags['h5'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['h5'] = array_merge( $tags['h5'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'h6', $allowed_tags, true ) ) {
				$tags['h6'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['h6'] = array_merge( $tags['h6'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'ul', $allowed_tags, true ) ) {
				$tags['ul'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['ul'] = array_merge( $tags['ul'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'li', $allowed_tags, true ) ) {
				$tags['li'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['li'] = array_merge( $tags['li'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'p', $allowed_tags, true ) ) {
				$tags['p'] = array(
					'class'       => true,
					'role'        => true,
					'aria-live'   => true,
					'aria-atomic' => true,
					'data-*'      => true,
				);

				$tags['p'] = array_merge( $tags['p'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'a', $allowed_tags, true ) ) {
				$tags['a'] = array(
					'href'   => true,
					'id'     => true,
					'class'  => true,
					'style'  => true,
					'target' => true,
					'title'  => true,
					'data-*' => true,
				);

				$tags['a'] = array_merge( $tags['a'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'img', $allowed_tags, true ) ) {
				$tags['img'] = array(
					'src'    => true,
					'alt'    => true,
					'width'  => true,
					'height' => true,
					'title'  => true,
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['img'] = array_merge( $tags['img'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'span', $allowed_tags, true ) ) {
				$tags['span'] = array(
					'id'     => true,
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['span'] = array_merge( $tags['span'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'i', $allowed_tags, true ) ) {
				$tags['i'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['i'] = array_merge( $tags['i'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'strong', $allowed_tags, true ) ) {
				$tags['strong'] = array(
					'class'  => true,
					'style'  => true,
					'data-*' => true,
				);

				$tags['strong'] = array_merge( $tags['strong'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'iframe', $allowed_tags, true ) ) {
				$tags['iframe'] = array(
					'width'           => true,
					'height'          => true,
					'style'           => true,
					'loading'         => true,
					'allowfullscreen' => true,
					'referrerpolicy'  => true,
					'src'             => true,
					'data-*'          => true,
				);

				$tags['iframe'] = array_merge( $tags['iframe'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'audio', $allowed_tags, true ) ) {
				$tags['audio'] = array(
					'id'       => true,
					'class'    => true,
					'controls' => true,
					'src'      => true,
					'data-*'   => true,
				);

				$tags['audio'] = array_merge( $tags['audio'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'form', $allowed_tags, true ) ) {
				$tags['form'] = array(
					'class'      => true,
					'novalidate' => true,
					'action'     => true,
					'method'     => true,
					'enctype'    => true,
					'data-*'     => true,
				);

				$tags['form'] = array_merge( $tags['form'], self::alpine_allowed_attributes() );

				$tags['label'] = array(
					'for'    => true,
					'class'  => true,
					'data-*' => true,
				);

				$tags['label'] = array_merge( $tags['label'], self::alpine_allowed_attributes() );

				$tags['select'] = array(
					'name'   => true,
					'class'  => true,
					'data-*' => true,
				);

				$tags['select'] = array_merge( $tags['select'], self::alpine_allowed_attributes() );

				$tags['option'] = array(
					'class'    => true,
					'value'    => true,
					'selected' => true,
					'data-*'   => true,
				);

				$tags['option'] = array_merge( $tags['option'], self::alpine_allowed_attributes() );

				$tags['input'] = array(
					'id'          => true,
					'class'       => true,
					'name'        => true,
					'type'        => true,
					'placeholder' => true,
					'value'       => true,
					'min'         => true,
					'max'         => true,
					'step'        => true,
					'maxlength'   => true,
					'accept'      => true,
					'checked'     => true,
					'data-*'      => true,
				);

				$tags['input'] = array_merge( $tags['input'], self::alpine_allowed_attributes() );

				$tags['textarea'] = array(
					'id'          => true,
					'class'       => true,
					'name'        => true,
					'placeholder' => true,
					'data-*'      => true,
				);

				$tags['textarea'] = array_merge( $tags['textarea'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'button', $allowed_tags, true ) ) {
				$tags['button'] = array(
					'id'     => true,
					'class'  => true,
					'data-*' => true,
				);

				$tags['button'] = array_merge( $tags['button'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'svg', $allowed_tags, true ) ) {
				$tags['svg'] = array(
					'id'          => true,
					'xmlns'       => true,
					'xmlns:xlink' => true,
					'width'       => true,
					'height'      => true,
					'viewbox'     => true,
					'data-*'      => true,
				);

				$tags['svg'] = array_merge( $tags['svg'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'mask', $allowed_tags, true ) ) {
				$tags['mask'] = array(
					'id' => true,
				);

				$tags['mask'] = array_merge( $tags['mask'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'ellipse', $allowed_tags, true ) ) {
				$tags['ellipse'] = array(
					'cx'     => true,
					'cy'     => true,
					'rx'     => true,
					'ry'     => true,
					'fill'   => true,
					'filter' => true,
				);

				$tags['ellipse'] = array_merge( $tags['ellipse'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'image', $allowed_tags, true ) ) {
				$tags['image'] = array(
					'xlink:href' => true,
					'width'      => true,
					'height'     => true,
					'mask'       => true,
				);

				$tags['image'] = array_merge( $tags['image'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'defs', $allowed_tags, true ) ) {
				$tags['defs'] = array();

				$tags['defs'] = array_merge( $tags['defs'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'path', $allowed_tags, true ) ) {
				$tags['path'] = array(
					'id'     => true,
					'class'  => true,
					'd'      => true,
					'fill'   => true,
					'data-*' => true,
				);

				$tags['path'] = array_merge( $tags['path'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'text', $allowed_tags, true ) ) {
				$tags['text'] = array(
					'x'      => true,
					'data-*' => true,
				);

				$tags['text'] = array_merge( $tags['text'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'textpath', $allowed_tags, true ) ) {
				$tags['textpath'] = array(
					'data-*' => true,
				);

				$tags['textpath'] = array_merge( $tags['textpath'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'template', $allowed_tags, true ) ) {
				$tags['template'] = array(
					'data-*' => true,
				);

				$tags['template'] = array_merge( $tags['template'], self::alpine_allowed_attributes() );
			}

			if ( $ignore_check || in_array( 'canvas', $allowed_tags, true ) ) {
				$tags['canvas'] = array(
					'id'     => true,
					'data-*' => true,
				);

				$tags['canvas'] = array_merge( $tags['canvas'], self::alpine_allowed_attributes() );
			}

			/**
			 * Filter: Allowed html tags.
			 *
			 * * @version 3.0
			 *
			 * @param array   $tags Allowed html tags.
			 */
			return apply_filters( 'wpc_allowed_html_tags', $tags );
		}
	}

}
