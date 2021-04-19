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

		<?php the_gragas_jumbotron(0, true); ?>

		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-8">
					<?php
					if (have_posts()) :
						while (have_posts()) : the_post();
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

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
