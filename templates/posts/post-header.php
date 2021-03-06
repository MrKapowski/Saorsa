<section class="post-metabox">
	<time class="post-metabox__published dt-published" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
		<a href="<?php the_permalink(); ?>" class="post-metabox__link u-url u-uid" itemprop="mainEntityOfPage" rel="permalink">
			<?php the_time( 'g:i a' ); ?>
		</a>
	</time>
	<meta class="dt-modified" itemprop="dateModified" content="<?php the_modified_date( 'c' ); ?>">

	<?php get_template_part( 'templates/posts/author-details' ); ?>
	<?php get_template_part( 'templates/posts/publisher-details' ); ?>
</section>
<section class="post__content">
	<?php if ( ! empty( $post->post_title ) ) : ?><header class="post-header">

		<h1 class="post-header__title <?php saorsa_header_class(); ?> p-name" itemprop="headline">
			<a href="<?php the_permalink(); ?>" rel="permalink" class="post-header__link u-url u-uid" title="<?php the_title_attribute(); ?>">
				<?php the_title(); ?>
			</a>
		</h1>
	</header><?php endif; ?>
