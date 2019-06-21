<?php
/**
 * Footer for individual posts
 * @package Saorsa
 * @since Saorsa 0.0.1
 */
?><footer class="post--footer">
    <?php
    if ( is_single() ) {
        saorsa_the_tags();
    }
    echo saorsa_get_syndication_links( $post );
    ?>
</footer>