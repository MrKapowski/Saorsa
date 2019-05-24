<?php
/**
 * @package Saorsa
 * @since Saorsa 0.0.1
 */

function saorsa_add_hum_shortlink() {
    ?>
    
	<link rel="shortlink" href="<?php echo esc_url( wp_get_shortlink() ); ?>">
    <?php
}
add_action('wp_head', 'saorsa_add_hum_shortlink');
