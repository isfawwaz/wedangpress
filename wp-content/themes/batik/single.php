<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Gragas
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php the_gragas_jumbotron( 0, true );?>

		<?php
		// Facebook sharer
		$link = esc_url( get_permalink() );
		$href = "https://www.facebook.com/sharer?u=&lt;?php ".$link.";?&gt;&amp;t=&lt;?php the_title(); ?&gt;";
		?>

		<div class="container mx-auto">
			<div class="flex">
				<div class="w-2/3 mr-4">
					<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );

							// If comments are open or we have at least one comment, load up the comment template.

						endwhile; // End of the loop.
					?>
				</div>
				<div class="w-1/3 ml-4">
					<?php get_sidebar();?>
				</div>
			</div>
		</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
