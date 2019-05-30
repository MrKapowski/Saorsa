<?php
/**
 * @package Saorsa
 * @since saorsa 0.0.1
 */
function saorsa_post_type() {
    if (function_exists( 'has_post_kind' ) && has_post_kind()) {
        return get_post_kind_slug();
    }
    return get_post_format();
}