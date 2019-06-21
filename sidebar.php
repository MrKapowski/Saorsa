<?php
/**
 * Sidebar template for Saorsa
 * 
 */?><aside id="secondary-content"  aria-labelledby="secondary-content-label">
    <div id="secondary-content-label" hidden>Secondary Content</div>
    <?php dynamic_sidebar( 'main-sidebar' ); ?>
</aside>
<aside id="tertiary-content" aria-labelledby="tertiary-content-label">
    <div id="tertiary-content-label" hidden>Tertiary Content</div>
    <?php dynamic_sidebar( 'second-sidebar' ); ?>
</aside>