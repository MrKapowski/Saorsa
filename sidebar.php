<?php
/**
 * Sidebar template for Saorsa
 * @package Saorsa
 * @since saorsa 0.0.1
 */
?><aside id="secondary-content"  aria-labelledby="secondary-content-label" class="sidebar sidebar--primary">
    <h2 id="secondary-content-label" hidden>Secondary Content</h2>
    <?php dynamic_sidebar( 'main-sidebar' ); ?>
</aside>
<aside id="tertiary-content" aria-labelledby="tertiary-content-label" class="sidebar sidebar--secondary">
    <h2 id="tertiary-content-label" hidden>Tertiary Content</h2>
    <?php dynamic_sidebar( 'second-sidebar' ); ?>
</aside>