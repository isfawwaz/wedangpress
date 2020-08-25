<?php gragas_post_thumbnail(); ?>

<div class="article-item--content">
    <?php gragas_entry_categories();?>
    <?php the_title( '<h4 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" title="'. get_the_title() .'">', '</a></h2>' ); ?>
    <div class="intro-content">
        <?php echo get_the_excerpt();?>
    </div><!-- .entry-content -->
</div>

<?php gragas_post_edit(); ?>