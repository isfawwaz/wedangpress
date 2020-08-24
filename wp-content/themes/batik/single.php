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

		<div class="gragas-jumbotron">
			<div class="jumbotron-wrapper">
				<h1 class="jumbotron-title"><?php echo strtoupper(single_post_title()); ?></h1>
				<div class="breadcrumb-container">
					<?php breadcrumbs(); ?>
				</div>
			</div>
		</div>

		<?php
		// Facebook sharer
		$link = esc_url( get_permalink() );
		$href = "https://www.facebook.com/sharer?u=&lt;?php ".$link.";?&gt;&amp;t=&lt;?php the_title(); ?&gt;";
		?>

		<div class="container single-post-wrapper">
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
						<img src="<?= get_stylesheet_directory_uri(); ?>/assets/dist/images/twitter.png">
					</div>
				</a>
				<!-- Box Facebook Share -->
				<a href="<?= $href; ?>" target="_blank" rel="noopener noreferrer">
					<div class="box box-facebook">
						<img src="<?= get_stylesheet_directory_uri(); ?>/assets/dist/images/facebook.png">
					</div>
				</a>
				<!-- Box Email -->
				<a href="mailto:ahmadinations@email.com?subject=<?php echo get_the_title(); ?>">
					<div class="box box-mail">
						<img src="<?= get_stylesheet_directory_uri(); ?>/assets/dist/images/mail.png">
					</div>
				</a>
			</div>
			<div class="content">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content-single', get_post_type() );

					// If comments are open or we have at least one comment, load up the comment template.

				endwhile; // End of the loop.
				?>
			</div>
		</div>

		

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
