<?php get_header(); ?>
        <main>
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
            <?php if ( is_home() ) : ?>
                <footer>
                    <nav>
                        <?php saorsa_the_posts_navigation(); ?>
                    </nav>
                </footer>
            <?php endif; ?>
        </main>
<?php get_footer(); ?>
