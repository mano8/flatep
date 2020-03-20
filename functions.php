<?php
/**
 * FlaTep Functions.php
 *
 * @package FlaTep
 */


 /**
 * add child styles
 *
 * @since   1.0.0
 */

function theme_enqueue_flatep_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_flatep_styles', 10 );