<?php
/**
 * Plugin Name: WPDC Greetings Paragraph Variation
 * Description: Registers a `'wpdc/greeting` variation for the Paragraph block,
 *              which binds the `wpdc_greeting` post meta.
 * Update URI: false
 */

function wpdc_register_greetings_paragraph_variation( $variations, $block_type ) {
	if ( 'core/paragraph' !== $block_type->name ) {
		return $variations;
	}

	$variations[] = [
		'name'  => 'wpdc/greeting',
		'title' => 'Greeting',
		'attributes' => [
			'metadata' => [
				'bindings' => [
					'content' => [
						'source' => 'core/post-meta',
						'args' => [
							'key' => 'wpdc_greeting',
						],
					],
				],
				'name' => 'Greeting',
			],
		]
	];

	return $variations;
}
add_filter( 'get_block_type_variations', 'wpdc_register_greetings_paragraph_variation', 10, 2 );
