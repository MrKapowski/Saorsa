<?php
function saorsa_deregister_post_kinds_styles() {
    wp_deregister_style( 'kind' ); // Post-Kinds
}
add_action( 'wp_print_styles', 'saorsa_deregister_post_kinds_styles', 100 );
/**
 * @package Saorsa
 * @since Saorsa 0.0.1
 */

function saorsa_child_kinds_init() {
    //remove Post Kinds from the_excerpt generation.
    remove_filter( 'the_excerpt', array( 'Kind_View', 'excerpt_response' ), 9 );
	remove_filter( 'the_content', array( 'Kind_View', 'content_response' ), 9 );
}
add_action( 'init', 'saorsa_child_kinds_init' );
/**
 * Overrides Post-Kinds Author output
 * @since K 0.8.4
 */
function saorsa_kind_hcard( $string, $author, $args ) {
	return sprintf( '<a class="h-card p-author" rel="external" href="%1s">%2s</a>', $author['url'], $author['name'] );
}
/**
 * Filters the webmention form, so our custom template is applied
 */
add_filter( 'get_hcard', 'saorsa_kind_hcard', 10, 3 );