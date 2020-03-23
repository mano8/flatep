<?php
/**
 * FlaTep Class Debug.
 *
 * Debug theme Class.
 *
 * @package FlaTep\Classes
 */

class FlaTep_Woocommerce{

    function __construct(){
        $this->run();
    }

    //Product Cat Create page
    public function flatep_taxonomy_add_new_meta_field() {
        if (is_flatep()){
           //-> add templates
           get_template_part('template-parts/woocommerce/catfield','create_years');
        }
    }

    //Product Cat Create page
    public function flatep_taxonomy_edit_meta_field($term) {
        if (is_flatep()){
            //getting term ID
            $term_id = $term->term_id;

            // retrieve the existing value(s) for this meta field.
            $flatep_meta_years = get_term_meta($term_id, 'flatep_meta_years', true);
            set_query_var( 'flatep_meta_years_value', $flatep_meta_years );
            //-> add templates
            get_template_part('template-parts/woocommerce/catfield','edit_years');
        }
    }

    // Save extra taxonomy fields callback function.
    public function flatep_save_taxonomy_custom_meta($term_id) {
        if (is_flatep()){
            $flatep_meta_years = filter_input(INPUT_POST, 'flatep_meta_years');

            update_term_meta($term_id, 'flatep_meta_years', $flatep_meta_years);
        }
    }

    /**
     * Format shop links title with extra text before and after product name
     *
     * @since   1.0.0
     */
    public static function set_wc_product_title_seo($product, $before = '', $after = ''){
        $before = (!empty($before)) ? trim($before) : trim(get_theme_mod( 'flatep_seo_wp_prod_link_before', '' ));
        $after = (!empty($after)) ? trim($after) : trim(get_theme_mod( 'flatep_seo_wp_prod_link_after', '' ));

        return esc_attr($before . ' ' . $product . $after);

    }

    /**
     * 
     *
     * @since   1.0.0
     */
    function get_the_product_link_title_seo($product, $before = '', $after = '') {
        $res = '';
        if(is_object($product)){
            $product_cats = function_exists( 'wc_get_product_category_list' ) ? wc_get_product_category_list( get_the_ID(), '\n', '', '' ) : $product->get_categories( '\n', '', '' );
            $product_cats = strip_tags( $product_cats );

            $link_title = set_wc_product_title_seo($product->get_name(), $before, $after);
            if ( $product_cats ) {
                $first_part = explode( '\n', $product_cats ); $nb = count($first_part);
                $res = ' title="'.$link_title.'" rel="Colección '.$first_part[$nb-1].'" aria-label="'.$link_title.'"';
            }
            else{
                $link_title = esc_attr($before . '  ' . $product->get_name() . ' ©Marcela Navarrete');
                $res = ' title="'.$link_title.'" aria-label="'.$link_title.'"';
            }
            

            return $res;
        }
    }

    public function woocommerce_template_loop_category_link_open($category){
        $txt = '';
        if(is_object($category)){
            $before = esc_attr(get_theme_mod( 'flatep_seo_woo_cat_link_before', 'Category' ));
            $after = esc_attr(get_theme_mod( 'flatep_seo_woo_cat_link_after', 'Products' ));
            $txt = sprintf("%s %s - %d %s", $before, $category->name ,$category->count , $after);
        }
        echo sprintf('<a href="%s" title="%s" aria-label="%s" rel="%s %s" >', 
                esc_url( get_term_link( $category, 'product_cat' ) ), 
                $txt,
                $txt,
                $before,
                esc_attr($category->name)
        );
    }

    public function run(){
        //-> Add Custom fields for woocommerce category
        $this->woo_add_cat_meta_fields();
        //-> Add accessibility links attributes to woocommerce categories links
        add_action( 'woocommerce_before_subcategory', array($this, 'woocommerce_template_loop_category_link_open'), 10 );
    }

    private function woo_add_cat_meta_fields(){
        if(get_theme_mod( 'flatep_wc_add_cat_meta_years', false )){
            //-> Add Custom field years
            add_action('product_cat_add_form_fields', array($this, 'flatep_taxonomy_add_new_meta_field'), 10);
            add_action('product_cat_edit_form_fields', array($this, 'flatep_taxonomy_edit_meta_field'), 10);
            add_action('edited_product_cat', array($this, 'flatep_save_taxonomy_custom_meta'), 10);
        }
    }
}

$flatepWoo = new FlaTep_Woocommerce();