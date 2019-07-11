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
function saorsa_post_kind_metadata( $the_post ) {
	$the_mf2_post = new MF2_Post( $the_post );
	$the_kind     = $the_mf2_post->get( 'kind', true );
	$kind_info     = Kind_Taxonomy::get_kind_info( $the_kind, 'property' );
	$citation     = $the_mf2_post->fetch( $kind_info );
	return $citation;
}

// function saorsa_kind_title( $title ) {
//     if ( is_singular() && $id = get_queried_object_id() ) {
//         // Modify $title as required
//         $the_mf2_post = new MF2_Post( $the_post );
//         $author = array();
//         if ( isset( $citation['author'] ) ) {
//             $author = Kind_View::get_hcard( $citation['author'] );
//         }
//         $site_name = Kind_View::get_site_name( $citation );
//         $citation_title = Kind_View::get_cite_title( $citation );
//     }

//     return $title;
// }

if(defined('THE_SEO_FRAMEWORK_VERSION')){
    add_filter('the_seo_framework_title_from_generation', 'saorsa_kind_title', 30);
} else {
    add_filter('pre_get_document_title', 'saorsa_kind_title', 30);
}

function saorsa_kind_title( $title, $args = '' ) {
    //$title = empty($title) ? 'Untitled' : array( 'title' => $title);
    //$mod_title = array( 'title' => $in_title);
    if ($title === 'Untitled' && is_single() ) {
        //SEO Framework is returning the title
        $title = saorsa_make_untitled_title();
    } elseif(is_single() && single_post_title( '', false ) === '') {
        $title = array(
            'title' => saorsa_make_untitled_title(),
            'site' => get_bloginfo( 'name', 'display' )
        );
        //WordPress is generating the title, not SEOFW
        $sep = apply_filters( 'document_title_separator', '-' );
        $title = apply_filters( 'document_title_parts', $title );
    
        $title = implode( " $sep ", array_filter( $title ) );
        $title = wptexturize( $title );
        $title = convert_chars( $title );
        $title = esc_html( $title );
        $title = capital_P_dangit( $title );
    }

    return $title;
}

function saorsa_make_untitled_title() {
    
    $the_post = get_queried_object();

    $the_mf2_post = new MF2_Post( $the_post );
    $the_kind     = $the_mf2_post->get( 'kind', true );
    $singular     = Kind_Taxonomy::get_kind_info($the_kind, 'singular_name');
    $the_type     = Kind_Taxonomy::get_kind_info( $the_kind, 'property' );
    $citation     = $the_mf2_post->fetch( $the_type );
    if ( is_array( $citation['url'] ) ) {
        $citation['url'] = $citation['url'][0];
    }
    if ( ! array_key_exists( 'name', $citation ) ) {
        $citation['name'] = Kind_View::get_post_type_string( $citation['url'] );
    }
    $verb         = Kind_Taxonomy::get_kind_info( $the_kind, 'verb' ) ?? $singular;
    if ( isset($citation['name']) ) {
        return sprintf(
            '%s "%s", at %s, %s ',
            $verb,
            $citation['name'],
            get_the_time( 'g:i a', $the_post ),
            get_the_date('F j, Y', $the_post)
        );
    } elseif (isset($citation['url'])) {
        return sprintf(
            '%s %s, at %s, %s ',
            $verb,
            Kind_View::get_post_type_string($citation['url']),
            get_the_time( 'g:i a', $the_post ),
            get_the_date('F j, Y', $the_post)
        );
    } else {
        return sprintf(
            'Untitled %s at %s, %s ',
            $singular,
            get_the_time( 'g:i a', $the_post ),
            get_the_date('F j, Y', $the_post)
        );
    }
}