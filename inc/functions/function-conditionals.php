<?php
/**
 * FlaTep Conditional Functions
 *
 * @author   UX Themes
 * @package  FlaTep/Functions
 */

if ( ! function_exists( 'is_flatep' ) ) {
	/**
     * Returns is child additions enabled
     *
     * @since   1.0.0
     */
    function is_flatep(){
        return get_theme_mod( 'flatep_child_active', true );
    }
}