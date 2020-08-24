<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gragas
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<?php if (is_single()) : global $post; ?>
		<meta name="author" content="<?php the_author_meta('display_name', $post->post_author); ?>">
	<?php endif; ?>

	<meta name="ajax-admin" content="<?php echo home_url('/wp-admin/admin-ajax.php'); ?>">
	<meta name="homeurl" content="<?php echo get_stylesheet_directory_uri();?>">
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css?family=Teko:700|Hind:400,400i,700" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wahaha-site" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'gragas' ); ?></a>

	<?php
	$jumbotron = get_post_meta( get_the_ID(), 'origamicrane_page_jumbotron', true );
	$cls = '';
	if( $jumbotron ) {
		$cls = ' header-pinned';
	}
	?>

	<wheader 
		class="header header-default<?php echo $cls;?>" 
		home="<?php echo site_url('/') ?>"
		copyright="Wahah Hotel &amp; Entertainment">
		<template v-slot:logo>
			<?php
				$custom_logo_id = get_theme_mod('custom_logo');
				$image = wp_get_attachment_image_src($custom_logo_id, 'full');
			?>
			<img src="<?php echo $image[0]; ?>" alt="<?php get_bloginfo('name') ?>" class="logo img-fluid">
		</template>
		<template v-slot:menu>
			<?php gragas_menu_primary(); ?>
		</template>
	</wheader>

	<div id="content" class="site-content">
