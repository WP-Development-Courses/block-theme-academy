<?php
/**
 * Plugin Name: WPDC Greetings Post Meta
 * Description: Registers a `wpdc_greeting` post meta for the `post` post type.
 * Update URI: false
 */

function wpdc_register_post_meta() {
	register_post_meta(
		'post',
		'wpdc_greeting',
		[
			'default'           => '',
			'sanitize_callback' => 'wp_strip_all_tags',
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
		]
	);
}
add_action( 'init', 'wpdc_register_post_meta' );
