<?php
/**
 * Include shortcodes.
 *
 * @package  wp-configurator-pro/includes/shortcodes/
 * @version  3.4.8
 */

defined( 'ABSPATH' ) || exit;

defined( 'WPC_VERSION' ) || exit;

// All Skins.
require WPC_SHORTCODES_DIR . 'class-skin-config.php';

// Configurator Elements.
require WPC_SHORTCODES_DIR . 'class-element-price.php';
require WPC_SHORTCODES_DIR . 'class-element-quote-form.php';
require WPC_SHORTCODES_DIR . 'class-element-preview.php';
require WPC_SHORTCODES_DIR . 'class-element-accordion-controls.php';
