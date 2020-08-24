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

	<wfooter 
		id="site-footer"
		class="site-footer"
		home="<?php echo site_url('/'); ?>"
		facebook="<?php get_setting_sosmed_facebook(true);?>"
		twitter="<?php get_setting_sosmed_twitter(true);?>"
		instagram="<?php get_setting_sosmed_instagram(true);?>"
		youtube="<?php get_setting_sosmed_youtube(true);?>">

		<template v-slot:phone>
			<h6><?php _e( 'Phone', 'gragas' );?></h6>
			<span>FO Karaoke - <?php get_setting_company_phone(true);?></span>
			<span>FO Hotel - <?php get_setting_company_phone_hotel(true);?></span>
		</template>

		<template v-slot:logo>
			<?php
				$logo_footer = get_theme_mod('lorasin_logo_footer');
			?>
			<img src="<?php echo $logo_footer; ?>" alt="<?php get_bloginfo('name') ?>" class="logo img-fluid">
		</template>

		<template v-slot:email>
			<h6><?php _e( 'Email', 'gragas' );?></h6>
			<span>FO Karaoke - <?php get_setting_company_email(true);?></span>
			<span>FO Hotel - <?php get_setting_company_email_hotel(true);?></span>
		</template>

	</wfooter>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
