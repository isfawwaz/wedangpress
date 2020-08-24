<?php
return [
	'event' => [
		'slug' => 'event',
		'singular' => 'Event',
		'plural' => 'Events',
		'menu_icon' => 'dashicons-calendar-alt',
		'menu_position' => 18,
		'text_domain' => 'batik',
		'description' => 'Wahaha event list',
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'show_in_rest' => true,
	]
];