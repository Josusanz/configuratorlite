<?php
/**
 * Template functions
 *
 * @package  wp-configurator-pro/includes/
 * @version  3.4.10
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wpc_control_inner_html_end', 'wpc_control_inner_html_end', 10, 3 );
if ( ! function_exists( 'wpc_control_inner_html_end' ) ) {
	function wpc_control_inner_html_end( $layer = array(), $wpc = null, $force_stop = false ) {

		$config_data = $wpc->config[ $wpc->id ];

		$uid = isset( $layer['uid'] ) ? $layer['uid'] : '';

		$level = $config_data->get_level( $uid );

		$type = $wpc->control_type;

		if ( 'type-1' === $type ) {
			if ( isset( $layer['children'] ) && ! empty( $layer['children'] ) ) {
				echo $wpc->get_sub_controls_included( $layer['children'], $uid ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		} elseif ( 'type-3' === $type ) {
			if ( $level > 1 ) {
				if ( isset( $layer['children'] ) && ! empty( $layer['children'] ) ) {
					echo $wpc->get_sub_controls_included( $layer['children'], $uid ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		} elseif ( 'type-4' === $type ) {
			if ( isset( $layer['children'] ) && ! empty( $layer['children'] ) ) {
				echo $wpc->get_sub_controls_items_separated( $layer['children'], $uid ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		} elseif ( 'type-5' === $type ) {
			if ( $level > 1 && ! $force_stop ) {
				if ( isset( $layer['children'] ) && ! empty( $layer['children'] ) ) {
					echo $wpc->get_sub_controls_children_separated( $layer['children'], $uid ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		}
	}
}

add_filter( 'wpc_config_layer_extra_data', 'wpc_config_layer_extra_data', 10, 3 );
if ( ! function_exists( 'wpc_config_layer_extra_data' ) ) {
	function wpc_config_layer_extra_data( $extras = array(), $uid = '', $config_data = null ) {
		$layer_settings = $config_data->get_layer_settings( $uid );

		$control_type = isset( $layer_settings['control_type'] ) ? $layer_settings['control_type'] : 'icon';
		$color        = isset( $layer_settings['color'] ) ? $layer_settings['color'] : '';

		if ( 'color' === $control_type && ! empty( $color ) ) {
			$extras['css'][ '.custom-icon-color[data-uid="' . esc_attr( $uid ) . '"] .wpc-control-item-color' ] = 'background:  ' . WPC_Utils::sanitize_color( $color ) . '';
		}

		return $extras;
	}
}

add_filter( 'wpc_config_extra_data', 'wpc_config_extra_data', 10, 2 );
if ( ! function_exists( 'wpc_config_extra_data' ) ) {
	function wpc_config_extra_data( $extras = array(), $config_data = null ) {

		$view_background = WPC_Utils::get_meta_value( $config_data->id, '_wpc_view_background', array() );

		if ( ! empty( $view_background ) ) {

			foreach ( $view_background as $view => $image_id ) {

				if ( empty( $image_id ) ) {
					continue;
				}

				$image = WPC_Utils::get_image( $image_id );

				$extras['css'][ '[data-config-id="' . esc_attr( $config_data->id ) . '"] .wpc-preview-inner[data-type="' . esc_attr( $view ) . '"]' ] = 'background:  url( ' . esc_url( $image ) . ')';
			}
		}

		$image_max_width  = $config_data->get_image_max_width();
		$image_max_height = $config_data->get_image_max_height();

		$extras['css'][':root']  = '--wpc-' . esc_attr( $config_data->id ) . '-image-max-width: ' . esc_html( $image_max_width ) . 'px;';
		$extras['css'][':root'] .= '--wpc-' . esc_attr( $config_data->id ) . '-image-max-height: ' . esc_html( $image_max_height ) . 'px;';
		$extras['css'][':root'] .= '--wpc-top-spacing: calc( (100vh - var(--wpc-' . esc_attr( $config_data->id ) . '-image-max-height)) / 2 )';

		return $extras;
	}
}

add_filter( 'wpc_control_item_classes', 'wpc_control_item_classes', 10, 4 );
if ( ! function_exists( 'wpc_control_item_classes' ) ) {
	/**
	 * Returns control item classes.
	 *
	 * @param array    $class Classes.
	 * @param string   $uid Layer uid.
	 * @param WPC_Data $config_data Configurator data.
	 * @param WPCSE    $wpc Core configurator shortcode.
	 * @return array
	 */
	function wpc_control_item_classes( $class = array(), $uid = '', $config_data = null, $wpc = null ) {

		if ( 'type-4' === $wpc->control_type ) {
			$has_child = $config_data->has_children( $uid );

			$allow = false;

			unset( $class['has-children'] );

			if ( $has_child ) {

				$children = $config_data->get_children( $uid );

				foreach ( $children as $key => $current_uid ) {
					$type = $config_data->get_type( $current_uid );

					if ( wpc_is_control_allowed( $current_uid, $wpc ) && 'sub_group' === $type ) {
						$allow = true;
					}
				}

				if ( $allow ) {
					$class['has-children'] = 'wpc-control-has-children';
				}
			}
		}

		return $class;
	}
}

add_action( 'wpc_control_group_html', 'wpc_control_group_html', 10, 2 );
add_action( 'wpc_control_sub_group_html', 'wpc_control_group_html', 10, 2 );
if ( ! function_exists( 'wpc_control_group_html' ) ) {
	function wpc_control_group_html( $layer, $wpc ) {

		$config_data = $wpc->config[ $wpc->id ];

		$style = $wpc->style;

		$uid = isset( $layer['uid'] ) ? $layer['uid'] : '';

		$level = $config_data->get_level( $uid );

		if ( 'accordion' === $style ) {
			wpc_control_group_name( $uid, $wpc );
		}
	}
}

add_action( 'wpc_control_image_html', 'wpc_control_image_html', 10, 2 );
if ( ! function_exists( 'wpc_control_image_html' ) ) {
	function wpc_control_image_html( $layer, $wpc ) {

		$uid = isset( $layer['uid'] ) ? $layer['uid'] : '';

		wpc_control_item_icon( $uid, $wpc );
		wpc_control_info( $uid, $wpc );
	}
}

add_filter( 'wpc_show_active_layer_icons', 'wpc_show_active_layer_icons', 10, 3 );
if ( ! function_exists( 'wpc_show_active_layer_icons' ) ) {
	function wpc_show_active_layer_icons( $allow = false, $uid = '', $wpc = null ) {
		if ( 'accordion' === $wpc->style ) {
			return true;
		}

		return $allow;
	}
}

add_action( 'wpc_after_controls_html', 'wpc_last_level_control_items_html', 10 );
if ( ! function_exists( 'wpc_last_level_control_items_html' ) ) {
	function wpc_last_level_control_items_html( $wpc ) {

		$config_data = $wpc->config[ $wpc->id ];

		$type = $wpc->control_type;

		if ( 'type-4' === $type || 'type-6' === $type ) {
			if ( ! empty( $wpc->control_items ) ) {
				/**
				 * Hook: Before control item group html.
				 *
				 * * @since 3.4.1
				 *
				 * @param object $wpc WPCSE.
				 */
				do_action( 'wpc_before_control_item_group', $wpc );
				?>
				<div x-data class="wpc-config-element wpc-control-items-group-wrap" x-bind:class="{ 'active': <?php echo esc_attr( $wpc->store . '.hasCurrentItemGroup()' ); ?> }">
					<?php

					/**
					 * Hook: Before control item group inner html.
					 *
					 * * @since 3.4.1
					 *
					 * @param object $wpc WPCSE.
					 */
					do_action( 'wpc_before_control_item_group_inner', $wpc );

					foreach ( $wpc->control_items as $parent_uid => $children ) {

						$wrap_attr['class']           = 'class="wpc-control-items-group"';
						$wrap_attr['data-parent-uid'] = 'data-parent-uid="' . esc_attr( $parent_uid ) . '"';
						$wrap_attr['alpine:class']    = 'x-bind:class="' . esc_attr( $wpc->store . '.getGroupLayerClasses( "' . $parent_uid . '" )' ) . '"';
						?>
						<div <?php echo implode( ' ', $wrap_attr ); ?>>

							<?php
							/**
							 * Hook: Before control item group items html.
							 *
							 * * @since 3.4.1
							 *
							 * @param object $wpc WPCSE.
							 */
							do_action( 'wpc_before_control_item_group_items', $parent_uid, $children, $wpc );
							?>

							<ul>
								<?php
								foreach ( $children as $key => $layer ) {
									echo wp_kses( $wpc->get_control_item( $layer ), WPC_Utils::allowed_tags() );
								}
								?>
							</ul>

							<?php
							/**
							 * Hook: After control item group items html.
							 *
							 * * @since 3.4.1
							 *
							 * @param object $wpc WPCSE.
							 */
							do_action( 'wpc_after_control_item_group_items', $parent_uid, $children, $wpc );
							?>
						</div>
						<?php
					}

					/**
					 * Hook: After control item group inner html.
					 *
					 * * @since 3.4.1
					 *
					 * @param object $wpc WPCSE.
					 */
					do_action( 'wpc_after_control_item_group_inner', $wpc );
					?>
				</div>
				<?php
				/**
				 * Hook: Before control item group html.
				 *
				 * * @since 3.4.1
				 *
				 * @param object $wpc WPCSE.
				 */
				do_action( 'wpc_after_control_item_group', $wpc );
			}
		}
	}
}

add_action( 'wpc_before_control_item_group_items', 'wpc_before_control_item_group_items', 10, 3 );
function wpc_before_control_item_group_items( $parent_uid = '', $children = array(), $wpc = null ) {

	$config_data = $wpc->config[ $wpc->id ];

	$name = $config_data->get_name( $parent_uid );
	?>
	<h2 class="wpc-control-item-group-title"><?php echo esc_html( $name ); ?></h2>
	<?php
}

add_action( 'wpc_before_control_item_group_inner', 'wpc_close_item_group' );
function wpc_close_item_group( $wpc = null ) {
	$close_attr['class']        = 'class="wpc-close-control-item-group ' . WPC_Utils::icon( 'close' ) . '"';
	$close_attr['alpine:click'] = 'x-on:click="' . esc_attr( $wpc->store . '.closeItemGroup()' ) . '"';
	?>
	<span <?php echo implode( ' ', $close_attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></span>
	<?php
}

add_action( 'wpc_after_control_item_group', 'wpc_after_control_item_group' );
function wpc_after_control_item_group( $wpc = null ) {
	wp_localize_script(
		'wpc-utils',
		'wpc_' . $wpc->id . '_control_items_group_uids',
		array_keys( $wpc->control_items )
	);
}

add_action( 'wpc_control_inner_html_end', 'wpc_control_detailed_info', 5, 3 );
if ( ! function_exists( 'wpc_control_detailed_info' ) ) {
	function wpc_control_detailed_info( $layer, $wpc, $force_stop ) {

		$uid = isset( $layer['uid'] ) ? $layer['uid'] : '';

		if ( apply_filters( 'wpc_' . $wpc->style . '_allow_detailed_info', false, $wpc ) ) {
			?>
			<span class="wpc-control-detail-info-trigger <?php echo esc_attr( WPC_Utils::icon( 'help' ) ); ?>" x-on:click.stop="<?php echo esc_attr( $wpc->store . '.setCurrentSelectionUid("' . $uid . '")' ); ?>"></span>
			<?php
		}
	}
}

add_action( 'wpc_before_controls_html', 'wpc_breadcrumbs_before_controls_html' );
if ( ! function_exists( 'wpc_breadcrumbs_before_controls_html' ) ) {
	function wpc_breadcrumbs_before_controls_html( $wpc = null ) {
		if ( apply_filters( 'wpc_' . $wpc->style . '_allow_control_item_breadcrumbs', false, $wpc ) ) {
			wpc_control_breadcrumbs( $wpc );
		}
	}
}

add_action( 'wpc_before_controls_html', 'wpc_fiter_before_controls_html' );
if ( ! function_exists( 'wpc_fiter_before_controls_html' ) ) {
	function wpc_fiter_before_controls_html( $wpc = null ) {
		if ( apply_filters( 'wpc_' . $wpc->style . '_allow_control_item_filter', false, $wpc ) ) {
			wpc_control_filter( $wpc );
		}
	}
}

add_action( 'wpc_after_controls_html', 'wpc_after_controls_html_control_info' );
if ( ! function_exists( 'wpc_after_controls_html_control_info' ) ) {
	function wpc_after_controls_html_control_info( $wpc = null ) {
		$uid = isset( $layer['uid'] ) ? $layer['uid'] : '';

		if ( apply_filters( 'wpc_' . $wpc->style . '_allow_detailed_info', false, $wpc ) ) {
			wpc_control_info_popup( $wpc );
		}
	}
}

add_action( 'wpc_before_summary_form', 'wpc_summary_stock_html', 10 );
if ( ! function_exists( 'wpc_summary_stock_html' ) ) {
	function wpc_summary_stock_html( $wpc = null ) {
		if ( 'cart-form' === $wpc->form ) {
			$product = ( WPC_WOO_ACTIVE ) ? wc_get_product( $wpc->product_id ) : false;

			echo wc_get_stock_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

add_action( 'wpc_summary_form', 'wpc_summary_cart_form_html', 10 );
if ( ! function_exists( 'wpc_summary_cart_form_html' ) ) {
	function wpc_summary_cart_form_html( $wpc = null ) {
		if ( 'cart-form' === $wpc->form ) {
			$wpc->get_cart_form( true );
		}
	}
}

add_action( 'wpc_summary_form', 'wpc_summary_trigger_html', 15 );
if ( ! function_exists( 'wpc_summary_trigger_html' ) ) {
	function wpc_summary_trigger_html( $wpc = null ) {
		$wpc->get_summary_trigger( true );
	}
}

add_action( 'wpc_summary_form', 'wpc_summary_popup_html', 20 );
if ( ! function_exists( 'wpc_summary_popup_html' ) ) {
	function wpc_summary_popup_html( $wpc = null ) {
		$wpc->get_summary_popup( true );
	}
}

add_action( 'wpc_summary_content', 'wpc_summary_header_html' );
if ( ! function_exists( 'wpc_summary_header_html' ) ) {
	function wpc_summary_header_html( $wpc = null ) {
		$wpc->get_summary_header( true );
	}
}

add_action( 'wpc_summary_content', 'wpc_summary_content_html', 20 );
if ( ! function_exists( 'wpc_summary_content_html' ) ) {
	function wpc_summary_content_html( $wpc = null ) {
		$wpc->get_summary_content( true );
	}
}

add_action( 'wpc_after_controls_wrap_html', 'wpc_print_localize_script' );
if ( ! function_exists( 'wpc_print_localize_script' ) ) {
	function wpc_print_localize_script( $wpc ) {

		// Print all the required data.
		$wpc->print_localize_script();
	}
}

add_action( 'wpc_summary_list_content', 'wpc_summary_title_html', 10 );
if ( ! function_exists( 'wpc_summary_title_html' ) ) {
	function wpc_summary_title_html( $wpc = null ) {
		?>
		<h4 class="wpc-summary-title"><?php echo esc_html( $wpc->summary_title ); ?></h4>
		<?php
	}
}

add_action( 'wpc_summary_list_content', 'wpc_summary_list_html', 15 );
if ( ! function_exists( 'wpc_summary_list_html' ) ) {
	function wpc_summary_list_html( $wpc = null ) {
		$wpc->get_summary_lists( true );
	}
}

add_action( 'wpc_summary_list_content', 'wpc_summary_total_html', 20 );
if ( ! function_exists( 'wpc_summary_total_html' ) ) {
	function wpc_summary_total_html( $wpc = null ) {
		$wpc->get_summary_total( true );
	}
}

add_action( 'wpc_after_summary_list_content', 'wpc_summary_form_html', 20 );
if ( ! function_exists( 'wpc_summary_form_html' ) ) {
	function wpc_summary_form_html( $wpc = null ) {
		if ( 'contact-form' === $wpc->form && ! empty( $wpc->contact_form ) ) {
			$wpc->get_contact_form( true );
		} elseif ( 'quote-form' === $wpc->form ) {
			$wpc->get_quote_form( true );
		}
	}
}

add_action( 'wpc_after_summary_header_title', 'wpc_cart_summary_cart_btn_html', 10 );
if ( ! function_exists( 'wpc_cart_summary_cart_btn_html' ) ) {
	function wpc_cart_summary_cart_btn_html( $wpc = null ) {
		if ( 'cart-form' === $wpc->form ) {
			?>
			<div class="wpc-summary-title-wrap">
				<h4 class="wpc-summary-title"><?php echo esc_html( $wpc->summary_title ); ?></h4>

				<?php
				$product = ( WPC_WOO_ACTIVE ) ? wc_get_product( $wpc->product_id ) : false;

				if ( $product->is_in_stock() ) {
					?>
					<a href="#" class="wpc-primary-btn js-wpc-submit-cart-form"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></a>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}

add_filter( 'wpc_allow_preview_element', 'wpc_allow_preview_element', 10, 4 );
function wpc_allow_preview_element( $allow = '', $uid = '', $view = '', $wpc = null ) {
	$config_data = $wpc->config[ $wpc->id ];

	$view_settings = $config_data->get_view_settings( $uid, $view );

	if ( isset( $view_settings['image'] ) && $view_settings['image'] ) {
		return true;
	}

	return $allow;
}

add_action( 'wpc_subset_inner_html', 'wpc_subset_inner_html', 10, 3 );
function wpc_subset_inner_html( $uid = '', $view = '', $wpc = null ) {

	$config_data = $wpc->config[ $wpc->id ];

	$layer_type = $config_data->get_type( $uid );

	if ( 'image' !== $layer_type ) {
		return;
	}

	$view_settings = $config_data->get_view_settings( $uid, $view );

	$src    = WPC_Utils::get_image( $view_settings['image'] );
	$width  = $config_data->get_width( $uid, $view );
	$height = $config_data->get_height( $uid, $view );
	?>
	<img src="<?php echo esc_url( $src ); ?>" alt="" width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>">
	<?php
}

/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action(
	'shutdown',
	function () {
		while ( @ob_end_flush() );
	}
);
