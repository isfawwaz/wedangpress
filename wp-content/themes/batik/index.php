<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Gragas
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			
		<?php the_gragas_jumbotron( 0, true );?>

			<div class="container mx-auto">
				<div class="flex">
					<div class="w-full md:w-2/3 pr-4">
						<?php
						if ( have_posts() ) :

								echo "<div class='grid grid-cols-1 gap-5 md:grid-cols-2'>"; // Start Row

								/* Start the Loop */
								while ( have_posts() ) :
									the_post();

									/*
									* Include the Post-Type-specific template for the content.
									* If you want to override this in a child theme, then include a file
									* called content-___.php (where ___ is the Post Type name) and that will be used instead.
									*/
									echo "<div class='article-grid'>";
									get_template_part( 'template-parts/content', get_post_type() );
									echo "</div>";

								endwhile;

								echo "</div>"; // End Row

								// Make the pagination in one row with full width
								echo "<div class='pagination'>";
									gragas_pagination();
								echo "</div>";

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
						?>
					</div>
					<div class="w-full md:w-1/3 pl-4">
						<?php get_sidebar();?>
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();