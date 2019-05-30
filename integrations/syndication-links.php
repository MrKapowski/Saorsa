<?php

function saorsa_deregister_synlinks_styles() {
    wp_deregister_style( 'syndication-style' );
}
add_action( 'wp_print_styles', 'saorsa_deregister_synlinks_styles', 100 );

/**
 * Overrides Syndication Links output
 * @since saorsa 0.0.1
 */
function saorsa_syndication_links_defaults() {
	$display  = Syn_Meta::get_syndication_links_display_option();
	$defaults = array(
		'style'            => 'ul',
		'text'             => in_array( $display, array( 'text', 'iconstext' ), true ),
		'icons'            => in_array( $display, array( 'icons', 'iconstext' ), true ),
		'container-css'    => 'relsyn',
		'list-item-css'    => 'syn-item',
		'single-css'       => 'syn-link',
		'text-css'         => 'syn-text',
		'show_text_before' => false,
	);
	return $defaults;
}

function saorsa_get_syndication_links( $object = null, $args = array() ) {
	$r = wp_parse_args( $args, saorsa_syndication_links_defaults() );

	$links = Syn_Meta::get_syndication_links_elements( $object, $r );
	if ( empty( $links ) ) {
		return '';
	}

	if ( $r['show_text_before'] ) {
		$textbefore = Syn_Meta::get_syndication_links_text_before( $r['text-css'] );
	} else {
		$textbefore = '';
	}

	switch ( $r['style'] ) {
		case 'p':
			$before = '<p class="' . $r['container-css'] . '"><span>';
			$sep    = '</span><span>';
			$after  = '</span></p>';
			break;
		case 'ol':
			$before = '<ol class="' . $r['container-css'] . '"><li class="' . $r['list-item-css'] . '">';
			$sep    = '</li><li class="' . $r['list-item-css'] . '">';
			$after  = '</li></ol>';
			break;
		case 'span':
			$before = '<span class="' . $r['container-css'] . '">';
			$sep    = ' ';
			$after  = '</span>';
			break;
		default:
			$before = '<ul class="' . $r['container-css'] . '"><li class="' . $r['list-item-css'] . '">';
			$sep    = '</li><li class="' . $r['list-item-css'] . '">';
			$after  = '</li></ul>';
	}

	return $textbefore . $before . join( $sep, $links ) . $after;
}
