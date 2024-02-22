<?php
/**
 * Quote form shortcode.
 *
 * @package  wp-configurator-pro/includes/shortcodes/
 * @since  2.0
 * @version  3.4.13
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

if ( ! class_exists( 'WPCSE_Config_Quote_Form' ) ) {

	/**
	 * Quote form shortcode.
	 */
	class WPCSE_Config_Quote_Form extends WPCSE {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_shortcode( 'wpc_config_quote_form', array( $this, 'content' ) );
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

			$output = '';

			$atts['form'] = 'quote-form'; // It is shortcode compatibility.

			$config = parent::initialize_shortcode( $atts, $code );

			// Check it is configurator and it is linked with configurator?
			if ( ! $config ) {
				return;
			}

			if ( is_array( $this->components ) && count( $this->components ) > 0 ) {
				$output = parent::form_summary();
			}

			return $output;

		}

	}

}

new WPCSE_Config_Quote_Form();
