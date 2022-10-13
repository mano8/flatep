<?php
/**
 * FlaTep Structure.
 *
 * Header Structure.
 *
 * @package FlaTep\Structures
 */


 /**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Current classes.
 *
 * @return array $classes
 */
function flatep_body_classes( $classes ) {

	// Change Body Layouts.
	if (get_theme_mod( 'body_layout' ))  $classes[]                   = get_theme_mod( 'body_layout' );
	if (get_theme_mod( 'box_shadow_header' )) $classes[]              = 'header-shadow';
	if (get_theme_mod( 'body_bg_type' ) == 'bg-full-size') $classes[] = 'bg-fill';
	if (get_theme_mod( 'box_shadow' )) $classes[]                     = 'box-shadow';
	if (get_theme_mod( 'flatsome_lightbox', 1 )) $classes[]           = 'lightbox';
	if (get_theme_mod( 'dropdown_arrow', 1 )) $classes[]              = 'nav-dropdown-has-arrow';
	if (get_theme_mod( 'dropdown_shadow', 1 )) $classes[]             = 'nav-dropdown-has-shadow';
	if (get_theme_mod( 'dropdown_border_enabled', 1 )) $classes[]     = 'nav-dropdown-has-border';
	if (get_theme_mod( 'parallax_mobile', 0 )) $classes[]             = 'parallax-mobile';

  	
  	if (
		'center' != get_theme_mod( 'mobile_overlay' ) &&
		'slide' == get_theme_mod( 'mobile_submenu_effect' )
	) {
		$levels    = get_theme_mod( 'mobile_submenu_levels', '1' );
		$classes[] = 'mobile-submenu-slide';
		$classes[] = 'mobile-submenu-slide-levels-' . $levels;
	}

	if ( 'toggle' === get_theme_mod( 'mobile_submenu_parent_behavior' ) ) {
		$classes[] = 'mobile-submenu-toggle';
	}
	// Add the selected page template classes if Default Template is selected.
	$page_template    = get_post_meta( get_the_ID(), '_wp_page_template', true );
	$default_template = get_theme_mod( 'pages_template', 'default' );
	if ( is_page() && ( empty( $page_template ) || $page_template == 'default' ) && $default_template !== 'default' ) {
		$classes[] = 'page-template-' . $default_template;
		$classes[] = 'page-template-' . $default_template . '-php';
	}

	//-> child part
	if(is_flatep()){ $classes[] = 'is_flatep'; }
	$x_style = get_theme_mod( 'global_styles_tep_custom', 'default' );
	if 		($x_style === 'red_tai')  	$classes[]      = 'flatep-red-tai';
	else if ($x_style === 'clear_mn')  	$classes[]      = 'flatep-clear-mn';
	
	return $classes;
}
add_filter( 'body_class', 'flatep_body_classes' );


/**
	 * Filters the HTML attributes applied to a menu item's anchor element.
	 *
	 * @since 3.6.0
	 * @since 4.1.0 The `$depth` parameter was added.
	 *
	 * @param array $atts {
	 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
	 *
	 *     @type string $title        Title attribute.
	 *     @type string $target       Target attribute.
	 *     @type string $rel          The rel attribute.
	 *     @type string $href         The href attribute.
	 *     @type string $aria_current The aria-current attribute.
	 * }
	 * @param WP_Post  $item  The current menu item.
	 * @param stdClass $args  An object of wp_nav_menu() arguments.
	 * @param int      $depth Depth of menu item. Used for padding.
*/
function flatep_nav_menu_link_attributes( $atts = null, $item= null, $args= null, $depth = 0 ) {
	if (is_array($atts) && !empty($args['title'])){
		$args['aria-label'] = $args['title'];
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'flatep_nav_menu_link_attributes' );

