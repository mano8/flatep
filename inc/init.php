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
require get_stylesheet_directory() . '/inc/classes/class-flatep-debug.php';
require get_stylesheet_directory() . '/inc/functions/function-conditionals.php';
/**
 * Woocommerce functions and classes
 */
if(is_woocommerce_activated()){
    //require get_stylesheet_directory() . '/inc/woocommerce/structure-wc-global.php';
    require get_stylesheet_directory() . '/inc/classes/class-flatep-wc.php';
    require get_stylesheet_directory() . '/inc/woocommerce/structure-wc-product-box.php';
}

if(is_events_manager_activated()){
    require get_stylesheet_directory() . '/inc/classes/class-flatep-em.php';
}
    
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
        require get_stylesheet_directory() . '/inc/classes/class-flatep-setup.php';
        
        
    }
    
    //-> Add admin cuztomize options
    if(current_user_can( 'manage_options')){
        require get_stylesheet_directory() . '/inc/admin/admin-init.php';
    }

    /**
     * Flatsome Shortcodes. 
     */

    
    require get_stylesheet_directory() . '/inc/shortcodes/ux_banner.php';
    require get_stylesheet_directory() . '/inc/shortcodes/share_follow.php';
    if(is_woocommerce_activated()){
        require get_stylesheet_directory() . '/inc/shortcodes/product_categories.php';
    }

    if(is_events_manager_activated()){
        require get_stylesheet_directory() . '/inc/shortcodes/ux_events_list_grouped.php';
    }
    


    /**
     * UX Builder
     */
    if(is_flatep()){
        require get_stylesheet_directory() . '/inc/builder/builder.php';
        
    }
    
}
add_action( 'after_setup_theme', 'flatep_after_setup_theme', 10 );

