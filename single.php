<?php get_header(); ?>
<!-- Single Template -->
        <main id="main-content" class="content--page">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>
                    <?php
                    /* Include the Post-Format-specific template for the content.
                    * If you want to override this in a child theme then include a file
                    * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                    */
                    get_template_part( 'templates/single/content', saorsa_post_type() );
                    ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part( 'templates/single/content', 'none' ); ?>
            <?php endif; ?>
        </main>
            <?php get_sidebar(); ?>        
<?php get_footer(); ?>
