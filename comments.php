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
					<aside class="post--comments">
							<header class="post--comments--header">
								<h2 class="post--comments--heading">
									<?php
									printf(
										// translators:
										esc_html( _nx( '%s Responses', '%s Responses', get_comments_number(), 'comments title', 'saorsa' ) ),
										esc_html( number_format_i18n( get_comments_number() ) ),
										'<span>' . esc_html( get_the_title() ) . '</span>'
									);
									?>
								</h2>
							</header>
							<?php if ( have_comments() ) : ?>
							<section class="comments">
								<h3 class="comments--section--title">Comments</h3>
								
								<ol class="comments--list">
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
								<p class="post--comments--no-comments"><?php esc_html_e( 'Responses are closed.', 'saorsa' ); ?></p>
							</section>
							<?php endif; ?>
							
							<footer>
								<section>
									<div id="commentform-top"></div>
									<?php comment_form( saorsa_comment_form_args() ); ?>
								</section>
								<?php saorsa_webmention_form(); ?>
							</footer>
					</aside>