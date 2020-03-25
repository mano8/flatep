<?php
/**
 * Handles the woocommerce product box structure
 *
 * @author  UX Themes
 * @package FlaTep/WooCommerce
 */

if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	/**
	 * Fix WooCommerce Loop Title
	 */
	function woocommerce_template_loop_product_title() {
        $title = get_the_title();
        $link_attr = (class_exists("FlaTep_Woocommerce")) ? $link_attr = FlaTep_Woocommerce::get_the_product_link_title_seo($title) : $title;
        
		echo '<p class="name product-title"><a href="' . get_the_permalink() . '" '. $link_attr . '>' . $title . '</a></p>';
	}
}