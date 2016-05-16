<?php
/**
 * Output
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output the global head code.
 */
function ec_output_global_head() {

	$options = get_option( 'ec_options' );
	$code    = $options['ec_head_code'];

	if ( ! empty( $code ) ) {
		echo $code;
	}

}
add_action( 'wp_head', 'ec_output_global_head' );

/**
 * Output the global footer code.
 */
function ec_output_global_footer() {

	$options = get_option( 'ec_options' );
	$code    = $options['ec_footer_code'];

	if ( ! empty( $code ) ) {
		echo $code;
	}

}
add_action( 'wp_footer', 'ec_output_global_footer' );

/**
 * Output the post head code.
 */
function ec_output_post_head() {

	if ( ! is_singular() ) {
		return;
	}

	$code = get_post_meta( get_the_id(), '_ec_head_code', true );

	if ( ! empty( $code ) ) {
		echo $code;
	}

}
add_action( 'wp_head', 'ec_output_post_head' );

/**
 * Output the post footer code.
 */
function ec_output_post_footer() {

	if ( ! is_singular() ) {
		return;
	}

	$code = get_post_meta( get_the_id(), '_ec_footer_code', true );

	if ( ! empty( $code ) ) {
		echo $code;
	}

}
add_action( 'wp_footer', 'ec_output_post_footer' );
