<?php
/*
if ( ! is_single() ) {
	return;
}*/
?>
<span class="post--metabox--author"> by 
	<span itemprop="author" itemscope="" itemtype="http://schema.org/Person">
		<span class="author--card p-author h-card hcard" itemprop="name">
			<a href="<?php echo esc_url( get_the_author_meta( 'user_url' ) ); ?>" rel="author" itemprop="url" class="author--card--name p-name u-url url name fn">
				<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
			</a>
			<img itemprop="image" class="author--card--photo u-photo" src="<?php echo esc_attr( get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?>">
		</span>
	</span>
</span>
<?php
