<?php
return [
	'use_default_style' => false,
	'use_default_script' => false,
	'styles' => [
		'font-awesome' => 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
		'wahaha' => mixin('css/style.css'),
	],
	'script' => [
		'wahaha' => mixin('js/main.js'),
	],
];