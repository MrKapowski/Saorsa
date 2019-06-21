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
 * Remove the default display location of the webmention form
 */
remove_action( 'comment_form_after', array( 'Webmention_Plugin', 'comment_form' ), 11 );
