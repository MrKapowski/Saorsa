<?php
/**
 * Header for Saorsa theme.
 * Contains the site logo, name, main menu
 * 
 * @package Saorsa
 * @since Saorsa 0.0.1
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="profile" href="http://microformats.org/profile/specs" />
	<link rel="profile" href="http://microformats.org/profile/hatom" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?><?php //saorsa_semantics( 'body' ); ?>>
    <a href="#main-content" class="visually-hidden skip-link">Skip to content</a>
    <header>
        <div class="branding">
            <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                }
            ?>
            <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="p-name u-url">
                <?php bloginfo( 'name' ); ?>
            </a>
        </div>
        
        <nav aria-labelledby="primary-nav-label">
            <div id="primary-nav-label" hidden>Primary</div>
            <button class="menu-toggle" aria-controls="main-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'saorsa' ); ?></button>

            <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_id' => 'main-menu',
                        'menu_class' => ''
                    )
                );
            ?>
        </nav>
        <?php get_search_form( true ); ?>
        <div class="page-banner"></div>
    </header>