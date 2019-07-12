<?php get_header(); ?>
        <section id="main-content" class="archive content--page">
            <?php if ( have_posts() ) : ?>
            <header class="search__header">
                <h1>
                    <?php _e( 'Search results for:', 'mrkapowski' ); ?>
					<span class="search__term"><?php echo get_search_query(); ?></span>
				</h1>
            </header><!-- .page-header -->
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
        </section>
            <?php get_sidebar(); ?>
          <nav  aria-labelledby="secondary-nav-label" class="nav--pager">
                    <div id="secondary-nav-label" hidden>Secondary</div>
                    <?php saorsa_the_posts_navigation(); ?>
          </nav>
        
<?php get_footer(); ?>
