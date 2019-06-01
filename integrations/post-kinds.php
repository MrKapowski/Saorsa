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
add_action( 'wp_loaded', 'saorsa_child_kinds_init' );
/**
 * Overrides Post-Kinds Author output
 * @since saorsa 0.0.1
 */
function saorsa_kind_hcard( $string, $author, $args ) {
    if(isset($author['name'])) {
        if (isset($author['url'])) {
            return sprintf( '<a class="h-card p-author" rel="external" href="%1s">%2s</a>', $author['url'], $author['name'] );
        }else{
            return sprintf( '<span class="h-card p-author">%1s</a>', $author['name'] );
        }   
    }
    return '';
}
/**
 * Filters the webmention form, so our custom template is applied
 */
add_filter( 'get_hcard', 'saorsa_kind_hcard', 10, 3 );
/**
 * Get Post-Kind metadata
 */
function saorsa_post_kind_metadata( $post ) {
	$mf2_post = new MF2_Post( $post );
	$kind     = $mf2_post->get( 'kind', true );
	$info     = Kind_Taxonomy::get_kind_info( $kind, 'property' );
	$cite     = $mf2_post->fetch( $info );
	return $cite;
}

// function saorsa_kind_title( $title ) {
//     if ( is_singular() && $id = get_queried_object_id() ) {
//         // Modify $title as required
//         $mf2_post = new MF2_Post( $post );
//         $author = array();
//         if ( isset( $cite['author'] ) ) {
//             $author = Kind_View::get_hcard( $cite['author'] );
//         }
//         $site_name = Kind_View::get_site_name( $cite );
//         $cite_title = Kind_View::get_cite_title( $cite );
//     }

//     return $title;
// }

if(defined('THE_SEO_FRAMEWORK_VERSION')){
    add_filter('the_seo_framework_title_from_generation', 'saorsa_kind_title', 30, 1);
} else {
    add_filter('pre_get_document_title', 'saorsa_kind_title', 30, 1);
}

function saorsa_kind_title( $title ) {
    $post = get_queried_object();
    if ($title === 'Untitled' && is_single() ) {
        $mf2_post = new MF2_Post( $post );
        $kind     = $mf2_post->get( 'kind', true );
        $singular = Kind_Taxonomy::get_kind_info($kind, 'singular_name');
        $type     = Kind_Taxonomy::get_kind_info( $kind, 'property' );
        $cite     = $mf2_post->fetch( $type );
        $verb   = Kind_Taxonomy::get_kind_info( $kind, 'verb' ) ?? $singular;
        if ( isset($cite['name']) ) {
            return sprintf(
                '%s "%s", at %s, %s ',
                $verb,
                $cite['name'],
                get_the_time( 'g:i a', $post ),
                get_the_date('F j, Y', $post)
            );
        }
        if (isset($cite['url'])) {
            return sprintf(
                '%s %s, at %s, %s ',
                $verb,
                Kind_View::get_post_type_string($cite['url']),
                get_the_time( 'g:i a', $post ),
                get_the_date('F j, Y', $post)
            );
        }
        return sprintf(
            '%s at %s, %s ',
            $singular,
            get_the_time( 'g:i a', $post ),
            get_the_date('F j, Y', $post)
        );
    }
    return $title;
}