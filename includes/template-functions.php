<?php
/**
 * Template functions
 *
 * @package  wp-configurator-pro/includes/
 * @version  3.4.12
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wpc_is_control_allowed' ) ) {

	/**
	 * Returns control item tooltip.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return bool
	 */
	function wpc_is_control_allowed( $uid = '', $wpc = null ) {

		$config_data = $wpc->config[ $wpc->id ];

		$layer_settings = $config_data->get_layer_settings( $uid );

		$all_layer_types = WPC_Utils::get_registered_layer_types();

		$layer_type = $config_data->get_type( $uid );

		/**
		 * Filter: Is the control is allowed to show?.
		 *
		 * * @since 3.2
		 *
		 * @param bool    true Allow control?.
		 * @param string  $uid Layer uid.
		 * @param WPCSE   $wpc WPCSE.
		 */
		return apply_filters( 'wpc_allow_control', true, $uid, $wpc ) &&
			( in_array( $layer_type, $all_layer_types, true ) ) &&
			( ! isset( $layer_settings['hide_control'] ) || ! WPC_Utils::str_to_bool( $layer_settings['hide_control'] ) ) &&
			( ! isset( $layer_settings['layer_initial_state'] ) || ( isset( $layer_settings['layer_initial_state'] ) && 'deactivate' !== $layer_settings['layer_initial_state'] ) ) && ( ! isset( $layer_settings['group_initial_state'] ) || ( isset( $layer_settings['group_initial_state'] ) && 'deactivate' !== $layer_settings['group_initial_state'] ) );
	}
}

if ( ! function_exists( 'wpc_control_item_attr' ) ) {

	/**
	 * Returns control item attributes
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return array
	 */
	function wpc_control_item_attr( $uid = '', $wpc = null ) {

		$config_data = $wpc->config[ $wpc->id ];

		$name           = $config_data->get_name( $uid );
		$type           = $config_data->get_type( $uid );
		$layer_settings = $config_data->get_layer_settings( $uid );

		$control_type = isset( $layer_settings['control_type'] ) ? $layer_settings['control_type'] : 'icon';
		$color        = isset( $layer_settings['color'] ) ? $layer_settings['color'] : '';
		$label        = isset( $layer_settings['label'] ) ? $layer_settings['label'] : $name;
		$custom_class = isset( $layer_settings['custom_class'] ) ? $layer_settings['custom_class'] : '';

		if ( 'color' === $control_type && ! empty( $color ) ) {
			$class[] = 'custom-icon-color';
		}

		$class['selector']     = 'wpc-control-item';
		$class['is-label']     = 'wpc-control-type-' . esc_attr( WPC_Utils::change_case( $control_type ) );
		$class['layer-type']   = 'wpc-layer-type-' . esc_attr( $type );
		$class['icon-type']    = 'wpc-icon-' . esc_attr( $wpc->icon_type );
		$class['icon-size']    = ( ( 20 !== $wpc->icon_width ) || ( 20 !== $wpc->icon_height ) ) ? 'custom-icon-size' : '';
		$class['custom-class'] = ( $custom_class && 'group' !== $type && 'sub_group' !== $type ) ? $custom_class : '';

		if ( $config_data->has_children( $uid ) ) {
			$class['has-children'] = 'wpc-control-has-children';
		}

		/**
		 * Filter: Control item attributes.
		 *
		 * * @since 3.2
		 *
		 * @param array   $attr Attributes.
		 * @param string  $uid Layer uid.
		 * @param array  $config_data Config Data.
		 * @param WPCSE  $wpc WPCSE.
		 */
		$class = apply_filters( 'wpc_control_item_classes', $class, $uid, $config_data, $wpc );

		$attr['class']    = 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
		$attr['selector'] = ( 'group' !== $type && 'sub_group' !== $type ) ? 'data-control' : '';
		$attr['uid']      = 'data-uid="' . esc_attr( $uid ) . '"';
		$attr['text']     = 'data-text="' . esc_attr( $name ) . '"';

		$attr['alpine:click'] = ( 'group' !== $type && 'sub_group' !== $type ) ? 'x-on:click.stop="' . esc_attr( $wpc->store . '.toggleLayer( $el )' ) . '"' : '';
		$attr['alpine:class'] = 'x-bind:class="' . esc_attr( $wpc->store . '.getLayerClasses( "' . $uid . '" )' ) . '"';
		$attr['alpine:init']  = 'x-init="' . esc_attr( $wpc->store . '.watcher( "' . $uid . '" )' ) . '"';

		/**
		 * Filter: Control item attributes.
		 *
		 * * @since 3.2
		 *
		 * @param array   $attr Attributes.
		 * @param string  $uid Layer uid.
		 * @param WPCSE  $wpc WPCSE.
		 */
		$attr = apply_filters( 'wpc_control_item_attr', array_filter( $attr ), $uid, $wpc );

		return $attr;
	}
}

if ( ! function_exists( 'wpc_sub_control_wrapper_attr' ) ) {

	/**
	 * Returns sub group wrapper attributes
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return array
	 */
	function wpc_sub_control_wrapper_attr( $uid = '', $wpc = null ) {

		$config_data = $wpc->config[ $wpc->id ];

		$type           = $config_data->get_type( $uid );
		$layer_settings = $config_data->get_layer_settings( $uid );

		$custom_class = isset( $layer_settings['custom_class'] ) ? $layer_settings['custom_class'] : '';

		$class[]               = 'wpc-control-lists';
		$class[]               = 'wpc-sub-control';
		$class['custom-class'] = ( $custom_class ) ? $custom_class : '';

		/**
		 * Filter: Sub group wrapper classes.
		 *
		 * * @since 3.3
		 *
		 * @param array   $class Classes.
		 * @param string  $uid Layer uid.
		 * @param WPCSE  $wpc WPCSE.
		 */
		$class = apply_filters( 'wpc_sub_control_wrapper_classes', array_filter( $class ), $uid, $wpc );

		$attr['class']        = 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
		$attr['parent-uid']   = 'data-parent-uid="' . esc_attr( $uid ) . '"';
		$attr['alpine:class'] = 'x-bind:class="' . esc_attr( $wpc->store . '.getGroupLayerClasses( "' . $uid . '" )' ) . '"';
		$attr['alpine:init']  = 'x-init="' . esc_attr( $wpc->store . '.watcher( "' . $uid . '" )' ) . '"';

		/**
		 * Filter: Sub group wrapper attributes.
		 *
		 * * @since 3.3
		 *
		 * @param array   $class Classes.
		 * @param string  $uid Layer uid.
		 * @param WPCSE  $wpc WPCSE.
		 */
		$attr = apply_filters( 'wpc_sub_control_wrapper_attr', array_filter( $attr ), $uid, $wpc );

		return $attr;
	}
}

if ( ! function_exists( 'wpc_control_description' ) ) {

	/**
	 * Returns control description.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_description( $uid = '', $wpc = null ) {
		echo wp_kses( wpc_get_control_description( $uid, $wpc ), WPC_Utils::allowed_tags( array( 'template', 'div', 'p', 'span' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_control_description' ) ) {

	/**
	 * Returns control description.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_control_description( $uid = '', $wpc = null ) {
		$config_data = $wpc->config[ $wpc->id ];

		$description = $config_data->get_description( $uid );

		$description_html = ( $description ) ? '<p class="wpc-layer-description">' . wp_kses( $description, WPC_Utils::allowed_tags( array( 'template', 'div', 'p', 'span' ) ) ) . '</p>' : '';

		return apply_filters(
			'wpc_layer_description',
			sprintf(
				'%1$s',
				$description_html
			),
			$description_html,
			$uid,
			$wpc
		);
	}
}

if ( ! function_exists( 'wpc_get_control_group_name' ) ) {

	/**
	 * Returns control item tooltip.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_control_group_name( $uid = '', $wpc = null ) {

		$config_data = $wpc->config[ $wpc->id ];

		$name           = $config_data->get_name( $uid );
		$type           = $config_data->get_type( $uid );
		$layer_settings = $config_data->get_layer_settings( $uid );

		$description = $config_data->get_description( $uid );

		$description_html = '';
		$tooltip_html     = '';

		if ( $description && apply_filters( 'wpc_layer_description_as_tooltip', false, $uid, $wpc ) ) {
			$tooltip_html .= '<div class="wpc-layer-title-desc-wrap">';
			$tooltip_html .= '<span class="wpc-layer-title-desc-icon js-wpc-description-tooltip-trigger">';
			$tooltip_html .= '<span class="wpc-icon ' . esc_attr( WPC_Utils::icon( 'help' ) ) . '"></span>';
			$tooltip_html .= '</span>';
			$tooltip_html .= '<span class="wpc-layer-description">';
			$tooltip_html .= wp_kses( $description, WPC_Utils::allowed_tags( array( 'span', 'a' ) ) );
			$tooltip_html .= '</span>';
			$tooltip_html .= '</div>';
		} else {
			$description_html = ( $description ) ? '<p class="wpc-layer-description">' . wp_kses( $description, WPC_Utils::allowed_tags( array( 'span', 'a' ) ) ) . '</p>' : '';
		}

		$icon = isset( $layer_settings['icon'] ) ? $layer_settings['icon'] : 0;

		if ( 'group' === $type ) {
			$icon_width  = (int) get_option( 'wpc_group_icon_width', '40' );
			$icon_height = (int) get_option( 'wpc_group_icon_height', '40' );

			$icon_width  = apply_filters( 'wpc_' . $wpc->style . '_group_icon_width', $icon_width );
			$icon_height = apply_filters( 'wpc_' . $wpc->style . '_group_icon_height', $icon_height );
		} else {
			$icon_width  = (int) get_option( 'wpc_sub_group_icon_width', '40' );
			$icon_height = (int) get_option( 'wpc_sub_group_icon_height', '40' );

			$icon_width  = apply_filters( 'wpc_' . $wpc->style . '_sub_group_icon_width', $icon_width );
			$icon_height = apply_filters( 'wpc_' . $wpc->style . '_sub_group_icon_height', $icon_height );
		}

		$class[] = 'wpc-layer-title';

		$h2_attr['class'] = 'class="' . esc_attr( implode( ' ', $class ) ) . '"';

		$wrap_attr['uid']          = 'data-uid="' . esc_attr( $uid ) . '"';
		$wrap_attr['alpine:click'] = ( 'group' === $type || 'sub_group' === $type ) ? 'x-on:click.stop="' . esc_attr( $wpc->store . '.toggleGroup( "' . $uid . '", $el )' ) . '"' : '';
		$wrap_attr['alpine:class'] = 'x-bind:class="' . esc_attr( $wpc->store . '.getGroupLayerClasses( "' . $uid . '" )' ) . '"';

		/**
		 * Filter: Group name attributes.
		 *
		 * * @since 3.3
		 *
		 * @param array   $wrap_attr Attributes.
		 * @param string  $uid Layer uid.
		 * @param WPCSE  $wpc WPCSE.
		 */
		$wrap_attr = apply_filters( 'wpc_group_name_attr', array_filter( $wrap_attr ), $uid, $wpc );

		$icon      = ( $icon ) ? WPC_Utils::get_image( $icon, false, (int) $icon_width, (int) $icon_height ) : '';
		$icon_html = ( $icon ) ? sprintf( '<span class="wpc-layer-img">%s</span>', $icon ) : '';

		$active_layer_names = apply_filters( 'wpc_show_active_layer_names', false, $uid, $wpc );

		$active_layer_name_html = ( $active_layer_names ) ? wpc_get_active_layer_name( $uid, $wpc ) : '';

		$active_layer_icons = apply_filters( 'wpc_show_active_layer_icons', false, $uid, $wpc );

		$active_layer_icons_html = ( $active_layer_icons ) ? wpc_get_active_layer_icons( $uid, $wpc ) : '';

		return apply_filters(
			'wpc_group_name',
			sprintf(
				'<div class="wpc-layer-title-wrap" %1$s>
                    %2$s
                    <div class="wpc-layer-title-inner">
                        <h2 %3$s>
                            <span class="wpc-layer-title-text">%4$s</span>
                            %5$s
                        </h2>
                        %6$s
                        %7$s
                    </div>
                    %8$s
                </div>',
				implode( ' ', $wrap_attr ),
				$icon_html,
				implode( ' ', $h2_attr ),
				esc_html( $name ),
				$tooltip_html,
				$description_html,
				$active_layer_name_html,
				$active_layer_icons_html
			),
			$wrap_attr,
			$h2_attr,
			$icon_html,
			$tooltip_html,
			$description_html,
			$active_layer_name_html,
			$active_layer_icons_html,
			$uid,
			$wpc
		);
	}
}

if ( ! function_exists( 'wpc_control_group_name' ) ) {

	/**
	 * Returns control item tooltip.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_group_name( $uid = '', $wpc = null ) {
		echo wp_kses( wpc_get_control_group_name( $uid, $wpc ), WPC_Utils::allowed_tags( array( 'template', 'div', 'h2', 'p', 'span', 'img' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_control_info_image' ) ) {

	/**
	 * Returns control info image.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_control_info_image( $uid = '', $wpc = null ) {

		$config_data = $wpc->config[ $wpc->id ];

		$layer_settings = $config_data->get_layer_settings( $uid );

		$info_image = isset( $layer_settings['info_image'] ) ? $layer_settings['info_image'] : 0;

		$icon      = ( $info_image ) ? WPC_Utils::get_image( $info_image, false ) : '';
		$icon_html = ( $icon ) ? sprintf( '<span class="wpc-layer-img">%s</span>', $icon ) : '';

		return sprintf(
			'%s',
			$icon_html
		);
	}
}

if ( ! function_exists( 'wpc_control_info_image' ) ) {

	/**
	 * Returns control info image.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_info_image( $uid = '', $wpc = null ) {
		echo wp_kses( wpc_get_control_info_image( $uid, $wpc ), WPC_Utils::allowed_tags( array( 'span', 'img' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_control_name' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_control_name( $uid = '', $wpc = null ) {

		$config_data = $wpc->config[ $wpc->id ];

		$name = $config_data->get_name( $uid );

		return sprintf(
			'<span class="wpc-layer-name">%s</span>',
			esc_html( $name )
		);
	}
}

if ( ! function_exists( 'wpc_control_name' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_name( $uid = '', $wpc = null ) {
		echo wp_kses( wpc_get_control_name( $uid, $wpc ), WPC_Utils::allowed_tags( array( 'span' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_control_info_popup' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_control_info_popup( $wpc = null ) {
		return '<template x-if="' . $wpc->store . '.hasCurrentSelectionUid()">
			<div x-data class="wpc-control-info-popup" x-bind:class="{ active : ' . $wpc->store . '.hasCurrentSelectionUid() }">
				<span class="wpc-control-close-detail-info ' . WPC_Utils::icon( 'close' ) . '" x-on:click.stop="' . $wpc->store . '.setCurrentSelectionUid()"></span>
				<div class="wpc-control-info-popup-inner">
					<span class="wpc-layer-img" x-show="' . $wpc->store . '.hasLayerInfoImage( ' . $wpc->store . '.currentSelectionUid )"><img x-bind:src="' . esc_attr( $wpc->store . '.getLayerInfoImage( ' . $wpc->store . '.currentSelectionUid )' ) . '"></span>
					<span class="wpc-layer-name" x-text="' . esc_attr( $wpc->store . '.getLayerName( ' . $wpc->store . '.currentSelectionUid )' ) . '"></span>
					<p class="wpc-layer-description" x-show="' . $wpc->store . '.hasLayerDescription( ' . $wpc->store . '.currentSelectionUid )" x-text="' . esc_attr( $wpc->store . '.getLayerDescription( ' . $wpc->store . '.currentSelectionUid )' ) . '"></p>
				</div>
			</div>
		</template>';
	}
}

if ( ! function_exists( 'wpc_control_info_popup' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_info_popup( $wpc = null ) {
		echo wp_kses( wpc_get_control_info_popup( $wpc ), WPC_Utils::allowed_tags( array( 'template', 'div', 'p', 'span', 'img' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_price_html' ) ) {

	/**
	 * Returns control item price html.
	 *
	 * @param string $layer_settings Layer settings.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_price_html( $layer_settings = array(), $wpc = null ) {

		$price      = isset( $layer_settings['price'] ) ? $layer_settings['price'] : 0;
		$sale_price = isset( $layer_settings['sale_price'] ) ? $layer_settings['sale_price'] : 0;

		$build_price      = WPC_Utils::price( $price );
		$build_sale_price = WPC_Utils::price( $sale_price );

		$build_price_html = ( $price > $sale_price || ! $sale_price ) ? wp_kses(
			$build_price,
			array(
				'span' => array( 'class' => array() ),
				'bdi'  => array(),
			)
		) : '';

		$build_sale_price_html = $sale_price ? wp_kses(
			$build_sale_price,
			array(
				'span' => array( 'class' => array() ),
				'bdi'  => array(),
			)
		) : '';

		if (
			( ! $wpc->price_details || WPC_Utils::str_to_bool( $wpc->price_details ) ) &&
			( ! WPC_Utils::str_to_bool( $wpc->remove_price_is_empty ) ||
			( WPC_Utils::str_to_bool( $wpc->remove_price_is_empty ) && ! empty( $price ) ) )
		) {

			return sprintf(
				'<span class="wpc-hover-price">
				<span class="%1$s"></span>
				%2$s
				%3$s
				</span>',
				esc_attr( WPC_Utils::icon( 'plus' ) ),
				$build_price_html,
				$build_sale_price_html
			);
		}

		return false;
	}
}

if ( ! function_exists( 'wpc_price_html' ) ) {

	/**
	 * Returns control item tooltip.
	 *
	 * @param array $layer_settings Layer settings.
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_price_html( $layer_settings = array(), $wpc = null ) {
		echo wp_kses( wpc_get_price_html( $layer_settings, $wpc ), WPC_Utils::allowed_tags( array( 'h2', 'span', 'img' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_control_info' ) ) {

	/**
	 * Returns control item tooltip.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_control_info( $uid = '', $wpc = null ) {

		$config_data = $wpc->config[ $wpc->id ];

		$name           = $config_data->get_name( $uid );
		$layer_settings = $config_data->get_layer_settings( $uid );

		$price        = isset( $layer_settings['price'] ) ? $layer_settings['price'] : 0;
		$control_type = isset( $layer_settings['control_type'] ) ? $layer_settings['control_type'] : 'icon';

		$build_price = WPC_Utils::price( $price );

		if ( 'label' !== $control_type ) {
			return apply_filters(
				'wpc_control_item_info',
				sprintf(
					'<p class="wpc-control-item-info">
						<span class="wpc-control-item-info-inner">
							<span class="wpc-control-item-name">%2$s</span>
							%1$s
						</span>
					</p>',
					wpc_get_price_html( $layer_settings, $wpc ),
					esc_html( $name )
				),
				$uid,
				$wpc
			);
		}

		return false;
	}
}

if ( ! function_exists( 'wpc_control_info' ) ) {

	/**
	 * Returns control item info.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_info( $uid = '', $wpc = null ) {
		echo wp_kses( wpc_get_control_info( $uid, $wpc ), WPC_Utils::allowed_tags( array( 'div', 'p', 'span', 'bdi' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_control_item_icon' ) ) {

	/**
	 * Returns control item info.
	 *
	 * @param string   $uid Layer uid.
	 * @param WPC_Data $config_data Configurator data.
	 * @param WPCSE    $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_get_control_item_icon( $uid = '', $config_data = null, $wpc = null ) {

		$name           = $config_data->get_name( $uid );
		$layer_settings = $config_data->get_layer_settings( $uid );

		$control_type = isset( $layer_settings['control_type'] ) ? $layer_settings['control_type'] : 'icon';
		$color        = isset( $layer_settings['color'] ) && ! empty( $layer_settings['color'] ) ? $layer_settings['color'] : '';
		$icon         = isset( $layer_settings['icon'] ) ? $layer_settings['icon'] : 0;
		$label        = isset( $layer_settings['label'] ) ? $layer_settings['label'] : $name;

		$icon_width  = (int) get_option( 'wpc_icon_width', '20' );
		$icon_height = (int) get_option( 'wpc_icon_height', '20' );

		$icon_width  = apply_filters( 'wpc_' . $wpc->style . '_control_item_icon_width', $icon_width );
		$icon_height = apply_filters( 'wpc_' . $wpc->style . '_control_item_icon_height', $icon_height );

		ob_start();

		/**
		 * Hook: Before control item icon html.
		 *
		 * * @since 3.3
		 *
		 * @param string $uid Layer uid.
		 * @param object $wpc WPCSE.
		 */
		do_action( 'wpc_before_control_item_icon', $uid, $wpc );

		if ( 'label' === $control_type && ! empty( $label ) ) {
			?>
			<p class="wpc-control-item-label">
				<span class="wpc-icon-label-inner">	
					<?php
					if ( ! empty( $icon ) ) {
						$icon_html = ( $icon ) ? WPC_Utils::get_image( $icon, false, (int) $icon_width, (int) $icon_height, false, array( 'wpc-control-item-icon' ) ) : '';
						?>
						<span class="wpc-control-item-icon-wrap">
							<?php echo wp_kses( $icon_html, WPC_Utils::allowed_tags( array( 'img' ) ) ); ?>
						</span>
						<?php
					} elseif ( ! empty( $color ) ) {
						?>
						<span class="wpc-control-item-icon-wrap">
							<span class="wpc-control-item-color"></span>
						</span>
						<?php
					}
					?>
					<span class="wpc-icon-label">
						<span class="wpc-control-item-name"><?php echo esc_html( $label ); ?></span>
						<?php echo wpc_get_price_html( $layer_settings, $wpc ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>	
				</span>
			</p>
			<?php
		} elseif ( 'color' === $control_type && ! empty( $color ) ) {
			?>
			<div class="wpc-control-item-color"></div>
			<?php
		} elseif ( 'icon' === $control_type && ! empty( $icon ) ) {

			$icon_html = ( $icon ) ? WPC_Utils::get_image( $icon, false, (int) $icon_width, (int) $icon_height, false, array( 'wpc-control-item-icon' ) ) : '';

			echo wp_kses( $icon_html, WPC_Utils::allowed_tags( array( 'img' ) ) );
		} elseif ( 'inline_text' === $control_type && ! empty( $label ) ) {
			?>
			<p class="wpc-icon-label">
				<span class="wpc-control-item-name"><?php echo esc_html( $label ); ?></span>
			</p>
			<?php
		}

		/**
		 * Hook: After control item icon html.
		 *
		 * * @since 3.3
		 *
		 * @param string $uid Layer uid.
		 * @param object $wpc WPCSE.
		 */
		do_action( 'wpc_after_control_item_icon', $uid, $wpc );

		$html = ob_get_clean();

		return $html;
	}
}

if ( ! function_exists( 'wpc_control_item_icon' ) ) {

	/**
	 * Returns control item icon.
	 *
	 * @param string $uid Layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_item_icon( $uid = '', $wpc = null ) {

		$config_data = $wpc->config[ $wpc->id ];

		echo wp_kses( wpc_get_control_item_icon( $uid, $config_data, $wpc ), WPC_Utils::allowed_tags( array( 'div', 'p', 'span', 'img', 'bdi' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_active_layer_name' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param string $parent_uid Parent layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_active_layer_name( $parent_uid = '', $wpc = null ) {

		$html  = '<template x-for="uid in ' . esc_attr( $wpc->store . '.getActiveUids("' . $parent_uid . '")' ) . '">';
		$html .= '<span class="wpc-active-layer-name" x-text="' . esc_attr( $wpc->store . '.getLayerName(uid)' ) . '"></span>';
		$html .= '</template>';

		return $html;
	}
}

if ( ! function_exists( 'wpc_active_layer_name' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param string $parent_uid Parent layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_active_layer_name( $parent_uid = '', $wpc = null ) {
		echo wp_kses( wpc_get_active_layer_name( $parent_uid, $wpc ), WPC_Utils::allowed_tags( array( 'template', 'span' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_active_layer_icons' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param string $parent_uid Parent layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_active_layer_icons( $parent_uid = '', $wpc = null ) {

		$html  = '<div class="wpc-active-layer-icons" x-show="' . esc_attr( $wpc->store . '.hasActiveUids("' . $parent_uid . '")' ) . '">';
		$html .= '<template x-for="uid in ' . esc_attr( $wpc->store . '.getActiveUids("' . $parent_uid . '")' ) . '">';
		$html .= '<template x-if="' . esc_attr( $wpc->store . '.isControlType(uid, "icon")' ) . ' || ' . esc_attr( $wpc->store . '.isControlType(uid, "color")' ) . '">';
		$html .= '<div class="wpc-active-layer-icon">';
		$html .= '<template x-if="' . esc_attr( $wpc->store . '.isControlType(uid, "icon")' ) . '&& ' . esc_attr( $wpc->store . '.getLayerIcon(uid)' ) . '">';
		$html .= '<img class="custom-icon-img" x-bind:src="' . esc_attr( $wpc->store . '.getLayerIcon(uid)' ) . '">';
		$html .= '</template>';
		$html .= '<template x-if="' . esc_attr( $wpc->store . '.isControlType(uid, "color")' ) . '">';
		$html .= '<div class="custom-icon-color" x-bind:data-uid="uid"><div class="wpc-control-item-color"></div></div>';
		$html .= '</template>';
		$html .= '</div>';
		$html .= '</template>';
		$html .= '</template>';
		$html .= '</div>';

		return apply_filters( 'wpc_active_layer_icons_html', $html, $parent_uid, $wpc );
	}
}

if ( ! function_exists( 'wpc_active_layer_icons' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param string $parent_uid Parent layer uid.
	 * @param WPCSE  $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_active_layer_icons( $parent_uid = '', $wpc = null ) {
		echo wp_kses( wpc_get_active_layer_icons( $parent_uid, $wpc ), WPC_Utils::allowed_tags( array( 'template', 'div', 'img', 'span' ) ) );
	}
}

if ( ! function_exists( 'wpc_control_item_filter' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_control_item_filter( $wpc = null ) {
		$html  = '<template x-if="' . esc_attr( $wpc->store . '.hasFilter()' ) . '">';
		$html .= '<div class="wpc-control-item-filter">';
		$html .= '<template x-for="item in ' . esc_attr( $wpc->store . '.filter' ) . '">';
		$html .= '<span x-text="item" x-on:click="' . esc_attr( $wpc->store . ' . filterItem( item )' ) . '"><span>';
		$html .= '</template>';
		$html .= '</div>';
		$html .= '</template>';

		return $html;
	}
}

if ( ! function_exists( 'wpc_control_filter' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_filter( $wpc = null ) {
		echo wp_kses( wpc_control_item_filter( $wpc ), WPC_Utils::allowed_tags( array( 'template', 'div', 'span' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_control_breadcrumbs' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_control_breadcrumbs( $wpc = null ) {
		$html  = '<div class="wpc-control-item-breadcrumbs">';
		$html .= '<template x-for="uid in ' . esc_attr( $wpc->store . ' . breadcrumbs' ) . '">';
		$html .= '<span x-text="' . esc_attr( $wpc->store . '.getLayerName(uid)' ) . '" x-on:click="' . esc_attr( $wpc->store . '.openGroup(uid, $el)' ) . '"><span>';
		$html .= '</template>';
		$html .= '</div>';

		return $html;
	}
}

if ( ! function_exists( 'wpc_control_breadcrumbs' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_breadcrumbs( $wpc = null ) {
		echo wp_kses( wpc_get_control_breadcrumbs( $wpc ), WPC_Utils::allowed_tags( array( 'template', 'div', 'span' ) ) );
	}
}

if ( ! function_exists( 'wpc_get_control_next_previous' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return string
	 */
	function wpc_get_control_next_previous( $wpc = null ) {
		$html  = '<template x-if="' . esc_attr( $wpc->store . '.hasOpenedGroupTopUid()' ) . '">';
		$html .= '<div class="wpc-control-next-previous">';

		$html .= '<span class="wpc-control-previous" x-on:click="' . esc_attr( $wpc->store . '.openGroup( ' . $wpc->store . '.prevGroupUid, $el)' ) . '">';
		$html .= '<span class="wpc-icon ' . esc_attr( apply_filters( 'wpc_control_previous_icon', WPC_Utils::icon( 'arrow-left' ), $wpc ) ) . '"></span>';
		$html .= '<span x-text="' . esc_attr( $wpc->store . '.getLayerName( ' . $wpc->store . '.prevGroupUid, $el)' ) . '"></span>';
		$html .= '</span>';

		$html .= '<span class="wpc-current-group-navigation">';
		$html .= '<span class="wpc-current-group-title" x-text="' . esc_attr( $wpc->store . '.getLayerName( ' . $wpc->store . '.currentOpenedGroupTopUid, $el)' ) . '"></span>';
		$html .= '<span class="wpc-group-navigation-indexes">';
		$html .= '<span class="wpc-current-group-index" x-text="' . esc_attr( $wpc->store . '.currentOpenedGroupTopIndex+1' ) . '"></span>';
		$html .= '<span class="wpc-total-groups-count" x-text="' . esc_attr( $wpc->store . '.topLayers.length' ) . '"></span>';
		$html .= '</span>';
		$html .= '</span>';

		$html .= '<span class="wpc-control-next" x-on:click="' . esc_attr( $wpc->store . '.openGroup( ' . $wpc->store . '.nextGroupUid, $el)' ) . '">';
		$html .= '<span x-text="' . esc_attr( $wpc->store . '.getLayerName( ' . $wpc->store . '.nextGroupUid, $el)' ) . '"></span>';
		$html .= '<span class="wpc-icon ' . esc_attr( apply_filters( 'wpc_control_next_icon', WPC_Utils::icon( 'arrow-right' ), $wpc ) ) . '"></span>';
		$html .= '</span>';

		$html .= '</div>';
		$html .= '</template>';

		return $html;
	}
}

if ( ! function_exists( 'wpc_control_next_previous' ) ) {

	/**
	 * Returns control name.
	 *
	 * @param WPCSE $wpc Core configurator shortcode.
	 * @return void
	 */
	function wpc_control_next_previous( $wpc = null ) {
		echo wp_kses( wpc_get_control_next_previous( $wpc ), WPC_Utils::allowed_tags( array( 'template', 'div', 'span' ) ) );
	}
}
