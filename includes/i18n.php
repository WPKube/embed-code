<?php
/**
 * Internationalization
 */

function ec_load_textdomain() {

	load_plugin_textdomain( 'embed-code', false, EC_PATH . 'languages' );

}
add_action( 'plugins_loaded', 'ec_load_textdomain' );
