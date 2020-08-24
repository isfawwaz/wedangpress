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

		<?php gragas_post_thumbnail(); ?>

		<div class="article-item--content">
			<?php gragas_entry_categories();?>
			<?php the_title( '<h4 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" title="'. get_the_title() .'">', '</a></h2>' ); ?>
			<div class="intro-content">
				<?php echo get_the_excerpt();?>
			</div><!-- .entry-content -->
		</div>

		<?php gragas_post_edit(); ?>

	<?php else: ?>

		<?php gragas_post_thumbnail(); ?>
	
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					gragas_posted_on();
					gragas_posted_by();
					?>
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
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php gragas_entry_footer(); ?>
		</footer><!-- .entry-footer -->

	<?php endif;?>

</article><!-- #post-<?php the_ID(); ?> -->
