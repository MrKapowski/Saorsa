<?php get_header(); ?>
        <main id="main-content">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>
                    <?php
                    /* Include the Post-Format-specific template for the content.
                    * If you want to override this in a child theme then include a file
                    * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                    */
                    get_template_part( 'templates/list/content', saorsa_post_type() );
                    ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part( 'templates/list/content', 'none' ); ?>
            <?php endif; ?>
        </main>
            <?php get_sidebar(); ?>
            <?php if ( is_home() ) : ?>
                <nav  aria-labelledby="secondary-nav-label">
                    <div id="secondary-nav-label" hidden>Secondary</div>
                    <?php saorsa_the_posts_navigation(); ?>
                </nav>
            <?php endif; ?>
        
<?php get_footer(); ?>
