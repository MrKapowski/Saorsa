<?php
/**
 * The template for displaying Comments.
 *
 * @package K
 * @since   K 0.5
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

							<header>
								<h4 class="comments-title">
									<?php
									printf(
										// translators:
										esc_html( _nx( '%s Responses', '%s Responses', get_comments_number(), 'comments title', 'saorsa' ) ),
										esc_html( number_format_i18n( get_comments_number() ) ),
										'<span>' . esc_html( get_the_title() ) . '</span>'
									);
									?>
								</h4>
							</header>
							<?php if ( have_comments() ) : ?>
							<section class="comments">
								<h5>Comments</h5>
								
								<ol class="comment-list">
									<?php
										wp_list_comments(
											array(
												'type' => 'comment',
											)
										);
									?>
								</ol><!-- .comment-list -->
							</section>
							<?php do_action( 'comment_mentions' ); ?>
							<?php endif; ?>
							<?php if ( ! comments_open() && get_comments_number() ) : ?>
							<section class="comments">
								<p class="no-comments"><?php esc_html_e( 'Responses are closed.', 'saorsa' ); ?></p>
							</section>
							<?php endif; ?>
							
							<footer>
							<?php // if ( comments_open() ) : ?>
								<div id="commentform-top"></div>
								<?php comment_form( saorsa_comment_form_args() ); ?>
							<?php // endif; ?>
							</footer>
