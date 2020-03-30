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
	if (get_theme_mod( 'parallax_mobile', 0 )) $classes[]             = 'parallax-mobile';

  // Add the selected page template classes if Default Template is selected.
	$page_template =  get_post_meta( get_the_ID(), '_wp_page_template', true );
	$default_template = get_theme_mod('pages_template');
	if ( ( empty( $page_template ) || $page_template == "default" ) && $default_template ) {
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
 * Header Navigation.
 *
 * @param string $nav    Navigation menu position.
 * @param bool   $walker Navigation Class.
 *
 * @return void
 */
function flatep_header_nav( $nav, $walker = false ) {

	$admin_url = get_admin_url() . 'customize.php?url=' . get_permalink() . '&autofocus%5Bsection%5D=menu_locations';

	// Check if has Custom mobile menu.
	if ($nav == 'primary' && $walker == 'FlaTepNavSidebar' && has_nav_menu( 'primary_mobile' )) $nav = 'primary_mobile';

	// If single page
	$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
	$default_template = get_theme_mod('pages_template', 'default');

	//print_r($page_template);
	// Add single page nav helper.
	if((strpos($page_template, 'single-page-nav') !== false || ((empty($page_template) || strpos($page_template, 'default') !== false) && strpos($default_template, 'single-page-nav') !== false)) && $nav == 'primary') { ?>
	<li class="nav-single-page hidden"></li>
	<?php
	} elseif ( has_nav_menu( $nav ) ) {

		wp_nav_menu(array(
			'theme_location' => $nav,
			'container'      => false,
			'items_wrap'     => '%3$s',
			'depth'          => 0,
			'walker'         => new $walker(),
		));

	} else {
		echo '<li><a href="' . $admin_url . '">Assign a menu in Theme Options > Menus</a></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Navigation Builder.
 *
 * @param string $options Theme options.
 * @param string $type    Navigation type.
 *
 * @return void
 */
function flatep_header_elements( $options, $type = '' ) {
	// Get options.
	$get_options = get_theme_mod( $options );

	$walker                         = 'FlaTepNavDropdown';
	if ($type == 'sidebar') $walker = 'FlaTepNavSidebar';

	// Set options.
	if ( is_array( $get_options ) ) {

		foreach ( $get_options as $key => $value ) {

			if ( $value == 'divider' || $value == 'divider_2' || $value == 'divider_3' || $value == 'divider_4' || $value == 'divider_5' ) {
				echo '<li class="header-divider"></li>';
			} elseif ( $value == 'html' || $value == 'html-2' || $value == 'html-3' || $value == 'html-4' || $value == 'html-5' ) {
				flatsome_get_header_html_element( $value );
			} elseif ( $value == 'block-1' || $value == 'block-2' ) {
				echo do_shortcode( '<li class="header-block"><div class="header-block-' . $value . '">[block id="' . get_theme_mod( 'header-' . $value ) . '"]</div></li>' );
			} elseif ( $value == 'nav-top' ) {
				flatep_header_nav( 'top_bar_nav', $walker );
			} elseif ( $value == 'nav' ) {
				flatep_header_nav( 'primary', $walker );
			} elseif ( $value == 'wpml' ) {
				get_template_part( 'template-parts/header/partials/element-languages', $type );
			} else {
				get_template_part( 'template-parts/header/partials/element-' . $value, $type );
			}
			// Hooked Elements.
			do_action( 'flatep_header_elements', $value );
		}
	}
}


/**
 * FlaTepNavDropdown Class.
 *
 * Extends FlatsomeNavDropdown Class.
 */
class FlaTepNavDropdown extends FlatsomeNavDropdown {

	/**
	 * Display Elements.
	 *
	 * @param object $element           Navigation elements.
	 * @param array  $children_elements Child navigation elements.
	 * @param int    $max_depth         Maximum depth level.
	 * @param int    $depth             Depth of menu item. Used for padding.
	 * @param array  $args              wp_nav_menu() arguments.
	 * @param string $output            Element output.
	 *
	 * @return void
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ){
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Start Level.
	 *
	 * @param string $output Element output.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 *
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ){
		parent::start_lvl( $output, $depth, $args );
	}

	/**
	 * End Level.
	 *
	 * @param string $output Element output.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 *
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 1, $args = array() ){
		parent::end_lvl( $output, $depth, $args );
	}

	/**
	 * Starts the element output.
	 *
	 * @param string $output Element output.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 * @param int    $id     Current item ID.
	 *
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = ''; // phpcs:ignore

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// Set Active Class.
		if ( in_array( 'current-menu-ancestor', $classes, true ) || in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) ) {
			$classes[] = 'active';
		}

		$classes[] = ' menu-item-' . $item->ID;

		if ( $item->has_children && $depth == 0 ) { $classes[] = 'has-dropdown';}
		if ( $item->has_children && $depth == 1 ) { $classes[] = 'nav-dropdown-col';}

		$menu_icon = '';

		// Add flatsome Icons.
		if ( strpos( $classes[0], 'icon-' ) !== false ) {
			$menu_icon  = get_flatsome_icon( $classes[0] );
			$classes[0] = 'has-icon-left';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->attr_title ) ? ' aria-label="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		// Check if menu item is in main menu.
		if ( $depth == 0 ) {
			// These lines adds your custom class and attribute.
			$attributes .= ' class="nav-top-link"';
		}

		// Image Column.
		if ( strpos( $class_names, 'image-column' ) !== false ) {
			$item_output  = '';
			$item_output .= '<a' . $attributes . ' class="dropdown-image-column">';
			$item_output .= '<img width="180" height="480" src="' . $item->description . '" title="' . apply_filters( 'the_title', $item->title, $item->ID ) . '" alt="' . apply_filters( 'the_title', $item->title, $item->ID ) . '"/>';
			$item_output .= '</a>';
		} elseif ( strpos( $class_names, 'category-column' ) !== false ) { // Category Image.
			$item_output = '<div class="category-images-preview">Loading</div>';

		} else {
			$before = (is_object($args)) ? $args->before : $args['before'];
			$link_before = (is_object($args)) ? $args->link_before : $args['link_before'];
			$link_after = (is_object($args)) ? $args->link_after : $args['link_after'];
			$after = (is_object($args)) ? $args->after : $args['after'];


			// Normal Items.
			$item_output  = $before;
			$item_output .= '<a' . $attributes . '>';

			// Add menu.
			if ($menu_icon) { $item_output .= $menu_icon; }
			
			
			$item_output                 .= $link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $link_after;

			// Add down arrow.
			$icon = '';
			if ($item->has_children && $depth == 0) $icon = get_flatsome_icon( 'icon-angle-down' );

			$item_output .= $icon . '</a>';
			$item_output .= $after;
			
		}

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}


}

/**
 * FlaTepNavSidebar Class.
 *
 * Extends Walker_Nav_Menu Class.
 *
 * Sidebar Navigation Walker.
 */
class FlaTepNavSidebar extends FlatsomeNavSidebar{
	/**
	 * XXX.
	 *
	 * @param string $output Element output.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 * @param int    $id     Current item ID.
	 *
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		// Most of this code is copied from original Walker_Nav_Menu.
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = ''; // phpcs:ignore

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// if icon.
		$menu_icon = '';
		if ( strpos( $classes[0], 'icon-' ) !== false ) {
			$menu_icon  = '<span class="' . $classes[0] . '"></span>';
			$classes[0] = '';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		// Check if menu item is in main menu.
		if ( $depth == 0 ) {
			// These lines adds your custom class and attribute.
			$attributes .= ' class="nav-top-link"';
		}

		$before = (is_object($args)) ? $args->before : $args['before'];
		$link_before = (is_object($args)) ? $args->link_before : $args['link_before'];
		$link_after = (is_object($args)) ? $args->link_after : $args['link_after'];
		$after = (is_object($args)) ? $args->after : $args['after'];

		// Normal Items.
		$item_output  = $before;
		$item_output .= '<a' . $attributes . '>';

		$item_output .= $link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $link_after;

		$item_output .= '</a>';

		$item_output .= $after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}