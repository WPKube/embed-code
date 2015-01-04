<?php
/*
Plugin Name: Embed Code
Plugin URI:  http://galengidman.com/plugins/embed-code/
Description: Easiest way embed code in the head or footer of your site. Can be used for Google Analytics, other tracking code, favicons, meta tags, or any 3rd-party embed code.
Author:      Galen Gidman
Author URI:  http://galengidman.com/
Version:     1.0
*/

/**
 * Registers the options page.
 */
function ec_admin_add_page() {

  add_options_page( __( 'Embed Code', 'embed-code' ), __( 'Embed Code', 'embed_code' ), 'manage_options', 'embed-code', 'ec_options_page' );

}
add_action( 'admin_menu', 'ec_admin_add_page' );

/**
 * Registers setting, setting groups, and setting fields.
 */
function ec_admin_init() {

  // Register setting
  register_setting( 'ec_options', 'ec_options' );

  // Register settings sections
  add_settings_section( 'ec_head', __( 'Head Code', 'embed-code' ), 'ec_head_callback', 'embed-code' );
  add_settings_section( 'ec_footer', __( 'Footer Code', 'embed-code' ), 'ec_footer_callback', 'embed-code' );

  // Register settings fields
  add_settings_field( 'ec_head_code', __( 'Embed Code', 'embed-code' ), 'ec_head_code_callback', 'embed-code', 'ec_head' );
  add_settings_field( 'ec_footer_code', __( 'Embed Code', 'embed-code' ), 'ec_footer_code_callback', 'embed-code', 'ec_footer' );

}
add_action( 'admin_init', 'ec_admin_init' );

/**
 * Displays the description for the Head Code settings section.
 */
function ec_head_callback() {

  $desc = __( 'Will be inserted just before the <code>&lt;/head&gt;</code> tag.', 'embed-code' );

  echo "<p>$desc</p>";

}

/**
 * Displays the description for the Footer Code settings section.
 */
function ec_footer_callback() {

  $desc = __( 'Will be inserted just before the <code>&lt;/body&gt;</code> tag.', 'embed-code' );

  echo "<p>$desc</p>";

}

/**
 * Displays the Head Code field.
 */
function ec_head_code_callback() {

  $options = get_option( 'ec_options' );

?>

  <textarea id="<?php echo $ec_head_code; ?>" name="ec_options[ec_head_code]" class="large-text code" rows="8" placeholder="<?php _e( 'Paste code here&hellip;', 'embed-code' ); ?>"><?php echo esc_textarea( $options['ec_head_code'] ) ?></textarea>

<?php

}

/**
 * Displays the Footer Code field.
 */
function ec_footer_code_callback() {

  $options = get_option( 'ec_options' );

?>

  <textarea id="<?php echo $ec_footer_code; ?>" name="ec_options[ec_footer_code]" class="large-text code" rows="8" placeholder="<?php _e( 'Paste code here&hellip;', 'embed-code' ); ?>"><?php echo esc_textarea( $options['ec_footer_code'] ) ?></textarea>

<?php

}

/**
 * Displays the options page.
 */
function ec_options_page() {

  $message = sprintf( __( 'If you&rsquo;ve found this plugin useful, please consider <a href="%s" target="_blank">leaving a review</a>', 'embed-code' ), 'http://wordpress.org/plugins/embed-code/' );

?>

  <div class="wrap">
    <h2><?php _e( 'Embed Code', 'embed-code' ); ?></h2>

    <form action="options.php" method="post">
      <?php

      settings_fields( 'ec_options' );
      do_settings_sections( 'embed-code' );
      submit_button();

      ?>
    </form>

    <p><?php echo $message; ?></p>
  </div>

<?php

}

/**
 * Inserts the head code on the front-end of the site.
 */
function ec_insert_head_code() {

  $options = get_option( 'ec_options' );
  $code    = $options['ec_head_code'];

  echo $code;

}
add_action( 'wp_head', 'ec_insert_head_code' );

/**
 * Inserts the footer code on the front-end of the site.
 */
function ec_insert_footer_code() {

  $options = get_option( 'ec_options' );
  $code    = $options['ec_footer_code'];

  echo $code;

}
add_action( 'wp_footer', 'ec_insert_footer_code' );