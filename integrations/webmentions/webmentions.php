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
