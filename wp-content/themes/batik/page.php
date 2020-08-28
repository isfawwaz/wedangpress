<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Gragas
 */

get_header();
?>

	<div id="primary" class="content-area">

		<?php while( have_posts() ): the_post(); 
			$jumbotron = get_post_meta( get_the_ID(), 'gragas_page_jumbotron', true );
			?>

			<main id="main" class="site-main<?php echo empty($jumbotron) ? ' no-jumbotron' : '';?>">

				<?php if( !empty($jumbotron) ):?>

					<?php the_gragas_jumbotron( get_the_ID() );?>

				<?php endif;?>

				<?php the_content();?>

			</main>

		<?php endwhile;?>

	</div><!-- #primary -->

<?php
get_footer();
