<?php
/**
 * /* Template Name: Links Page
 * The template for displaying Link directory pages.
 * 
 * @package Saorsa
 * @since 0.0.1
 */
?>
<?php get_header(); ?>
        <main id="main-content">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>
                    <article itemscope itemtype="http://schema.org/BlogPosting" itemid="<?php the_permalink(); ?>" <?php post_class( array( 'h-entry', 'hentry' ) ); ?>>
						<?php get_template_part( 'templates/posts/post-header', get_post_format() ); ?>
						<div itemprop="articleBody" class="post__body e-content">
							<?php the_content(); ?>
                            <ul class="links-list">
							<?php
							wp_list_bookmarks(
								array(
									'title_before' => '<h3 class="links-list__cat-header>',
									'title_after'  => '</h3>',
								)
							);
							?>
							</ul>
						</div>
						
						<?php
							if ( is_single() ) {
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || '0' !== get_comments_number() ) {
									comments_template( '', true );
								}
							}
						?>
						<?php get_template_part( 'templates/posts/post-footer', get_post_format() ); ?>
					</article>							
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part( 'templates/single/content', 'none' ); ?>
            <?php endif; ?>
        </main>
            <?php get_sidebar(); ?>        
<?php get_footer(); ?>
