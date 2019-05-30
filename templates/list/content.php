<article>
    <?= ( function_exists( 'has_post_kind' ) && has_post_kind() ) ? get_post_kind() : get_post_format(); ?>
</article>