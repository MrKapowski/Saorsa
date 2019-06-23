<?php get_header(); ?>
        <main id="main-content">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>
                    <?php
                    get_template_part( 'templates/single/content', '' );
                    ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part( 'templates/single/content', 'none' ); ?>
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
