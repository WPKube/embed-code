<?php
/**
 * Options Page
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register the options page.
 */
function ec_register_options_page() {

	add_options_page(
		esc_html__( 'Embed Code', 'embed-code' ),
		esc_html__( 'Embed Code', 'embed-code' ),
		'manage_options',
		'embed-code',
		'ec_options_page'
	);

}
add_action( 'admin_menu', 'ec_register_options_page' );

/**
 * Register setting, setting groups, and setting fields.
 */
function ec_register_settings() {

	register_setting( 'ec_options', 'ec_options' );

	/**
	 * Head Code
	 */
	add_settings_section(
		'ec_head',
		esc_html__( 'Head Code', 'embed-code' ),
		'ec_settings_description_head',
		'embed-code'
	);

	add_settings_field(
		'ec_head_code',
		esc_html__( 'Embed Code', 'embed-code' ),
		'ec_settings_field_head',
		'embed-code',
		'ec_head'
	);

	/**
	 * Footer Code
	 */
	add_settings_section(
		'ec_footer',
		esc_html__( 'Footer Code', 'embed-code' ),
		'ec_settings_description_footer',
		'embed-code'
	);

	add_settings_field(
		'ec_footer_code',
		esc_html__( 'Embed Code', 'embed-code' ),
		'ec_settings_field_footer',
		'embed-code',
		'ec_footer'
	);

}
add_action( 'admin_init', 'ec_register_settings' );

/**
 * Output the description for Head Code.
 */
function ec_settings_description_head() {

	printf(
		'<p>%s</p>',
		wp_kses(
			__( 'Will be inserted just before the <code>&lt;/head&gt;</code> tag.', 'embed-code' ),
			array( 'code' => array() )
		)
	);

}

/**
 * Output the field for Head Code.
 */
function ec_settings_field_head() {

	$options = get_option( 'ec_options' );

	?>

	<textarea
		id="<?php echo $ec_head_code; ?>"
		name="ec_options[ec_head_code]"
		class="large-text code"
		rows="8"
		placeholder="<?php esc_attr_e( 'Paste code here&hellip;', 'embed-code' ); ?>"
	><?php echo esc_textarea( $options['ec_head_code'] ) ?></textarea>

	<?php

}

/**
 * Output the description for Footer Code.
 */
function ec_settings_description_footer() {

	printf(
		'<p>%s</p>',
		wp_kses(
			__( 'Will be inserted just before the <code>&lt;/body&gt;</code> tag.', 'embed-code' ),
			array( 'code' => array() )
		)
	);

}

/**
 * Output the field for Footer Code.
 */
function ec_settings_field_footer() {

	$options = get_option( 'ec_options' );

	?>

	<textarea
		id="<?php echo $ec_footer_code; ?>"
		name="ec_options[ec_footer_code]"
		class="large-text code"
		rows="8"
		placeholder="<?php esc_attr_e( 'Paste code here&hellip;', 'embed-code' ); ?>"
	><?php echo esc_textarea( $options['ec_footer_code'] ) ?></textarea>

	<?php

}

/**
 * Output the options page.
 */
function ec_options_page() {

	$message = sprintf(
		wp_kses(
			__( 'If you&rsquo;ve found this plugin useful, please consider <a href="%s" target="_blank">leaving a review</a>.', 'embed-code' ),
			array( 'a' => array(
				'href'   => array(),
				'target' => array()
			) )
		),
		'https://wordpress.org/support/view/plugin-reviews/embed-code'
	);

	?>

	<div class="wrap">
		<h2><?php esc_html_e( 'Embed Code', 'embed-code' ); ?></h2>

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
