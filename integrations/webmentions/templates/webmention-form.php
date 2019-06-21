<section class="comment--webmention">
	<h2 class="comment--webmention--title"><?php esc_html_e( 'Webmention', 'webmention' ); ?></h2>
	<p class="comment--webmention--intro">
		<?php echo get_webmention_form_text( get_the_ID() /*phpcs:ignore*/); ?>
	</p>
	<form id="webmention-form" class="comment--webmention--form" action="<?php echo esc_url( get_webmention_endpoint() ); ?>" method="post">
		<input id="webmention-source" type="url" name="source" class="" placeholder="<?php esc_attr_e( 'URL/Permalink of your article', 'webmention' ); ?>" />
		<button id="webmention-submit" type="submit" name="submit" class=""><?php esc_html_e( 'Ping me!', 'webmention' ); ?></button>
		<input id="webmention-format" type="hidden" name="format" value="html" />
		<input id="webmention-target" type="hidden" name="target" value="<?php the_permalink(); ?>" />
	</form>
</section>
