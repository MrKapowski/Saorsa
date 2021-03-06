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
					<aside class="reactions">
							<header class="reactions__header">
								<h2 class="reactions__heading">
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
								<h3 class="comments__title">Comments</h3>
								
								<ol class="comments__list hfeed h-feed p-comments">
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
								<p class="reactions__no-comments"><?php esc_html_e( 'Responses are closed.', 'saorsa' ); ?></p>
							</section>
							<?php endif; ?>
							
							<footer class="reactions__footer">
								<section class="reactions__reply">
									<div id="commentform-top"></div>
									<?php comment_form( saorsa_comment_form_args() ); ?>
								</section>
								<?php saorsa_render_webmention_form(); ?>
							</footer>
					</aside>