<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Gragas
 */

?>

	</div><!-- #content -->

	<h-footer 
		id="site-footer"
		class="site-footer"
		home="<?php echo site_url('/'); ?>"
		copyright="Template Batik"
		facebook="<?php get_setting_sosmed_facebook(true);?>"
		twitter="<?php get_setting_sosmed_twitter(true);?>"
		instagram="<?php get_setting_sosmed_instagram(true);?>"
		youtube="<?php get_setting_sosmed_youtube(true);?>">

		<template v-slot:logo>
			<?php
				$logo_footer = get_theme_mod('lorasin_logo_invert');
			?>
			<img src="<?php echo $logo_footer; ?>" alt="<?php get_bloginfo('name') ?>" class="logo img-fluid">
		</template>

		<template v-slot:description>
			<p><?php echo get_theme_mod('lorasin_footer_text');?></p>
		</template>

		<template v-slot:menu-one>
			<?php dynamic_sidebar( 'footer-one-sidebar' ); ?>
		</template>

		<template v-slot:menu-two>
			<?php dynamic_sidebar( 'footer-two-sidebar' ); ?>
		</template>

		<template v-slot:contact>
			<h2 class="widget-title"><?php _e('Contact', 'batik');?></h2>
			<p class="contact-item">
				<i class="icon fa fa-phone"></i>
				<span><?php get_setting_company_phone(true);?></span>
			</p>
			<p class="contact-item">
				<i class="icon fa fa-envelope"></i>
				<span><?php get_setting_company_email(true);?></span>
			</p>
			<p class="contact-item">
				<i class="icon fa fa-map-marker"></i>
				<span><?php get_setting_company_address(true);?></span>
			</p>
		</template>

	</h-footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
