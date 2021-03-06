<?php

function saorsa_syndication_links_init() {
	remove_filter( 'the_content', array( 'Syn_Config', 'the_content' ), 30 );
	add_filter( 'syn_links_display_defaults', 'saorsa_syndication_links_defaults' );
}
add_action( 'wp_loaded', 'saorsa_syndication_links_init' );

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
		'container-css'    => 'relsyn syndication',
		'list-item-css'    => 'syn-item syndication__item',
		'single-css'       => 'syn-link syndication__link',
		'text-css'         => 'syn-text syndication__text',
		'show_text_before' => true,
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
