<?php
return [
	'use_default_style' => false,
	'use_default_script' => false,
	'styles' => [
		'font-awesome' => 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
		'site' => mixin('css/style.css'),
	],
	'script' => [
		'site' => mixin('js/main.js'),
	],
];