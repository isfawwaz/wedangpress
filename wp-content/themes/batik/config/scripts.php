<?php
return [
	'use_default_style' => false,
	'use_default_script' => false,
	'styles' => [
		'bootstrap' => mixin('css/bootstrap.css'),
		'woocommerce' => mixin('css/woocommerce.css'),
		'site' => mixin('css/style.css'),
	],
	'script' => [
		'site' => mixin('js/main.js'),
	],
];