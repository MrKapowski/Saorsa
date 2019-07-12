<?php
/*
 * Audio Template
 *
 */
$mf2_post = new MF2_Post( $post );
$audios = $mf2_post->get_audios();
$a = $mf2_post->get( 'audio' );
$author = null;
$duration = null;
$publication = null;
if ( $audios && is_array( $audios ) ) {
	foreach( $audios as $audio ) {
		if ( wp_http_validate_url( $audio ) ) {
			$audio = attachment_url_to_postid( $audio );
		}
		if ( is_numeric( $audio ) ) {
			$audio_attachment = new MF2_Post( $audio );
		}
	}
}



if ( $cite && ! $audios ) {
	$url   = ifset( $cite['url'] );
	$embed = Kind_View::get_embed( $url );
	if ( ! $embed ) {
		$view = new Kind_Media_View( $audios, 'photo' );
		echo $view->get();
	}
}

$duration = $mf2_post->get( 'duration', true );
if ( ! $duration ) {
	$duration = calculate_duration( $mf2_post->get( 'dt-start' ), $mf2_post->get( 'dt-end' ) );
}

?>
<section class="response">
<header>
<?php
echo Kind_Taxonomy::get_before_kind( 'audio' );
if ( isset( $cite['name'] ) ) {
	printf( '<span class="p-name">%1s</a>', $cite['name'] );
}

if ( $duration ) {
	printf( '(<data class="p-duration" value="%1$s">%2$s</data>', $duration, Kind_View::display_duration( $duration ) );
}

?>
</header>
</section>
<?php
if ( $embed ) {
	printf( '<blockquote class="e-summary">%1s</blockquote>', $embed );
} elseif ( $audios ) {
	$view = new Kind_Media_View( $audios, 'audio' );
	echo $view->get();
}
