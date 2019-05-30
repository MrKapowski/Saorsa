<?php
/**
 * Filters Jetpack styles, to stop them being bundled together, allowing us to deregister them
 */
add_filter( 'jetpack_implode_frontend_css', '__return_false' );
/**
 * Deregisters Jetpack inserted stylesheets, to stop them interfering with theme styles
 */
function saorsa_deregister_jetpack_styles() {
	wp_deregister_style( 'dashicons' );
	wp_deregister_style( 'jetpack-widget-social-icons-styles' );
	wp_deregister_style( 'AtD_style' ); // After the Deadline
	wp_deregister_style( 'jetpack_likes' ); // Likes
	wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
	wp_deregister_style( 'jetpack-carousel' ); // Carousel
	wp_deregister_style( 'grunion.css' ); // Grunion contact form
	wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
	wp_deregister_style( 'infinity-twentyten' ); // Infinite Scroll - Twentyten Theme
	wp_deregister_style( 'infinity-twentyeleven' ); // Infinite Scroll - Twentyeleven Theme
	wp_deregister_style( 'infinity-twentytwelve' ); // Infinite Scroll - Twentytwelve Theme
	wp_deregister_style( 'noticons' ); // Notes
	wp_deregister_style( 'post-by-email' ); // Post by Email
	wp_deregister_style( 'publicize' ); // Publicize
	wp_deregister_style( 'sharedaddy' ); // Sharedaddy
	wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
	wp_deregister_style( 'stats_reports_css' ); // Stats
	wp_deregister_style( 'jetpack-widgets' ); // Widgets
	wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
	wp_deregister_style( 'presentations' ); // Presentation shortcode
	wp_deregister_style( 'jetpack-subscriptions' ); // Subscriptions
	wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
	wp_deregister_style( 'widget-conditions' ); // Widget Visibility
	wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
	wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
	wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
	wp_deregister_style( 'jetpack-widgets' ); // Widgets
}
/**
 * Removes the deregistered Jetpack stylesheets
 */
add_action( 'wp_print_styles', 'saorsa_deregister_jetpack_styles', 100 );

/**
 * Sets Do-Not-Track for Jetpack stats
 */
// TODO: make this a customisable option
add_filter( 'jetpack_honor_dnt_header_for_stats', '__return_true' );