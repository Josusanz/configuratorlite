<?php
/**
 * Configurator skin shortcode.
 *
 * @package  wp-configurator-pro/includes/shortcodes/
 * @since  2.0
 * @version  3.4.13
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( ! class_exists( 'WPCSE_Config_Skin' ) ) {

	/**
	 * Configurator skin shortcode.
	 */
	class WPCSE_Config_Skin extends WPCSE {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_shortcode( 'wpc_config', array( $this, 'content' ) );
		}

		/**
		 * Content of the shortcode
		 *
		 * @param string $atts Shortcode attributes.
		 * @param string $content Content.
		 * @param string $code Shortcode name.
		 * @return string
		 */
		public function content( $atts = '', $content = '', $code = '' ) {

			$config = parent::initialize_shortcode( $atts, $code );

			// Check it is configurator and it is linked with configurator?
			if ( ! $config ) {
				return;
			}

			ob_start();

			if ( is_array( $this->components ) && count( $this->components ) > 0 ) {

				$wrapper_class                      = array();
				$wrapper_class['configurator-wrap'] = 'wpc-configurator-wrap';
				$wrapper_class['product-wrap']      = 'wpc-single-product-wrap';
				$wrapper_class['style']             = $this->style;

				$wrapper_class = apply_filters( 'wpc_skin_wrapper_classes', $wrapper_class );

				$args = array(
					'wpc'           => $this,
					'wrapper_class' => $wrapper_class,
				);

				if ( in_array( $this->style, array_keys( WPC_Utils::get_default_styles() ) ) ) {
					echo WPC_Utils::get_template_html(
						'skin/' . $this->style . '.php',
						$args
					);
				} else {
					$wrapper_class['style'] = WPC_Utils::simplify_string( $this->style );
					?>
					<div id="wpc-configurator-wrap-<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?>">
						<?php
						/**
						 * Hook: Helps to create custom configurator style.
						 *
						 * * @since 2.2
						 *
						 * @param int  id   Configurator ID.
						 * @param array  atts   Shortcode attributes.
						 */
						do_action( 'wpc_skin_' . WPC_Utils::simplify_string( $this->style ), $this->id, $this->atts );
						?>
					</div> <!-- .wpc-single-product-wrap -->
					<?php
				}
			}

			$output = ob_get_clean();

			return $output;

		}

	}

}

new WPCSE_Config_Skin();
