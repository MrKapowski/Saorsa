<?php
/**
 * Custom comment walker for this theme
 *
 * @package Saorsa
 * @since 0.0.1
 */

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 *
 * @since 0.0.1
 */
class Saorsa_Walker_Comment extends Walker_Comment {
	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$comment_content_class = ''; // Used to style the comment-content differently when comment is awaiting moderation
		$cite                  = apply_filters( 'semantic_linkbacks_cite', '<small>&nbsp;@&nbsp;<cite><a href="%1s">%2s</a></cite></small>' );
		$author_link = get_comment_author_url($comment);
		$author = get_comment_author( $comment );
		?>
			<li <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?> id="li-comment-<?php comment_ID( $comment ); ?>">
				<article class="u-comment h-cite">
					<header class="u-author vcard h-card">
						<h6 class="p-name">
						<?php
							
							if ( isset($author_link) ) :						
						?>
							<a href="<?php echo esc_url( $author_link ); ?>" class="u-url"><?php echo esc_html($author); ?></a>
						<?php else: ?>
							<?php echo esc_html($author); ?>
						<?php endif; ?>
						</h6>
						<?php echo get_avatar( $comment, 64, '', "Avatar for {$author}", Array('class' => 'u-photo') ); ?>
						<?php if ( '0' === $comment->comment_approved ) : ?>
							<?php $comment_content_class = 'unapproved'; ?>
							<em><?php esc_html_e( ' - Your comment is awaiting moderation.', 'saorsa' ); ?></em>
						<?php endif; ?>
					</header>
					<div class="comment-content p-content p-name <?php echo esc_html( $comment_content_class ); ?>">
						<?php comment_text(); ?>
					</div>
					<footer>
						Posted @ <a href="<?php echo esc_url( get_comment_link() ); ?>" class="comment-link">
							<time pubdate datetime="<?php comment_time( 'c' ); ?>" class="dt-published">
								<?php echo esc_html( get_comment_date() ); ?>
							</time>
						</a><?php self::saorsa_semantic_cite( $comment ); ?>
						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
									'class'     => 'comment-reply-link',
								)
							)
						);
						?>
					</footer>
				</article>
		<?php
	}

	/**
	 * Get the comment Citation Link, if we're using Semantic Linkbacks
	 * @since K 0.8.4
	 */
	protected function saorsa_semantic_cite( $comment ) {
		if ( class_exists( 'Linkbacks_Handler' ) ) {
			$cite  = apply_filters( 'saorsa_semantic_cite', '&nbsp;via <cite><a class="u-url" rel="external" href="%1s">%2s</a></cite>' );
			$type  = Linkbacks_Handler::get_type( $comment );
			$url   = Linkbacks_Handler::get_url( $comment );
			$coins = Linkbacks_Handler::get_prop( $comment, 'mf2_swarm-coins' );
			$host  = wp_parse_url( $url, PHP_URL_HOST );
			if ( $type && ! empty( $cite ) ) {
				echo wp_kses(
					sprintf( $cite, $url, $host ),
					array(
						'cite' => array(),
						'a'    => array(
							'class' => array(),
							'href'  => array(),
							'rel'   => array(),
						),
					)
				);
			}
		}
	}
}
