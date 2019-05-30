<article itemscope itemtype="http://schema.org/BlogPosting" itemid="<?php the_permalink(); ?>" <?php post_class( array( 'h-entry', 'hentry' ) ); ?>>
						<?php get_template_part( 'templates/posts/post-header', get_post_format() ); ?>
						<?php
						if ( has_post_kind() ) {
							set_query_var( 'cite', saorsa_post_kind_metadata( $post ) );
							get_template_part( 'kind_views/kind', get_post_kind_slug() );
						}
						?>
						<div itemprop="articleBody" class="e-content">
							<?php the_content(); ?>
						</div>
						<?php if ( '' !== $post->post_content ) : ?>
						<hr class="text-center w-50">
						<?php endif; ?>
						<!-- <hr> -->
					</article>
					<?php if ( is_single() ) : ?>
					<footer class="comments-area">
						<nav class="post footer">
							<ul class="nav flex-column flex-sm-row justify-content-center nav-fill">	
								<li class="nav-item next">
									<?php if ( get_next_post_link() ) : ?>
										<?php
										next_post_link(
											'%link',
											'Newer: %title'
										);
										?>
									<?php endif; ?>
								</li>

								<li class="nav-item prev">
									<?php if ( get_previous_post_link() ) : ?>
										<?php
										previous_post_link(
											'%link',
											'Older: %title'
										);
										?>
									<?php endif; ?>
								</li>

							</ul>
							<hr>
						</nav>
					</footer>
						<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' !== get_comments_number() ) {
							comments_template( '', true );
						}
						?>
					<?php endif; ?>
