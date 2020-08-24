<?php
/**
 * FlaTep Class Debug.
 *
 * Debug theme Class.
 *
 * @package FlaTep\Classes
 */

class FlaTep_Woocommerce{
    private $debug;

    function __construct(){
        $this->debug  = FlaTep_Debug::is_debug();
        $this->run();
    }

    /**
     * Meta Title and Description column added to category admin screen.
     *
     * @param mixed $columns
     * @return array
     */
    function wh_customFieldsListTitle( $columns ) {
        $columns['flatep_meta_years'] = __( 'Year', 'woocommerce' );
        return $columns;
    }

    /**
     * Meta Title and Description column value added to product category admin screen.
     *
     * @param string $columns
     * @param string $column
     * @param int $id term ID
     *
     * @return string
     */
    function wh_customFieldsListDisplay( $columns, $column, $id ) {
        if ( 'flatep_meta_years' == $column ) {
            $columns = esc_html( get_term_meta($id, 'flatep_meta_years', true) );
        }
        return $columns;
    }

    /**
     * Display markup or template for custom field
     */
    function gwp_quick_edit_category_field( $column_name, $post_type ) {
        // If we're not iterating over our custom column, then skip
        if ( $post_type != 'edition' && $column_name != 'flatep_meta_years' ) {
            return false;
        }
        wp_nonce_field( 'flatep_q_edit_nonce', 'flatep_nonce' );
        // retrieve the existing value(s) for this meta field.
        set_query_var( 'flatep_meta_years_name', 'flatep_meta_years' );
        get_template_part('template-parts/woocommerce/catfield','quick_edit_years');
    }

    /**
     * Callback runs when category is updated
     * Will save user-provided input into the wp_termmeta DB table
     */
    function gwp_quick_edit_save_category_field( $post_id ) {
        // check user capabilities
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // check nonce
        if ( !wp_verify_nonce( $_POST['flatep_nonce'], 'flatep_q_edit_nonce' ) ) {
            return;
        }
    
        if ( isset( $_POST['flatep_meta_years'] ) ) {
            // security tip: kses
            update_term_meta( $post_id, 'flatep_meta_years', $_POST['flatep_meta_years'] );
        }
    }

    /**
     * Front-end stuff for pulling in user-input values dynamically
     * into our input field.
     */
    function gwp_quickedit_category_javascript() {
        $current_screen = get_current_screen();
        if ( $current_screen->id != 'edit-product_cat' || $current_screen->taxonomy != 'product_cat' ) {
            return;
        }

        // Ensure jQuery library is loaded
        wp_enqueue_script( 'jquery' );
        ?>
        <script type="text/javascript">
            /*global jQuery*/
            jQuery(function($) {
                $('#the-list').on( 'click', 'a.editinline', function( e ) {
                    e.preventDefault();
                    var id = $( this ).closest( 'tr' ).attr( 'id' );
                    id = id.replace( 'tag-', '' ); //-> post- for products
                    //if post id exists
                    if ( id > 0 ) {

                        // add rows to variables
                        var specific_post_edit_row = $( '#edit-' + id ),
                            specific_post_row = $( '#tag-' + id ), //-> #post- for products
                            cat_years = $( '.column-flatep_meta_years', specific_post_row ).text();

                        // populate the inputs with column data
                        $( ':input[name="flatep_meta_years"]', specific_post_edit_row ).val( cat_years );
                    }
                });
            });
        </script>
        <?php
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
     * Options related in FlaTep - Seo
     *
     * @since   1.0.0
     */
    public static function set_wc_product_title_seo($product, $cat = '', $before = '', $after = ''){
        $before = (!empty($before)) ? trim($before) : trim(get_theme_mod( 'flatep_seo_woo_prod_link_before', '' ));
        $after = (!empty($after)) ? trim($after) : trim(get_theme_mod( 'flatep_seo_woo_prod_link_after', '' ));
        $attributes = ''; $product_name = '';
        if( is_object($product) ){
            $product_name = $product->get_name();
            $attrs = get_theme_mod( 'flatep_seo_woo_prod_link_attr', '' );
            $i = 0;
            if ( is_array($attrs) and count($attrs) > 0){
                foreach( $attrs as $tax){
                    $attr_terms = $product->get_attribute( $tax );
                    if ( !empty($attr_terms) ){
                        $attributes .= ($i > 0) ? ' - ' : '';
                        $attributes .= esc_attr($attr_terms);
                        $i++;
                    }
                }
            }
        }
        else{
            $product_name = $product;
        }
        FlaTep_Debug::print_debug( 4, sprintf('product link builder for -> %s - attributes : %s - cat : %s - before : %s - after : %s'
            ,$product_name, $attributes, $cat, $before, $after
            ) );
        return trim(esc_attr(esc_attr($before) . ' ' . $attributes . ' - ' . esc_attr($product_name) . ' - ' . esc_attr($cat) . ' ' . esc_attr($after)));

    }

    /**
     * Get related categorie from product
     * 
     *
     * @since   1.0.0
     */
    public static function get_related_product_cat($product){
        if(is_object($product)){
            $product_cats = function_exists( 'wc_get_product_category_list' ) ? wc_get_product_category_list( get_the_ID(), '\n', '', '' ) : $product->get_categories( '\n', '', '' );
            
            $product_cats = strip_tags( $product_cats );
            FlaTep_Debug::print_debug( 5, sprintf('Related product cat for -> %s - cats : %s',
                $product->get_name(), 
                $product_cats
            ) );
            if ( $product_cats ) {
                $first_part = explode( '\n', $product_cats ); $nb = (is_array($first_part)) ? count($first_part) : 0;
                return (is_array($first_part) && $nb > 0) ? $first_part[$nb-1] : '';
            }
        }
        return '';
    }

    /**
     * 
     *
     * @since   1.0.0
     */
    public static function get_the_product_title_seo($product, $cat=false, $before = '', $after = '') {
        $res = '';
        if( !empty($product) ){
            $res = esc_attr(FlaTep_Woocommerce::set_wc_product_title_seo($product, $cat, $before, $after));
        }
        return $res;
    }
    
    /**
     * 
     *
     * @since   1.0.0
     */
    public static function get_the_product_link_title_seo($product, $cat=false, $before = '', $after = '') {
        $res = '';
        $title = FlaTep_Woocommerce::get_the_product_title_seo($product, $cat, $before, $after);
        if( !empty($title) ){
            $res = ' title="'.$title.'" aria-label="'.$title.'"';
        }
        return $res;
    }

    public function woocommerce_template_loop_category_link_open($category){
        $txt = '';
        if(is_object($category)){
            $before = esc_attr(get_theme_mod( 'flatep_seo_woo_cat_link_before', 'Category' ));
            $after = esc_attr(get_theme_mod( 'flatep_seo_woo_cat_link_after', 'Products' ));
            $txt = sprintf("%s %s - %d %s", $before, $category->name ,$category->count , $after);
        }
        echo sprintf('<a href="%s" title="%s" aria-label="%s" >', 
                esc_url( get_term_link( $category, 'product_cat' ) ), 
                $txt,
                $txt,
        );
    }

    /**
     * Setup Flatep Admin Styles and Scripts
     */
    function flatep_admin_scripts($pagehook){
        if ( is_admin() && 'edit-tags.php' == $pagehook ){
            $version = '0.0.1';
            wp_enqueue_script( 'populatequickedit', get_stylesheet_directory_uri() . '/assets/js/populate.js', array( 'jquery' ), $version, true );
            if( $this->debug ){ FlaTep_Debug::print_debug( 4, 'populatequickedit script loaded...' ); }
        }
    }

    /**
     * Add js layout adapter script on woocommerce single product page.
     * Set the layout of view deppending image format
     * @since 1.0.0
     */
    function flatep_add_custom_scripts_product_layout() {
    // If woocommerce single product page
        if ( is_flatep() && is_woocommerce_activated() && is_product() ) {
            wp_enqueue_script( 'flatep-single-product', get_stylesheet_directory_uri() .'/assets/js/third/woo/dynamic_layout_sp.js', array( 'jquery' ), theme_version(), false );
        }
    }

    public function run(){
        //-> Add Custom fields for woocommerce category
        $this->woo_add_cat_meta_fields();
        //-> Add accessibility links attributes to woocommerce categories links
        remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
        add_action( 'woocommerce_before_subcategory', array($this, 'woocommerce_template_loop_category_link_open'), 10 );
        add_filter( 'manage_edit-product_cat_columns', array($this, 'wh_customFieldsListTitle') ); //Register Function
        add_action( 'manage_product_cat_custom_column', array($this, 'wh_customFieldsListDisplay') , 10, 3); //Populating the Columns
        
        add_action( 'quick_edit_custom_box', array($this, 'gwp_quick_edit_category_field'), 10, 2 );
        add_action( 'edited_product_cat', array($this, 'gwp_quick_edit_save_category_field') );
            //-> add_action( 'admin_print_footer_scripts-edit-tags.php', array($this, 'gwp_quickedit_category_javascript') );
            //-> Add custom script to sigle product pages
        add_action( 'wp_enqueue_scripts', array($this, 'flatep_add_custom_scripts_product_layout') , 100);
        add_action( 'admin_enqueue_scripts', array($this, 'flatep_admin_scripts'),99 );
        /*
            FlaTep_Debug::print_debug( 3, '-------Setting product schema...' );
            add_action( 'woocommerce_after_single_product', array($this, 'flatep_set_product_schema'),10 );
            if (is_single()){
                
            }
        */
        
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