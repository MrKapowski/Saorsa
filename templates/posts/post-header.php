<header>
							<?php if ( ! empty( $post->post_title ) ) : ?>
<h2 class="<?php saorsa_header_class(); ?> p-name entry-title" itemprop="headline">
								<a href="<?php the_permalink(); ?>" rel="permalink" class="u-url u-uid" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h2>
							<section class="metabox">
								<small>
									<time class="dt-published" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
										<a href="<?php the_permalink(); ?>" class="u-url u-uid" itemprop="mainEntityOfPage" rel="permalink">
										<?php the_time( 'g:i a' ); ?>, <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?> 
										</a>
									</time>
								</small>
								<meta class="dt-modified" itemprop="dateModified" content="<?php the_modified_date( 'c' ); ?>">
								<?php else : ?>
							<section class="metabox">
								<small class="h5">
									<time class="dt-published" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
										<a href="<?php the_permalink(); ?>" class="u-url u-uid" itemprop="mainEntityOfPage" rel="permalink">
											<span itemprop="headline" class="entry-title">
											<?php saorsa_post_type(); ?> at <?php the_time( 'g:i a' ); ?>, <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
											</span>
										</a>
									</time>
								</small>
								<meta class="dt-modified" itemprop="dateModified" content="<?php the_modified_date( 'c' ); ?>">
								<?php endif; ?>
								<?php get_template_part( 'templates/posts/author-details' ); ?>
								<?php get_template_part( 'templates/posts/publisher-details' ); ?>
							</section>

						</header>
