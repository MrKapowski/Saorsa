<?php
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