<?php
/**
 * Plugin Name: Embed Code
 * Plugin URI:  https://github.com/galengidman/embed-code
 * Description: The easiest way embed code in the head or footer of your site, globally or on a per-page/post basis.
 * Author:      Galen Gidman
 * Author URI:  http://galengidman.com/
 * Version:     1.1.1
 * Text Domain: embed-code
 * Domain Path: /languages
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin constants.
 */
if ( ! defined( 'EC_VERSION' ) ) define( 'EC_VERSION', '1.1.1' );
if ( ! defined( 'EC_PATH' ) )    define( 'EC_PATH',    plugin_dir_path( __FILE__ ) );
if ( ! defined( 'EC_URL' ) )     define( 'EC_URL',     esc_url( plugin_dir_url( __FILE__ ) ) );

/**
 * Includes.
 */
require_once EC_PATH . 'includes/i18n.php';
require_once EC_PATH . 'includes/output.php';

/**
 * Admin includes.
 */
if ( is_admin() ) {
	require_once EC_PATH . 'includes/admin/meta-box.php';
	require_once EC_PATH . 'includes/admin/options.php';
	require_once EC_PATH . 'includes/admin/post-meta.php';
}
