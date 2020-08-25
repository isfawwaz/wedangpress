<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Gragas
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-item'); ?>>

	<?php if( !is_single() ): ?>

		<?php get_template_part( 'template-parts/content', 'grid' ); ?>

	<?php else: ?>

		<?php gragas_post_thumbnail(); ?>

		<?php gragas_entry_categories();?>
	
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="title">', '</h1>' );
			else :
				the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php gragas_posted_on();?>
					<?php gragas_post_edit(); ?>
					<hr>
					<?php gragas_posted_by();?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'gragas' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gragas' ),
				'after'  => '</div>',
			) );

			gragas_entry_tags();
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<div class="entry-sharing">
				<?php gragas_sharing_button();?>
			</div>
			<div class="entry-related">
				<?php gragas_article_related();?>
			</div>
		</footer><!-- .entry-footer -->

	<?php endif;?>

</article><!-- #post-<?php the_ID(); ?> -->
