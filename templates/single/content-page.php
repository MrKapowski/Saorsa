<article itemscope itemtype="http://schema.org/BlogPosting" itemid="<?php the_permalink(); ?>" <?php post_class( array( 'h-entry', 'hentry' ) ); ?>>
						<?php get_template_part( 'templates/posts/post-header', get_post_format() ); ?>
						<div itemprop="articleBody" class="post__body e-content">
							<?php the_content(); ?>
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

