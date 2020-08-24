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
					<div class="single-post-wrapper">
						<div class="meta">
							<!-- Box Post Date -->
							<div class="box-date">
								<h3 class="mb-0">03</h3>
								<p class="mb-0">MAR, 2020</p>
							</div>
							<!-- Box Twitter Share -->
							<script src='https://platform.twitter.com/widgets.js'></script>
							<a href="https://twitter.com/intent/tweet?url=<?= $link; ?>&text=<?= get_the_title(); ?>%0A" target="_blank">
								<div class="box box-twitter">
									<i class="icon fa fa-twitter"></i>
								</div>
							</a>
							<!-- Box Facebook Share -->
							<a href="<?= $href; ?>" target="_blank" rel="noopener noreferrer">
								<div class="box box-facebook">
									<i class="icon fa fa-facebook"></i>
								</div>
							</a>
							<!-- Box Email -->
							<a href="mailto:ahmadinations@email.com?subject=<?php echo get_the_title(); ?>">
								<div class="box box-mail">
									<i class="fa fa-envelope"></i>
								</div>
							</a>
						</div>
					</div>
					<div class="content">
						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );

							// If comments are open or we have at least one comment, load up the comment template.

						endwhile; // End of the loop.
						?>
					</div>
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
