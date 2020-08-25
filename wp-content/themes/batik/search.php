<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
					<div class="w-2/3 pr-4">
						<?php
						if ( have_posts() ) :

								echo "<div class='grid grid-cols-2 gap-5'>"; // Start Row

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
					<div class="w-1/3 pl-4">
						<?php get_sidebar();?>
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();