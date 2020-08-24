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

			<div class="gragas-jumbotron">
				<div class="jumbotron-wrapper">
					<h1 class="jumbotron-title"><?php echo strtoupper(single_post_title()); ?></h1>
					<div class="breadcrumb-container">
						<?php breadcrumbs(); ?>
					</div>
				</div>
			</div>

			<?php
			if ( have_posts() ) :

				echo "<div class='container articles-wrapper'>"; // Start Container
					echo "<div class='row'>"; // Start Row

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						echo "<div class='col-xs-12 col-md-6'>";
						get_template_part( 'template-parts/content', get_post_type() );
						echo "</div>";

					endwhile;

					echo "</div>"; // End Row

					// Make the pagination in one row with full width
					echo "<div class='row'>";
						echo "<div class='col'>";
							gragas_pagination();
						echo "</div>";
					echo "</div>";


			echo "</div>"; // End Container

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
