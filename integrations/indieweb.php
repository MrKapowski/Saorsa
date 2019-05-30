<?php
function saorsa_deregister_indieweb_styles() {
    wp_deregister_style( 'indieweb' ); // IndieWeb
}
add_action( 'wp_print_styles', 'saorsa_deregister_indieweb_styles', 100 );