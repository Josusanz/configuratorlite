<?php
/**
 * Frontend configurations.
 *
 * @package  wp-configurator-pro/includes/frontend/
 * @since  2.0
 * @version  3.5.4
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

/*
 * Initialize class
 */
if ( ! class_exists( 'WPC_Frontend_Config' ) ) {

	/**
	 * Frontend configuration.
	 */
	class WPC_Frontend_Config {

		/**
		 * Constructor.
		 */
		public function __construct() {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_head', array( $this, 'print_meta_tags' ), 0 );
			add_action( 'wp_head', array( $this, 'custom_css' ) );
			add_filter( 'body_class', array( $this, 'body_class' ) );
			add_filter( 'wp_robots', array( $this, 'robots_noindex' ) );

			if ( function_exists( 'wpcf7_recaptcha_enqueue_scripts' ) ) {
				add_action(
					'wp_enqueue_scripts',
					'wpcf7_recaptcha_enqueue_scripts',
					20,
					0
				);
			}

			// If it's full window style, remove the unneccesary styles.
			add_action( 'wp_print_styles', array( $this, 'remove_all_styles' ), 100 );
		}

		public function remove_all_styles() {

			if ( WPC_Utils::is_full_window_style() ) {

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
		 * Register CSS and Scripts.
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			$font_weight = get_option( 'wpc_font_weight', array( '400', '600' ) );

			$primary_font   = get_option( 'wpc_primary_font', 'inherit' );
			$secondary_font = get_option( 'wpc_secondary_font', 'inherit' );

			if ( ! WPC_Utils::is_full_window_style() ) {
				$fonts[] = $primary_font;
				$fonts[] = $secondary_font;
			} else {
				$fonts[] = ( 'inherit' === $primary_font ) || empty( $primary_font ) ? 'Nunito' : $primary_font;
				$fonts[] = ( 'inherit' === $secondary_font ) || empty( $secondary_font ) ? 'Nunito' : $secondary_font;
			}

			$fonts = array_unique( $fonts );

			foreach ( $fonts as $key => $font ) {
				if ( 'inherit' !== $font ) {
					$family[ $key ] = $font . ':' . implode( ',', $font_weight );
				}
			}

			// Load Google Font.
			if ( ! empty( $family ) ) {
				$font_url = add_query_arg(
					array(
						'family' => implode( '|', $family ),
					),
					'https://fonts.googleapis.com/css'
				);

				wp_register_style( 'wpc-google-fonts', esc_url( $font_url ), array(), '1.0' );
			}

			wp_enqueue_style( 'wpc-general', WPC_ASSETS_URL . 'frontend/css/general.css', array(), '3.5.4' );

			// Load CSS.
			wp_enqueue_style( 'wpc-icon', WPC_ASSETS_URL . 'icon/wpc-icon.css', array(), '3.5' );
			wp_enqueue_style( 'wpc-frontend', WPC_ASSETS_URL . 'frontend/css/frontend.css', array(), '3.4.4' );
			wp_register_style( 'wpc-carousel', WPC_ASSETS_URL . 'frontend/css/wpc-carousel.css', array(), '2.3' );

			if ( is_rtl() ) {
				wp_register_style( 'wpc-rtl', WPC_ASSETS_URL . 'frontend/css/rtl.css', array(), '3.4' );
			}

			// Load Scripts.
			wp_enqueue_script( 'wpc-common-script', WPC_ASSETS_URL . 'frontend/js/common.js', array( 'jquery', 'imagesloaded' ), '3.5.3', true );
			wp_register_script( 'wpc-carousel', WPC_ASSETS_URL . 'frontend/js/wpc-carousel.min.js', array(), '2.3', true );
			wp_register_script( 'wpc-html2canvas', WPC_ASSETS_URL . 'frontend/js/wpc-html2canvas.min.js', array( 'jquery' ), '2.1.1', true );
			wp_register_script( 'jquery-base64', WPC_ASSETS_URL . 'frontend/js/jquery.base64.min.js', array( 'jquery' ), '2.0', true );
			wp_register_script( 'accounting', WPC_ASSETS_URL . 'frontend/js/accounting.min.js', array( 'jquery' ), '0.4.2', true );
			wp_register_script( 'wpc-utils', WPC_ASSETS_URL . 'frontend/js/utils.js', array( 'jquery' ), '3.5.3', true );

			$script_url = ( WPC_DEV_MODE ) ? '//localhost:5000/frontend-script.js' : WPC_ASSETS_URL . 'frontend/js/frontend-script.min.js';

			wp_register_script( 'wpc-frontend-script', $script_url, array( 'jquery', 'wpc-utils' ), '3.5.3', true );

			$lib = array(
				'symbol'    => WPC_Utils::get_currency_symbol(),
				'format'    => str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), WPC_Utils::price_format() ),
				'decimal'   => WPC_Utils::price_decimal_separator(),
				'thousand'  => WPC_Utils::price_thousand_separator(),
				'precision' => WPC_Utils::get_price_decimals(),
			);

			wp_localize_script( 'wpc-utils', 'wpc_lib', $lib );

			wp_localize_script(
				'wpc-common-script',
				'wpc_i18n',
				apply_filters(
					'wpc_i18n_texts',
					array(
						'base_price_text'                  => get_option( 'wpc_base_price_text', esc_html__( 'Base Price', 'wp-configurator-pro' ) ),
						'select_btn_text'                  => esc_html__( 'Select', 'wp-configurator-pro' ),
						'total_price_text'                 => get_option( 'wpc_total_price_text', esc_html__( 'Expected Total', 'wp-configurator-pro' ) ),
						'confirm_delete_inspiration'       => esc_html__( 'Are you sure? Do you want to remove this inspiration?', 'wp-configurator-pro' ),
						'confirm_reset_inspiration'        => esc_html__( 'Are you sure? Do you want to override the inspiration?', 'wp-configurator-pro' ),
						'confirm_delete_inspiration_group' => esc_html__( 'Are you sure? Do you want to remove the inspiration group?', 'wp-configurator-pro' ),
					)
				)
			);

			add_filter( 'script_loader_tag', array( $this, 'add_type_attribute' ), 10, 3 );

		}

		public function add_type_attribute( $tag, $handle, $src ) {

			// if not your script, do nothing and return original $tag.
			if ( 'wpc-frontend-script' !== $handle && 'wpc-vendor' !== $handle ) {
				return $tag;
			}

			$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';

			return $tag;

		}

		public function print_meta_tags() {
			if ( WPC_Utils::is_full_window_style() ) {
				echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";
			}
		}

		/**
		 * Prints scripts or data in the head tag on the front end.
		 */
		public function custom_css() {
			?>
			<style type="text/css">
				<?php
				require WPC_INCLUDE_DIR . 'frontend/css-variables.php';
				?>
			</style>
			<?php
			$custom_css = get_option( 'wpc_custom_css' );
			if ( $custom_css ) :
				?>
				<style type="text/css">
					<?php echo wp_strip_all_tags( $custom_css ); ?>
				</style>
				<?php
			endif;
		}

		/**
		 * Filters the list of CSS body class names for the current post or page.
		 *
		 * @param array $classes An array of body class names.
		 * @return array
		 */
		public function body_class( $classes = array() ) {

			$classes[] = 'wpc-' . WPC_VERSION;

			$classes[] = 'wpc-config-loading';

			$style = WPC_Utils::get_style();

			$classes[] = esc_attr( 'wpc-' . $style );

			if ( WPC_Utils::is_full_window_style() ) {
				$classes[] = esc_attr( 'wpc-full-window-style' );
			}

			$classes[] = isset( $_GET['configure'] ) ? 'wpc-configure-clicked' : 'wpc-configure-not-clicked';

			$meta_pixel = WPC_Utils::str_to_bool( get_option( 'wpc_meta_pixel', 'disable' ) );

			$classes[] = ( $meta_pixel ) ? 'wpc-meta-pixel-enabled' : '';

			return $classes;
		}

		/**
		 * Add no follow meta tag in tag for user config singular post.
		 *
		 * @param array $robots Embed meta attributes.
		 * @return array
		 */
		public function robots_noindex( array $robots ) {
			if ( is_singular( 'wpc_user_config' ) ) {
				return wp_robots_no_robots( $robots );
			}

			return $robots;
		}

	}

	$GLOBALS['wpc_frontend_config'] = new WPC_Frontend_Config();

}
