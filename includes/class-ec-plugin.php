<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'EC_Plugin' ) ) :

class EC_Plugin {

	public function __construct() {

		add_action( 'plugins_loaded', [ $this, 'include_vendor' ] );

		add_action( 'cmb2_admin_init', [ $this, 'options_page' ] );
		add_action( 'cmb2_admin_init', [ $this, 'meta_box' ] );

		add_action( 'wp_head',   [ $this, 'output_head_code' ] );
		add_action( 'wp_footer', [ $this, 'output_footer_code' ] );

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
			'type' => 'title',
			'id'   => $prefix . 'global-code-title',
		] );

		$code_kses = [ 'code' => [] ];

		$cmb->add_field( $this->get_field_args_head_code( $prefix ) );

		$cmb->add_field( $this->get_field_args_footer_code( $prefix ) );

		$cmb->add_field( [
			'name' => esc_html__( 'Options', 'embed-code' ),
			'type' => 'title',
			'id'   => $prefix . 'options-title',
		] );

		$cmb->add_field( [
			'name'              => esc_html__( 'Post Types', 'embed_code' ),
			'id'                => $prefix . 'post_types',
			'type'              => 'multicheck',
			'options'           => $this->get_post_type_options(),
			'default'           => [ 'post', 'page' ],
			'select_all_button' => false,
			'sanitization_cb'   => 'ec_sanitize_post_types',
		] );

	}

	public function meta_box() {

		$prefix = '_ec_';

		$cmb = new_cmb2_box( [
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Embed Code', 'embed-code' ),
			'object_types' => $this->get_enabled_post_types(),
		] );

		$cmb->add_field( $this->get_field_args_head_code( $prefix ) );

		$cmb->add_field( $this->get_field_args_footer_code( $prefix ) );

	}

	public function output_head_code() {

		$option = get_option( 'ec_options' );
		if ( isset( $options['head_code'] ) ) {
			echo $options['head_code'];
		}

		if ( is_singular( $this->get_enabled_post_types() ) ) {
			echo get_post_meta( get_the_ID(), '_ec_head_code', true );
		}

	}

	public function output_footer_code() {

		$option = get_option( 'ec_options' );
		if ( isset( $options['footer_code'] ) ) {
			echo $options['footer_code'];
		}

		if ( is_singular( $this->get_enabled_post_types() ) ) {
			echo get_post_meta( get_the_ID(), '_ec_footer_code', true );
		}

	}

	protected function get_post_type_options() {

		$options = [];

		$post_types = get_post_types( [ 'public' => true ] );
		$post_types = array_values( $post_types );
		$post_types = array_diff( $post_types, [ 'attachment' ] );

		foreach ( $post_types as $post_type ) {
			$post_type = get_post_type_object( $post_type );
			$options[ $post_type->name ] = $post_type->label;
		}

		return $options;

	}

	protected function get_default_post_types() {

		return apply_filters( 'ec_default_post_types', [ 'post', 'page' ] );

	}

	protected function get_enabled_post_types() {

		$options = get_option( 'ec_options' );

		if ( isset( $options['ec_post_types'] ) ) {
			$post_types = $options['ec_post_types'];
		} else {
			$post_types = $this->get_default_post_types();
		}

		return apply_filters( 'ec_enabled_post_types', $post_types );

	}

	protected function get_field_args_head_code( $prefix ) {

		return [
			'name'       => esc_html__( 'Head Code', 'embed-code' ),
			'desc'       => wp_kses(
				__( 'Will be inserted just before the <code>&lt;/head&gt;</code> tag.', 'embed-code' ),
				$this->get_code_kses()
			),
			'id'         => $prefix . 'head_code',
			'type'       => 'textarea',
			'attributes' => [
				'rows'        => 8,
				'class'       => 'cmb2_textarea code',
				'placeholder' => esc_attr__( 'Paste code here&hellip;', 'embed-code' ),
			],
		];

	}

	protected function get_field_args_footer_code( $prefix ) {

		return [
			'name'       => esc_html__( 'Footer Code', 'embed-code' ),
			'desc'       => wp_kses(
				__( 'Will be inserted just before the <code>&lt;/body&gt;</code> tag.', 'embed-code' ),
				$this->get_code_kses()
			),
			'id'         => $prefix . 'footer_code',
			'type'       => 'textarea',
			'attributes' => [
				'rows'        => 8,
				'class'       => 'cmb2_textarea code',
				'placeholder' => esc_attr__( 'Paste code here&hellip;', 'embed-code' ),
			],
		];

	}

	protected function get_code_kses() {

		return [ 'code' => [] ];

	}

}

endif;

new EC_Plugin();

function ec_sanitize_post_types( $value ) {

	if ( empty( $value ) ) {
		$value = [ 'ec_non_existant_post_type' ];
	}

	return $value;

}
