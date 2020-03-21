<?php
/**
 * FlaTep Engine Room.
 * This is where all Theme Functions runs.
 *
 * @package flatep
 */

 /**
 * Setup.
 * Enqueue styles, register widget regions, etc.
 */
require get_stylesheet_directory() . '/inc/functions/function-conditionals.php';

/**
 * Theme Admin
 * child theme
 */
function flatep_after_setup_theme(){
    

    //-> 
    if(is_flatep()){
        /**
         * Setup.
         * Enqueue styles, register widget regions, etc.
         */
        require get_stylesheet_directory() . '/inc/functions/function-setup.php';
        /**
         * Structure.
         * Template functions used throughout the theme.
         */
        require get_stylesheet_directory() . '/inc/structure/structure-header.php';
        
    }
    //-> Add admin cuztomize options
    if(current_user_can( 'manage_options')){
        require get_stylesheet_directory() . '/inc/admin/admin-init.php';
      }
    
  }
  add_action( 'after_setup_theme', 'flatep_after_setup_theme', 10 );