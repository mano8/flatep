<?php

if ( ! function_exists( 'flatsome_woocommerce_get_alt_product_thumbnail' ) ) {
	/**
	 * Get Hover image for WooCommerce Grid
	 * replace flatsome_woocommerce_get_alt_product_thumbnail
	 */
	function flatsome_woocommerce_get_alt_product_thumbnail($alt = '') {
		
		$hover_style = get_theme_mod( 'product_hover', 'fade_in_back' );
		if ( $hover_style !== 'fade_in_back' && $hover_style !== 'zoom_in' ) {
			return;
		}

		global $product;
		$attachment_ids = $product->get_gallery_image_ids();
		$class          = 'show-on-hover absolute fill hide-for-small back-image';
		if ( $hover_style == 'zoom_in' ) {
			$class .= $class . ' hover-zoom';
		}
		
		$attrs = array('class' => $class);
		if( !empty($alt) ){
			$attrs['alt'] = esc_attr($alt);
		}
		
		FlaTep_Debug::print_debug( 4, sprintf('flatsome_woocommerce_get_alt_product_thumbnail run from flatep -> attrs : %s - attachment_ids : %s',
				implode(',', $attrs),
				implode(',', $attachment_ids)
			) );
			
		if ( $attachment_ids ) {
			$loop = 0;
			foreach ( $attachment_ids as $attachment_id ) {
				$image_link = wp_get_attachment_url( $attachment_id );
				if ( ! $image_link ) {
					continue;
				}
				$loop ++;
				echo apply_filters( 'flatsome_woocommerce_get_alt_product_thumbnail',
					wp_get_attachment_image( $attachment_id, 'woocommerce_thumbnail', false, $attrs ) );
				if ( $loop == 1 ) {
					break;
				}
			}
		}
	}
}
//remove_action( 'flatsome_woocommerce_shop_loop_images', 'flatsome_woocommerce_get_alt_product_thumbnail', 10 );
//add_action( 'flatsome_woocommerce_shop_loop_images', 'flatsome_woocommerce_get_alt_product_thumbnail', 11, 1 );

if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail, or the placeholder if not set.
	 *
	 * @param string $size (default: 'woocommerce_thumbnail').
	 * @param int    $deprecated1 Deprecated since WooCommerce 2.0 (default: 0).
	 * @param int    $deprecated2 Deprecated since WooCommerce 2.0 (default: 0).
	 * @return string
	 */
	function woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $product;

		$image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
		if ($product){
			$cat = FlaTep_Woocommerce::get_related_product_cat($product);
			$link_title = FlaTep_Woocommerce::get_the_product_title_seo($product, $cat);
			$attrs = array('alt'=> $link_title);
			return $product->get_image( $image_size, $attrs );
		}
		return '';
	}
}
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

if ( ! function_exists( 'flatep_get_products_attributes_html' ) ){
    /**
     * Flatep Product Attributes List Html.
     *
     * Returns a list of Flatep Product Attributes List Html.
     *
     * @return string Html of Product Attributes List Selected.
     */
    function flatep_get_products_attributes_html($product){
        $attributes = '';
        if ( is_object($product) ){
            $selected_attributes = get_theme_mod( 'flatep_wc_add_product_list_attribute', '' );
            FlaTep_Debug::print_debug( 4, sprintf('product attributes object -> %s -- is_array : %s -- count : %s', 
                is_array($selected_attributes) ? implode(', ', $selected_attributes) : '',
                is_array($selected_attributes) ? 'true' : 'false',
                count($selected_attributes)
            ) );

            $is_attributes = ( is_array($selected_attributes) && count($selected_attributes) > 0);
            if ( $is_attributes){
                $attributes .= '<div class="attr-wrapper">';
                foreach ( $selected_attributes as $key => $tax ){
                    $attr_terms = $product->get_attribute( $tax );
                    if ( !empty($attr_terms) ){
                        
                        $attributes .= '<p class="is-small flatep-attr-' . esc_attr($tax) . '">';
                        $attributes .= esc_attr($attr_terms);
                        $attributes .= '</p>';
                    }
                    
                }
                $attributes .= '<div class="is-divider is-tep-divider"></div>';
                $attributes .= '</div>';
            }
        }
        
        return $attributes;
    }
}


if ( ! function_exists( 'flatep_get_products_attributes_list' ) ){
    /**
     * Flatep Product Attributes List.
     *
     * Returns a list of Flatep Product Attributes List.
     *
     * @return array Product Attributes List.
     */
    function flatep_get_products_attributes_list(){
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        
        $taxonomy_terms = array();

        if ( $attribute_taxonomies ){
            foreach ($attribute_taxonomies as $tax){
                $tax_name = wc_attribute_taxonomy_name($tax->attribute_name);
                if(!empty($tax_name)){
                    $taxonomy_terms[$tax_name] = $tax->attribute_name;
                }
                
                /*if (taxonomy_exists(wc_attribute_taxonomy_name($tax->attribute_name))){
                    $taxonomy_terms[$tax->attribute_name] = get_terms( wc_attribute_taxonomy_name($tax->attribute_name), 'orderby=name&hide_empty=0' );
                }
                else{
                    FlaTep_Debug::print_debug( 4, sprintf('attribute_taxonomies not exist -> name : %s -- wc_name : %s -- exist : %s', 
                        $tax->attribute_name, 
                        wc_attribute_taxonomy_name($tax->attribute_name),
                        taxonomy_exists(wc_attribute_taxonomy_name($tax->attribute_name))
                    ) );
                }*/
                    
            }
            FlaTep_Debug::print_debug( 3, 'attribute_taxonomies loop end...' );
        }
        else{
            FlaTep_Debug::print_debug( 3, 'no attribute_taxonomies found...' );
        }
        return $taxonomy_terms;
    }
}
