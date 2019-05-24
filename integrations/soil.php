<?php
/**
 * @package Saorsa
 * @since Saorsa 0.0.1
 */

function saorsa_soil_init() {
    add_theme_support( 'soil-clean-up' );
    add_theme_support( 'soil-jquery-cdn' );
    add_theme_support( 'soil-js-to-footer' );
    add_theme_support( 'soil-nav-walker' );
    add_theme_support( 'soil-nice-search' );
}
add_action( 'after_setup_theme', 'saorsa_soil_init' );