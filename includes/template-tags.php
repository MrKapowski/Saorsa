<?php
/**
 * @package Saorsa
 * @since saorsa 0.0.1
 */
if ( ! function_exists( 'saorsa_the_tags' ) ) {
	function saorsa_the_tags() {
		$tags = get_the_tags();
		$html = '';
		if ( $tags ) {
			$html = '<ul class="tags">';
			foreach ( $tags as $tag ) {
				$tag_link = get_tag_link( $tag->term_id );

				$html .= '<li class="tags__item">' . "<a href='{$tag_link}' title='{$tag->name} Tag' class='tags__link {$tag->slug} p-category'>{$tag->name}</a></li>";
			}
			$html .= '</ul>';
		}
		echo wp_kses(
			$html,
			array(
				'ul'  => array(
					'class' => array(),
				),
				'li'  => array(
					'class' => array(),
				),
				'a'   => array(
					'class' => array(),
					'title' => array(),
					'href'  => array(),
				),
				'svg' => array(
					'class'       => array(),
					'title'       => array(),
					'aria-hidden' => array(),
					'role'        => array(),
				),
				'use' => array(
					'class'      => array(),
					'title'      => array(),
					'href'       => array(),
					'xlink:href' => array(),
				),
			)
		);
	}
}

if(!function_exists('saorsa_caption')) {
    function saorsa_caption( $output, $attr, $content = null ) {
        shortcode_atts(
            array(
                'id'      => '',
                'align'   => 'alignnone',
                'width'   => '',
                'caption' => '',
            ),
            $attr
        );

        if ( empty( $attr['caption'] ) ) {
            return $content;
        }

        if ( $attr['id'] ) {
            $attr['id'] = 'id="' . $attr['id'] . '" ';
        }

        return '<figure ' . $attr['id'] . 'class="figure wp-caption ' . $attr['align'] . '">'
        . do_shortcode( $content ) . '<figcaption class="figure__caption wp-caption-text">' . $attr['caption'] . '</figcaption></figure>';
    }

    add_filter( 'img_caption_shortcode', 'saorsa_caption', 3, 10 );
}

if (!function_exists('saorsa_gallery')) {
    function saorsa_gallery( $output, $attr, $instance ) {
        $post = get_post();

#        static $instance = 0;
#        $instance++;

        if ( ! empty( $attr['ids'] ) ) {
                // 'ids' is explicitly ordered, unless you specify otherwise.
                if ( empty( $attr['orderby'] ) ) {
                        $attr['orderby'] = 'post__in';
                }
                $attr['include'] = $attr['ids'];
        }

        $html5 = current_theme_supports( 'html5', 'gallery' );


        // $output = apply_filters( 'post_gallery', '', $attr, $instance );
        // if ( $output != '' ) {
        //         return $output;
        // }

        $atts = shortcode_atts(
            array(
                'order'      => 'ASC',
                'orderby'    => 'menu_order ID',
                'id'         => $post ? $post->ID : 0,
                'itemtag'    => $html5 ? 'figure' : 'dl',
                'icontag'    => $html5 ? 'div' : 'dt',
                'captiontag' => $html5 ? 'figcaption' : 'dd',
                'columns'    => 3,
                'size'       => 'thumbnail',
                'include'    => '',
                'exclude'    => '',
                'link'       => '',
            ),
            $attr,
            'gallery'
        );

        $id = intval( $atts['id'] );

        if ( ! empty( $atts['include'] ) ) {
            $_attachments = get_posts(
                array(
                    'include'        => $atts['include'],
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[ $val->ID ] = $_attachments[ $key ];
            }
        } elseif ( ! empty( $atts['exclude'] ) ) {
            $attachments = get_children(
                array(
                    'post_parent'    => $id,
                    'exclude'        => $atts['exclude'],
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );
        } else {
            $attachments = get_children(
                array(
                    'post_parent'    => $id,
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                )
            );
        }

        if ( empty( $attachments ) ) {
                return '';
        }

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                    $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
            }
            return $output;
        }

        $itemtag    = tag_escape( $atts['itemtag'] );
        $captiontag = tag_escape( $atts['captiontag'] );
        $icontag    = tag_escape( $atts['icontag'] );
        $valid_tags = wp_kses_allowed_html( 'post' );
        if ( ! isset( $valid_tags[ $itemtag ] ) ) {
                $itemtag = 'div';
        }
        if ( ! isset( $valid_tags[ $captiontag ] ) ) {
                $captiontag = 'figcaption';
        }
        if ( ! isset( $valid_tags[ $icontag ] ) ) {
                $icontag = 'figure';
        }

        $columns   = intval( $atts['columns'] );
        $itemwidth = floor( 12 / $columns ); //$columns > 0 ? floor( 100 / $columns ) : 100;
        $float     = is_rtl() ? 'right' : 'left';

        $selector = "gallery-{$instance}";

        $gallery_style = '';

        $size_class  = sanitize_html_class( $atts['size'] );
        $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

        /**
            * Filters the default gallery shortcode CSS styles.
            *
            * @since 2.5.0
            *
            * @param string $gallery_style Default CSS styles and opening HTML div container
            *                              for the gallery shortcode output.
            */
        $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

        $i = 0;
        foreach ( $attachments as $id => $attachment ) {

            $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
            if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
                    $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
            } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
                    $image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
            } else {
                    $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
            }
            $image_meta = wp_get_attachment_metadata( $id );

            $orientation = '';
            if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
                    $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
            }
            $output .= "<{$itemtag} class='gallery__item {$orientation}'>";
            $output .= "
                    <{$icontag} class='gallery__icon {$orientation}'>
                            $image_output
                    </{$icontag}>";
            if ( $captiontag && trim( $attachment->post_excerpt ) ) {
                    $output .= "
                            <{$captiontag} class='wp-caption-text gallery__caption' id='$selector-$id'>"
                            . wptexturize( $attachment->post_excerpt ) .
                            "</{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
        }

        $output .= "
                </div>\n";

        return $output;
    }
    add_filter( 'post_gallery', 'saorsa_gallery', 3, 10 );
}

if ( ! function_exists( 'saorsa_archive_title' ) ) {
	function saorsa_archive_title() {
		$title = get_the_archive_title();
		if ( ! empty( $title && is_string($title) ) ) {
			echo wp_kses(
				sprintf( '<h1>%1s — <span class="archive__term">%2s</span></h1>', __( 'Archive of', 'saorsa' ), $title ),
				array(
					'h1'   => array(),
					'span' => array(
						'class' => array(),
					),
				)
			);
		} else {
            print_r($title);
        }
	}
}
if ( ! function_exists( 'saorsa_render_webmention_form' ) ) {
    function saorsa_render_webmention_form() {
        if ( class_exists('Webmention_Plugin') ) {
            Webmention_Plugin::comment_form();
        }
    }
}

if ( ! function_exists( 'saorsa_date_header' ) ) {
    function saorsa_date_header( $tag = 'h2', $format = 'F j, Y' ) {
        $the_date = '';
        if ($the_date !== esc_html( get_the_date( $format ) )) {
            
            echo "<{$tag} class=\"date-header\">" . $the_date . "</{$tag}>";
            $the_date = esc_html( get_the_date( $format ) );
        }
    }
}