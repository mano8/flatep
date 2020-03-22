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

/**
 * Is FlaTep Debug Active
 *
 * @since   1.0.0
 */
function is_flatep_debug() {
    return get_theme_mod( 'flatep_debug', false );
}

/**
 * test if bar active
 *
 * @since   1.0.0
 */
function is_flatep_bar_active($bar) {
    $tst = -1;
    if($bar === 'top'){
        $tst = !is_flatep() || ( is_flatep() && ((get_theme_mod( 'top_bar_tep_sel_active_pages', false ) && is_flatep_page_from_list(get_theme_mod( 'top_bar_tep_actived_pages', '' )) ) || !get_theme_mod( 'top_bar_tep_sel_active_pages', false )))  ;
    }
    else if($bar === 'bottom'){
        $tst = !is_flatep() || ( is_flatep() && ((get_theme_mod( 'bottom_bar_tep_sel_active_pages', false ) && is_flatep_page_from_list(get_theme_mod( 'bottom_bar_tep_actived_pages', '' )) ) || !get_theme_mod( 'bottom_bar_tep_sel_active_pages', false )))  ;
    }
    FlaTep_Debug::print_debug( 3, sprintf('Start FlaTepDebug Class -- bar :  %s -- test : %d', $bar, $tst) );
    return $tst;
}


/**
 * test if page in page list
 *
 * @since   1.0.0
 */
function is_flatep_page_from_list($page_list, $default=true) {
    $default = ($default === true) ? true : false ;
    $tst = (empty($page_list)) ? $default : !$default;

    if(!empty($page_list) && is_string($page_list)){
        $pages = explode(',', $page_list);
        
        if(is_array($pages)){
            foreach ($pages as $key => $value) {
                $p = trim($value);
                if( !empty($p) && ( is_page($p) || ( (is_home() || is_front_page()) && ( (int) $p == -1) ) ) ){
                    $tst = true;
                }
            }
        }
        
    }
    return $tst;
}