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
		<?php the_gragas_jumbotron(0, true); ?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-8">
					<?php
					if (have_posts()) :
						while (have_posts()) :
							echo '<div class="article-grid">';
							get_template_part('template-parts/content', get_post_type());
							echo '</div>';
						endwhile;
						// Make the pagination in one row with full width
						echo "<div class='pagination'>";
						gragas_pagination();
						echo "</div>";
					else :
						get_template_part('template-parts/content', 'none');
					endif;
					?>
				</div>
				<div class="col-xs-12 col-md-4">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</main>
</div><!-- #primary -->

<?php
get_footer();
