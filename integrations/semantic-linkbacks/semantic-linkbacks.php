<?php

function saorsa_semantic_linkbacks_init() {
    remove_action( 'comment_form_before', array( 'Linkbacks_Handler', 'show_mentions' ) );
	remove_action( 'comment_form_comments_closed', array( 'Linkbacks_Handler', 'show_mentions' ) );
	remove_filter( 'wp_list_comments_args', array( 'Linkbacks_Handler', 'filter_comment_args' ) );
    remove_filter( 'get_comment_text', array( 'Linkbacks_Handler', 'comment_text_add_cite' ), 11 );
    add_action( 'comment_mentions', 'saorsa_show_mentions' );
}
add_action( 'wp_loaded', 'saorsa_semantic_linkbacks_init' );


function saorsa_deregister_semantic_linkbacks_styles() {
    wp_deregister_style( 'semantic-linkbacks-css' );
}
add_action( 'wp_print_styles', 'saorsa_deregister_semantic_linkbacks_styles', 100 );
/**
 * Loads custom template for Semantic Linkbacks mentions.
 * @since saorsa 0.0.1
 */
function saorsa_show_mentions() {
	get_template_part( 'integrations/semantic-linkbacks/templates/mentions' );
}