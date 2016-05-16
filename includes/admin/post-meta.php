<?php
/**
 * Post Meta
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register post meta box.
 */
function ec_post_meta_register( $post_type = null ) {

	$args = array(
		'id'        => 'ec-embed-code',
		'title'     => esc_html__( 'Embed Code', 'embed-code' ),
		'post_type' => $post_type,
		'context'   => 'normal',
		'priority'  => 'low',
		'fields'    => array(
			'_ec_head_code' => array(
				'name'       => esc_html__( 'Head Code', 'embed-code' ),
				'desc'       => wp_kses(
					__( 'Will be inserted just before the <code>&lt;/head&gt;</code> tag.', 'embed-code' ),
					array( 'code' => array() )
				),
				'type'       => 'textarea',
				'allow_html' => true,
				'attributes' => array(
					'placeholder' => esc_attr__( 'Paste code here&hellip;', 'embed-code' )
				),
				'class'      => 'code'
			),
			'_ec_footer_code' => array(
				'name'       => esc_html__( 'Footer Code', 'embed-code' ),
				'desc'       => wp_kses(
					__( 'Will be inserted just before the <code>&lt;/body&gt;</code> tag.', 'embed-code' ),
					array( 'code' => array() )
				),
				'type'       => 'textarea',
				'allow_html' => true,
				'attributes' => array(
					'placeholder' => esc_attr__( 'Paste code here&hellip;', 'embed-code' )
				),
				'class'      => 'code'
			)
		)
	);

	new CT_Meta_Box( $args );

}

function ec_post_meta_enable() {

	$post_types = get_post_types( array( 'public' => true ) );

	foreach ( $post_types as $post_type ) {
		ec_post_meta_register( $post_type );
	}

}
add_action( 'admin_init', 'ec_post_meta_enable' );
