<?php
/**
 * @package Saorsa
 * @since saorsa 0.0.1
 */
function saorsa_post_type() {
    if (function_exists( 'get_post_kind_slug' ) ) {
        return get_post_kind_slug();
    }
    return get_post_format();
}

if ( ! function_exists( 'saorsa_the_posts_navigation' ) ) {
	/**
	 * Documentation for function.
	 */
	function saorsa_the_posts_navigation() {
		if ( function_exists( 'wp_pagenavi' ) ) {
			wp_pagenavi();
		} elseif ( function_exists( 'wp_paginate' ) ) {
			wp_paginate();
		} else {
			saorsa_post_navigation();
		}
	}
}

function saorsa_post_navigation() {
	if ( is_singular() ) {
		return;
	}
	global $wp_query;
	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}
	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );
	/** Add current page to the array */
	if ( $paged >= 1 ) {
		$links[] = $paged;
	}
	/** Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}
	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}
	$html = '<ul class="pagination">';
	/** Previous Post Link */
	if ( get_previous_posts_link() ) {
		$html .= sprintf( '<li class="page-item">%s</li>' . "\n", get_previous_posts_link() );
	} else {
		$html .= sprintf( '<li class="page-item disabled"><span class="page-link">« %1s</span></li>' . "\n", __( 'Previous Page', 'saorsa' ) );
	}
	/** Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links, true ) ) {
		$class = ( 1 === $paged ) ? ' class="page-item active"' : '';
		$html .= sprintf( '<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
		if ( ! in_array( 2, $links, true ) ) {
			$html .= '<li class="page-item disabled"><span class="page-link">…</span></li>';
		}
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = ( $paged === $link ) ? ' class="page-item active"' : '';
		$html .= sprintf( '<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/** Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links, true ) ) {
		if ( ! in_array( $max - 1, $links, true ) ) {
			$html .= '<li class="page-item disabled"><span class="page-link">…</span></li>' . "\n";
		}

		$class = ( $paged === $max ) ? ' class="page-item active"' : '';
		$html .= sprintf( '<li%s><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/** Next Post Link */
	if ( get_next_posts_link() ) {
		$html .= sprintf( '<li class="page-item">%s</li>' . "\n", get_next_posts_link() );
	} else {
		$html .= '<li class="page-item disabled"><span class="page-link">Next Page »</span></li>' . "\n";
	}

	$html .= '</ul>' . "\n";

	echo wp_kses(
		$html,
		array(
			'ul'   => array(
				'class' => array(),
			),
			'li'   => array(
				'class' => array(),
			),
			'a'    => array(
				'class' => array(),
				'title' => array(),
				'href'  => array(),
			),
			'span' => array(
				'class' => array(),
			),
		)
	);
}

function posts_link_attributes() {
	return 'class="page-link"';
}
add_filter( 'next_posts_link_attributes', 'posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'posts_link_attributes' );

if ( ! function_exists( 'saorsa_header_class' ) ) {
	function saorsa_header_class() {
		if ( ( ! has_post_format() ) || has_post_kind( 'article' ) || is_single() ) {
			echo esc_attr( 'h1' );
		} else {
			echo esc_attr( 'h3' );
		}
	}
}