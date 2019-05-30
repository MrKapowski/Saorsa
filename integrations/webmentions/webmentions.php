<?php

/**
 * Overrides the Webmention comment form with our bundled template
 */
function saorsa_webmention_form() {
	return get_stylesheet_directory() . '/integrations/webmentions/templates/webmention-form.php';
}
/**
 * Filters the webmention form, so our custom template is applied
 */
add_filter( 'webmention_comment_form', 'saorsa_webmention_form' );

/**
 * Loads custom template for Semantic Linkbacks mentions.
 * @since saorsa 0.0.1
 */
function saorsa_show_mentions() {
	get_template_part( 'integrations/webmentions/templates/webmentions' );
}
