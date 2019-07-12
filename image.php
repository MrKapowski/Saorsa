<?php get_header(); ?>
<!-- Image Template -->
        <main id="main-content" class="content--page">
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
        <nav  aria-labelledby="secondary-nav-label" class="nav--pager">
            <div id="secondary-nav-label" hidden>Secondary</div>
            <?php saorsa_the_posts_navigation(); ?>
        </nav>
        
<?php get_footer(); ?>
