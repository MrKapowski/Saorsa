<meta itemprop="image" content="<?php echo esc_attr( get_theme_file_uri( 'assets/img/kapow_magenta.png' ) ); ?>">
<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
	<meta itemprop="url" content="<?php bloginfo( 'url' ); ?>">
	<meta itemprop="name" content="<?php bloginfo( 'name' ); ?>">
	<?php
	if ( has_custom_logo() ) :
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	?>
	<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
		<meta itemprop="url" content="<?= $image[0]; ?>">
		<meta itemprop="width" content="<?= $image[1]; ?>px">
		<meta itemprop="height" content="<?= $image[2]; ?>px">
	</span>
	<?php endif; ?>
</span>
<?php
