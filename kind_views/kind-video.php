<?php
/*
 * Video Template
 *
 */
$mf2_post = new MF2_Post( $post );
$videos = $mf2_post->get_videos();
if ( is_array( $videos ) && ( count( $videos ) > 1 ) ) {
	foreach ( $videos as $video ) {
		$video_attachment = new MF2_Post( $video );
		$cite             = $video_attachment->get();
	}
}
$photos      = $mf2_post->get_images();
$first_photo = null;
if ( is_countable( $photos ) ) {
	$first_photo = $photos[0];
}
$embed = null;
if ( is_array( $cite ) && ! $videos ) {
	$url   = ifset( $cite['url'] );
	$embed = Kind_View::get_embed( $url );
	if ( ! $embed ) {
		$view = new Kind_Media_View( $url, 'video' );
		$embed = $view->get();
	}
}


?>
<section class="response u-watch-of h-cite">
<header>
<?php
echo Kind_Taxonomy::get_before_kind( 'video' );
//if ( ! $embed ) {
	if ( $name ) {
		echo $name;
	}
	if ( $author ) {
		echo ' ' . __( 'by', 'indieweb-post-kinds' ) . ' ' . $author;
	}
	if ( $site_name ) {
		echo __( ' from ', 'indieweb-post-kinds' ) . '<em>' . $site_name . '</em>';
	}
	if ( $duration ) {
		echo '(<data class="p-duration" value="' . $duration . '">' . Kind_View::display_duration( $duration ) . '</data>)';
	}
//}
?>
</header>
<?php
if ( $embed ) {
	printf( '<div class="embed-responsive embed-responsive-16by9 e-summary">%1s</div>', $embed );
} elseif ( $videos ) {

	$poster = wp_get_attachment_image_url( $first_photo, 'full' );
	$view = new Kind_Media_View( $videos, 'video' );
	echo $view->get();
}
?>
<?php
if ( $cite ) {
	if ( array_key_exists( 'summary', $cite ) ) {
		echo sprintf( '<blockquote class="e-summary">%1s</blockquote>', wpautop( $cite['summary'] ) );
	}
}

// Close Response
?>
</section>
<?php
