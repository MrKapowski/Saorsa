<?php

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Saorsa 0.0.1
 */
function saorsa_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( get_header_image() ) {
		$classes[] = 'custom-header';
	}

	if ( ! is_singular() && ! is_404() ) {
		$classes[] = 'hfeed';
		$classes[] = 'h-feed';
		$classes[] = 'feed';
	}

	return $classes;
}
add_filter( 'body_class', 'saorsa_body_classes' );