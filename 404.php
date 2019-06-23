<?php get_header(); ?>
        <section id="main-content">
            <header>
                <h1><?php _e( 'Sorry, that page can&rsquo;t be found.', 'saorsa' ); ?></h1>
            </header>
            <div class="page-content">
                <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'saorsa' ); ?></p>
                <?php get_search_form(); ?>
            </div><!-- .page-content -->
        </section>
            <?php get_sidebar(); ?>
            <?php if ( is_home() ) : ?>
                <nav  aria-labelledby="secondary-nav-label">
                    <div id="secondary-nav-label" hidden>Secondary</div>
                    <?php saorsa_the_posts_navigation(); ?>
                </nav>
            <?php endif; ?>
        
<?php get_footer(); ?>
