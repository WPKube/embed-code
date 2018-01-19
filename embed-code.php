<?php
/**
 * Plugin Name: Embed Code
 * Description: The easiest way to embed code in the head or footer of your site, globally or on a per-page/post basis.
 * Version:     2.0.0
 * Author:      Galen Gidman
 * Author URI:  https://galengidman.com/
 * License:     GPL2+
 * Text Domain: embed-code
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EC_VERSION', '2.0.0' );
define( 'EC_FILE',    __FILE__ );
define( 'EC_PATH',    plugin_dir_path( EC_FILE ) );
define( 'EC_URL',     plugin_dir_url( EC_FILE ) );

add_action( 'plugins_loaded', 'ec_load_plugin_textdomain' );

if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	add_action( 'admin_notices', 'ec_fail_php_version' );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.5', '>=' ) ) {
	add_action( 'admin_notices', 'ec_fail_wp_version' );
} else {
	include EC_PATH . 'includes/class-ec-plugin.php';
}

function ec_load_plugin_textdomain() {

	load_plugin_textdomain( 'embed-code' );

}

function ec_fail_php_version() {

	$message = sprintf( esc_html__( 'Embed Code requires PHP version %s+, plugin is currently NOT ACTIVE.', 'embed-code' ), '5.4' );
	$message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );

	echo wp_kses_post( $message );

}

function ec_fail_wp_version() {

	$message = sprintf( esc_html__( 'Embed Code requires WordPress version %s+, plugin is currently NOT ACTIVE.', 'embed-code' ), '4.5' );
	$message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );

	echo wp_kses_post( $message );

}
