<?php
/**
 * Saorsa functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package Saorsa
 * @since Saorsa 0.0.1
 */

if ( ! isset( $content_width ) ) {
	$content_width = 825;
}
add_filter( 'show_admin_bar', '__return_false' );

if (!function_exists('saorsa_setup')) {
    function saorsa_setup() {
        // Ask WP to output in "HTML5 mode"
        add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets',
			)
        );
        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );
        // Add support for the Aside, Gallery Post Formats...
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'gallery',
				'link',
				'status',
				'image',
				'video',
				'audio',
				'quote',
			)
		);
		// Nicer WYSIWYG editor
		add_theme_support( 'editor-styles' );
        add_editor_style( 'css/editor-style.css' );
        // Make oEmbeds responsive
        add_theme_support( 'responsive-embeds' );
        // Saorsa <3 microformats
		add_theme_support( 'microformats2' );
		add_theme_support( 'microformats' );
		add_theme_support( 'microdata' );
		add_theme_support( 'indieweb' );
		// Title Tags
		add_theme_support( 'title-tag' );
        /**
         * The next few items will probably change or be removed during development
         */
        // Translation support
        load_theme_textdomain( 'saorsa', get_template_directory() . '/languages' );
        // custom logo support
		add_theme_support(
			'custom-logo',
			array(
				'height' => 75,
				'width'  => 75,
			)
		);
		// This theme supports a custom header
		$custom_header_args = array(
			'width'       => 1250,
			'height'      => 600,
			'header-text' => true,
		);
		add_theme_support( 'custom-header', $custom_header_args );
        // Nicer WYSIWYG editor
		add_theme_support( 'editor-styles' );
        add_editor_style( 'css/editor-style.css' );
        // This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'saorsa' ),
		) );
    }
}
// Run saorsa_setup() when the 'after_setup_theme' hook is run.
add_action( 'after_setup_theme', 'saorsa_setup' );

if ( ! function_exists( 'saorsa_enqueue_scripts' ) ) {
	/**
	 * Enqueue theme scripts
	 *
	 * @uses wp_enqueue_scripts() To enqueue scripts
	 *
	 * @since saorsa 1.0.0
	 */
	function saorsa_enqueue_scripts() {
		/*
		 * Adds JavaScript to pages with the comment form to support sites with
		 * threaded comments (when in use).
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Loads our main stylesheet.
		wp_enqueue_style('saorsa-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'), false);
		//wp_enqueue_style( 'saorsa-style', get_stylesheet_uri(), array( 'dashicons' ) );

		wp_localize_script(
			'saorsa',
			'vars',
			array(
				'template_url' => get_template_directory_uri(),
			)
		);

		if ( has_header_image() ) {
			if ( is_author() ) {
				$css = '.page-banner {
					background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)), url(' . get_header_image() . ') no-repeat center center scroll;
				}' . PHP_EOL;
			} else {
				$css = '.page-banner {
					background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7)), url(' . get_header_image() . ') no-repeat center center scroll;
				}' . PHP_EOL;
			}

			wp_add_inline_style( 'saorsa-style', $css );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'saorsa_enqueue_scripts' );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
if(!function_exists('saorsa_page_menu_args')){
	function saorsa_page_menu_args( $args ) {
		$args['show_home'] = true;

		return $args;
	}
	
}
add_filter( 'wp_page_menu_args', 'saorsa_page_menu_args' );

if(!function_exists('saorsa_nav_menu_attributes_filter')){
	function saorsa_nav_menu_attributes_filter($var) {
		return is_array($var) ? array_intersect($var, array('menu__item--current')) : '';
	}
}
add_filter('nav_menu_css_class', 'saorsa_nav_menu_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'saorsa_nav_menu_attributes_filter', 100, 1);

add_filter('posts_orderby', 'saorsa_posts_orderby');

function saorsa_posts_orderby($orderby_for_query) {
    $orderby_for_query = "LEFT(wp_posts.post_date, 10) DESC, wp_posts.post_date ASC";
    return $orderby_for_query;
} 

/**
 * Register  the sidebar Widgets area
 */
if(!function_exists('saorsa_sidebar')){
	function saorsa_sidebar() {
		$args = array(
			'id'            => 'main-sidebar',
			'name'          => __( 'Main Sidebar', 'saorsa' ),
			'description'   => __( 'Secondary Content Sidebar.', 'saorsa' ),
			'before_title'  => '<h3 class="widget__title">',
			'after_title'   => '</h3>',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
		);
		register_sidebar( $args );
		$args = array(
			'id'            => 'second-sidebar',
			'name'          => __( 'Secondary Sidebar', 'saorsa' ),
			'description'   => __( 'Tertiary Content Sidebar.', 'saorsa' ),
			'before_title'  => '<h3 class="widget__title">',
			'after_title'   => '</h3>',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
		);
		register_sidebar( $args );
	}
}
/**
 * Adds the widget area to the control panel
 */
add_action( 'widgets_init', 'saorsa_sidebar' );

/**
 * Re-enable the built-in Links manager. If you want to turn this off,
 * create a child theme, and add this to functions.php:
 * add_filter( 'pre_option_link_manager_enabled', '__return_false' );
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

// All template functions
require( get_template_directory() . '/includes/template-functions.php' );

// Any custom template tags
require( get_template_directory() . '/includes/template-tags.php' );

// Widget handling
require( get_template_directory() . '/includes/widgets.php' );

// Adds the featured image functionality
require( get_template_directory() . '/includes/featured-image.php' );

// Adds some awesome websemantics like microformats(2) and microdata
require( get_template_directory() . '/includes/semantics.php' );

// Adds back compat handling for older WP versions
require( get_template_directory() . '/includes/compat.php' );

/**
 * Custom Comment Walker template.
 * @since saorsa 0.0.1
 */
require get_template_directory() . '/classes/class-saorsa-walker-comment.php';

// Compatibility with other plugins, mostly IndieWeb related
if ( defined( 'SYNDICATION_LINKS_VERSION' ) ) {
	require( get_template_directory() . '/integrations/syndication-links.php' );
}
if ( class_exists('Post_Kinds_Plugin') ) {
	require( get_template_directory() . '/integrations/post-kinds.php' );
}
if ( class_exists('\Activitypub\Activitypub') ) {
	require( get_template_directory() . '/integrations/activitypub.php' );
}
if ( class_exists('Hum') ) {
	require( get_template_directory() . '/integrations/hum.php' );
}
if ( function_exists( 'send_webmention' ) ) {
	require( get_template_directory() . '/integrations/webmentions/webmentions.php' );
}
if ( class_exists('Semantic_Linkbacks_Plugin') ) {
	require( get_template_directory() . '/integrations/semantic-linkbacks/semantic-linkbacks.php' );
}
if ( class_exists('IndieWeb_Plugin') ) {
	require( get_template_directory() . '/integrations/indieweb.php' );
}
if ( class_exists('\Roots\Soil\Options') ) {
	require( get_template_directory() . '/integrations/soil.php' );
}