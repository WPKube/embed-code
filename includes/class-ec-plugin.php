<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'EC_Plugin' ) ) :

class EC_Plugin {

	public function __construct() {

		add_action( 'plugins_loaded',  [ $this, 'include_vendor' ] );

		add_action( 'cmb2_admin_init', [ $this, 'options_page' ] );
		add_action( 'cmb2_admin_init', [ $this, 'meta_box' ] );

		add_action( 'wp_head',         [ $this, 'output_head_code' ] );
		add_action( 'wp_footer',       [ $this, 'output_footer_code' ] );

	}

	public function include_vendor() {

		include EC_PATH . 'includes/vendor/cmb2/init.php';

	}

	public function options_page() {

		$prefix = 'ec_';

		$cmb = new_cmb2_box( [
			'id'           => $prefix . 'options',
			'title'        => esc_html__( 'Embed Code', 'embed-code' ),
			'object_types' => [ 'options-page' ],
			'option_key'   => 'ec_options',
			'parent_slug'  => 'options-general.php',
		] );

		$cmb->add_field( [
			'name' => 'Global Code',
			'desc' => esc_html__( 'The code below will be added to the entire website.', 'embed-code' ),
			'type' => 'title',
			'id'   => $prefix . 'global-code-title',
		] );

		$cmb->add_field( $this->get_field_args_head_code( $prefix ) );

		$cmb->add_field( $this->get_field_args_footer_code( $prefix ) );

	}

	public function meta_box() {

		$prefix = '_ec_';

		$cmb = new_cmb2_box( [
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Embed Code', 'embed-code' ),
			'object_types' => $this->get_enabled_post_types(),
			'priority'     => 'low',
		] );

		$cmb->add_field( $this->get_field_args_head_code( $prefix ) );

		$cmb->add_field( $this->get_field_args_footer_code( $prefix ) );

	}

	public function output_head_code() {

		$option = get_option( 'ec_options' );
		if ( isset( $option['ec_head_code'] ) ) {
			echo $this->wrap_line_breaks( $option['ec_head_code'] );
		}

		if ( is_singular( $this->get_enabled_post_types() ) ) {
			echo $this->wrap_line_breaks( get_post_meta( get_the_ID(), '_ec_head_code', true ) );
		}

	}

	public function output_footer_code() {

		$option = get_option( 'ec_options' );
		if ( isset( $option['ec_footer_code'] ) ) {
			echo $this->wrap_line_breaks( $option['ec_footer_code'] );
		}

		if ( is_singular( $this->get_enabled_post_types() ) ) {
			echo $this->wrap_line_breaks( get_post_meta( get_the_ID(), '_ec_footer_code', true ) );
		}

	}

	protected function get_field_args_code_defaults() {

		return [
			'type'            => 'textarea',
			'attributes'      => [
				'rows'        => 8,
				'class'       => 'cmb2_textarea code',
				'placeholder' => esc_attr__( 'Paste code here&hellip;', 'embed-code' ),
			],
			'sanitization_cb' => false,
		];

	}

	protected function get_field_args_head_code( $prefix ) {

		return wp_parse_args( [
			'name' => esc_html__( 'Head Code', 'embed-code' ),
			'desc' => wp_kses(
				__( 'Will be inserted just before the <code>&lt;/head&gt;</code> tag.', 'embed-code' ),
				[ 'code' => [] ]
			),
			'id'   => $prefix . 'head_code',
		], $this->get_field_args_code_defaults() );

	}

	protected function get_field_args_footer_code( $prefix ) {

		return wp_parse_args( [
			'name' => esc_html__( 'Footer Code', 'embed-code' ),
			'desc' => wp_kses(
				__( 'Will be inserted just before the <code>&lt;/body&gt;</code> tag.', 'embed-code' ),
				[ 'code' => [] ]
			),
			'id'   => $prefix . 'footer_code',
		], $this->get_field_args_code_defaults() );

	}

	protected function get_enabled_post_types() {

		$post_types = get_post_types( [ 'public' => true ] );
		$post_types = array_values( $post_types );
		$post_types = array_diff( $post_types, [ 'attachment' ] );

		return apply_filters( 'ec_enabled_post_types', $post_types );

	}

	protected function wrap_line_breaks( $str ) {

		return "\n$str\n";

	}

}

endif;

new EC_Plugin();
