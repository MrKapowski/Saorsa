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
	$html = '<ul class="pagination--list">';
	/** Previous Post Link */
	if ( get_previous_posts_link() ) {
		$html .= sprintf( '<li class="pagination--list--item">%s</li>' . "\n", get_previous_posts_link() );
	} else {
		$html .= sprintf( '<li class="pagination--list--item disabled"><span class="pagination--list--link">« %1s</span></li>' . "\n", __( 'Previous Page', 'saorsa' ) );
	}
	/** Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links, true ) ) {
		$class = ( 1 === $paged ) ? ' class="pagination--list--item active"' : '';
		$html .= sprintf( '<li%s><a href="%s" class="pagination--list--link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
		if ( ! in_array( 2, $links, true ) ) {
			$html .= '<li class="pagination--list--item disabled"><span class="pagination--list--link">…</span></li>';
		}
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = ( $paged === $link ) ? ' class="pagination--list--item active"' : '';
		$html .= sprintf( '<li%s><a href="%s" class="pagination--list--link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/** Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links, true ) ) {
		if ( ! in_array( $max - 1, $links, true ) ) {
			$html .= '<li class="pagination--list--item disabled"><span class="pagination--list--link">…</span></li>' . "\n";
		}

		$class = ( $paged === $max ) ? ' class="pagination--list--item active"' : '';
		$html .= sprintf( '<li%s><a href="%s" class="pagination--list--link">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/** Next Post Link */
	if ( get_next_posts_link() ) {
		$html .= sprintf( '<li class="pagination--list--item">%s</li>' . "\n", get_next_posts_link() );
	} else {
		$html .= '<li class="pagination--list--item disabled"><span class="pagination--list--link">Next Page »</span></li>' . "\n";
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
	return 'class="pagination--list--link"';
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

/**
 * Add useful extra classes to images, for layout and MF2
 */
function saorsa_add_image_classes( $class ) {
	$classes = array( 'u-photo' );
	$class  .= ' ';
	$class  .= implode( ' ', $classes );
	return $class;
}
function saorsa_add_attachment_classes( $attr, $attachment, $size ) {
	if ( isset( $attr['class'] ) && strpos($attr['class'], 'custom-logo') === false ) {
		$attr['class'] .= ' u-photo';
	}
	return $attr;
}
/**
 * Remove width and height from editor images, for responsiveness
 */
function saorsa_remove_image_dimensions( $html ) {
	$html = preg_replace( '/(height|width)=\"\d*\"\s?/', '', $html );
	return $html;
}
/**
 * Filter inserted images, to apply our customisations
 */
add_filter( 'get_image_tag_class', 'saorsa_add_image_classes' );
add_filter( 'wp_get_attachment_image_attributes', 'saorsa_add_attachment_classes', 10, 3 );
/**
 * Filter thumbnails, to apply our customisations
 */
add_filter( 'post_thumbnail_html', 'saorsa_remove_image_dimensions', 10 );
/**
 * Filter images in the editor, to apply our customisations
 */
add_filter( 'image_send_to_editor', 'saorsa_remove_image_dimensions', 10 );
/**
 * Filter images in the content, to apply our customisations
 */
add_filter( 'the_content', 'saorsa_remove_image_dimensions', 30 );

if ( !function_exists( 'saorsa_deregister_default_styles' ) ) {
	function saorsa_deregister_default_styles() {
		//Get rid of Dashicons stylesheet
		wp_deregister_style( 'dashicons' );
		//Get rid of default Gutenberg styles
		wp_deregister_style( 'wp-block-library' );
	}
}
/**
 * Removes the deregistered Jetpack stylesheets
 */
add_action( 'wp_print_styles', 'saorsa_deregister_default_styles', 100 );


/**
 * Registers the custom walker for this theme
 * @since K 0.8.4
 */
if ( ! function_exists( 'saorsa_filter_comment_args' ) ) {
	function saorsa_filter_comment_args( $args ) {
		$args['walker'] = new Saorsa_Walker_Comment();
		return $args;
	}
}
/**
 * Returns the number of webmentions, pings/trackbacks the current post has.
 * Originally found in functions.php
 * @since 0.3
 */
if ( ! function_exists( 'saorsa_comment_count_mentions' ) ) {
	function saorsa_comment_count_mentions() {
		$args   = array(
			'post_id'  => get_the_ID(),
			'type__in' => array( 'pings', 'webmention' ),
		);
		$_query = new WP_Comment_Query();
		return count( $_query->query( $args ) );
	}
}

/**
 * Formats the comment form into markup compatible with the K theme.
 */
if ( ! function_exists( 'saorsa_comment_form_args' ) ) {
	function saorsa_comment_form_args() {
		if ( ! is_user_logged_in() ) {
			$comment_notes_before = '';
			$comment_notes_after  = '';
		} else {
			$comment_notes_before = '';
			$comment_notes_after  = '';
		}

		$user          = wp_get_current_user();
		$commenter     = wp_get_current_commenter();
		$req           = get_option( 'require_name_email' );
		$aria_req      = ( $req ? " aria-required='true'" : '' );
		$consent       = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
		$login_link    = sprintf(// translators:
			__( 'You must be <a href="%s">logged in</a> to post a comment.', 'saorsa' ),
			wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		);
		$loggedin_link = sprintf(// translators:
			__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'saorsa' ),
			admin_url( 'profile.php' ),
			$user->display_name,
			wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
		);

		$args = array(
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_form'		   => 'comment--form',
			'title_reply'          => 'Leave a comment',
			'title_reply_before'   => '<h2 class="comment--form--title">',
			'title_reply_after'   => '</h2>',
			// translators:
			'title_reply_to'       => __( 'Leave a Reply for %s', 'saorsa' ),
			'cancel_reply_link'    => __( 'Cancel Reply', 'saorsa' ),
			'label_submit'         => __( 'Submit Comment', 'saorsa' ),
			'must_log_in'          => '<p class="comment--form--text must-log-in">' . $login_link . '</p>',
			'logged_in_as'         => '<p class="comment--form--text logged-in-as">' . $loggedin_link . '</p>',
			'comment_notes_before' => $comment_notes_before,
			'comment_notes_after'  => $comment_notes_after,
			'fields'               => apply_filters(
				'comment_form_default_fields',
				array(
					'author'  =>
						'<div class=""><div class="comment--form--author"><label for="author" class="sr-only">' . __( 'Name', 'saorsa' ) . '</label>' . ( $req ? '' : '' ) .
						'<input id="author" class="" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
						'"' . $aria_req . ' placeholder=' . __( 'Name', 'saorsa' ) . '></div>',
					'email'   =>
						'<div class="comment--form--email"><label for="email" class="sr-only">' . __( 'Email', 'saorsa' ) . '</label>' . ( $req ? '' : '' ) .
						'<input id="email" class="" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
						'"' . $aria_req . ' placeholder=' . __( 'Email', 'saorsa' ) . '></div>',
					'url'     =>
						'<div class="comment--form--url"><label for="url" class="sr-only">' . __( 'Website', 'saorsa' ) . '</label>' .
						'<input id="url" class="" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
						'" placeholder=' . __( 'Website', 'saorsa' ) . '></div></div>',
					'cookies' => '<div class="comment--form--consent"><input class="" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
					'<label for="wp-comment-cookies-consent" class="form-check-label">' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'saorsa' ) . '</label></div>',
				)
			),
		);

		return $args;
	}
}
/**
 * Recreates the comment form textarea HTML for reinclusion in comment form
 */
if ( ! function_exists( 'saorsa_add_textarea' ) ) {
	function saorsa_add_textarea() {
		$arg['comment_field'] = '<div class="form-row"><div class="form-group col-md-12 comment-form-comment"><label for="comment">' . __( 'Comment', 'saorsa' ) . '</label>' .
		'<textarea class="" id="comment" name="comment" cols="60" rows="6" aria-required="true"></textarea></div></div>';
		return $arg;
	}
}

/**
 * Adds additional classes to the submit button on the comment form
 */
if ( ! function_exists( 'saorsa_submit_button' ) ) {
	function saorsa_submit_button( $submit_field ) {
		$changed_submit = str_replace( 'name="submit" type="submit" id="submit"', 'name="submit" type="submit" id="submit" class="comment--form--button"', $submit_field );
		return $changed_submit;
	}
}
/**
 * Filters wp_list_comments $args to apply our Walker_Comment
 * @since K 0.8.4
 */
add_filter( 'wp_list_comments_args', 'saorsa_filter_comment_args' );

/**
 * Adds the reformatted textarea into the comment form
 */
add_action( 'comment_form_defaults', 'saorsa_add_textarea' );

/**
 * Filters the comment form, to add our customised submit button
 */
add_filter( 'comment_form_submit_field', 'saorsa_submit_button' );