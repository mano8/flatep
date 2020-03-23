<?php
/**
 * FlaTep Class Setup.
 *
 * Setup theme Class.
 *
 * @package FlaTep\Classes
 */



class FlaTep_Setup{
    private $sources;
    private $versions;
    private $debug;
    private $source_handles;

    /**
	 * Test if sources property is defined 
	 *
	 * @since   1.0.0
     * 
     * @return bool     Return True if sources property is defined and not null
	 */
    private function is_sources(){
		return (is_array($this->sources) && count($this->sources) > 0) ? true : false;
    }

    /**
	 * Test if $handle is valid sources property key
	 *
	 * @since   1.0.0
     * 
     * @param string    $handle key to test on sources property
     * @return bool     Return True if sources property have key defined by $handle
	 */
    private function is_source_handle($handle){
		return (is_array($this->sources) && array_key_exists($handle, $this->sources) && is_array($this->sources[$handle])) ? true : false;
    }
    
    /**
	 * Test if $handle is valid source property and if source[$handle] contain $key 
	 *
	 * @since   1.0.0
     * 
     * @param string    $handle key to retrieve on sources property
     * @param string    $key key to test on sources[$handle] array
     * @return bool     Return True if sources[$handle] array property have key defined by $key
	 */
    private function is_source_key($handle, $key){
		return ($this->is_source_handle($handle) && isset($this->sources[$handle][$key])) ? true : false;
	}

    /**
	 * Get $key from sources[$handle] array if defined
	 *
	 * @since   1.0.0
     * 
     * @param string    $handle key to retrieve on sources property
     * @param string    $key key to test on sources[$handle] array
     * 
     * @return mixed     Return $key from sources[$handle] array or false if not defined
	 */
	private function get_source_key($handle, $key){
		return ($this->is_source_key($handle, $key) ) ? $this->sources[$handle][$key] : false;
    }

    /**
	 * Get $key from versions[$handle] array if defined
	 *
	 * @since   1.0.0
     * 
     * @param string    $handle key to retrieve on versions property
     * 
     * @return mixed     Return versions[$handle] array value or false if not defined
	 */
	private function get_version_handle($handle){
        $handle = sanitize_key($handle);
		return (isset($this->versions[$handle]) ) ? $this->versions[$handle] : false;
    }

    /**
	 * Set $key from versions[$handle] array if defined
	 *
	 * @since   1.0.0
     * 
     * @param string    $handle key to retrieve on versions property
     * 
     * @return mixed     Return versions[$handle] array value or false if not defined
	 */
	private function add_version_handle($handle, $version){
        $handle = sanitize_key($handle);
        $version = sanitize_key($version);
        $v = $this->get_version_handle($handle);
        if(is_array($v)){
            $this->versions[$handle][] = $version;
        }
        else{
            $this->versions[$handle] = array($version);
        }
    }

    /**
	 * Set $key from versions[$handle] array if defined
	 *
	 * @since   1.0.0
     */
	private function is_version_handle($handle, $version){
        $v = $this->get_version_handle($handle);
        $version = sanitize_key($version);
        return (is_array($v) && in_array($version, $v)) ? true : false;
    }
    
    /**
	 * Dequeue and/or deregister script defined by $handle
     * 
     * If $handle script is registered, deregister it.
     * And if is enqueued the script is dequeued.
     * 
	 * @since   1.0.0
     * 
	 * @param string    $handle Handle of scipt to dequeue
	 * @return bool     Return True if scipt is already enqueued before dequeue. False if not enqueued and not dequeued.
     */
	private function dequeue_script($handle){
        if( wp_script_is( $handle, 'enqueued' )){
			if(wp_script_is( $handle, 'registered' )){
                wp_deregister_script($handle);
            }
			wp_dequeue_script($handle);
			return true;
		}
		return false;
    }

    /**
	 * Dequeue and/or deregister style defined by $handle
     * 
     * If $handle style is registered, deregister it.
     * And if is enqueued the style is dequeued.
     * 
	 * @since   1.0.0
     * 
	 * @param string    $handle Handle of style to dequeue
	 * @return bool     Return True if style is already enqueued before dequeue. False if not enqueued and not dequeued.
     */
	private function dequeue_style($handle){
        if( wp_style_is( $handle, 'enqueued' )){
			if(wp_style_is( $handle, 'registered' )){
                wp_deregister_style($handle);
            }
			wp_dequeue_style($handle);
			return true;
		}
		return false;
    }

    /**
	 * Dequeue and/or deregister style list defined by $handles
     * 
     * If $handle style is registered, deregister it.
     * And if is enqueued the style is dequeued.
     * 
	 * @since   1.0.0
     * 
	 * @param array     $handles Handle List of style to dequeue
	 * @return bool     Return True if style is already enqueued before dequeue. False if not enqueued and not dequeued.
     */
	private function dequeue_style_list($handles){
        $nb = 0;
		if( is_array($handles)){
			foreach ($handles as $key => $value) {
				if( $value === "style" ){
					if($this->dequeue_style($key)) {$nb++;};
				}
				else if ( $value === "script" ){
					if($this->dequeue_script($key)) {$nb++;};
				}
			}
		}
		return $nb;
    }
    

    /**
	 * Update enqueued style or script from $this->data
	 *
	 * @param string $handle    		Handle of script or style to update/add.
	 * @param bool   $force_register 	Force script or style to register.
	 *
	 * @return bool	 True if
	 *
	 * @since   1.0.0
	 */
	private function flatep_update_enqueues($handle, $handle_ver, $force_register = false){
        $handle = trim(sanitize_key($handle));
        $handle_ver = trim(sanitize_key($handle_ver));
        $type = $this->get_source_key($handle_ver, 'type');
		$src = $this->get_source_key($handle_ver, 'src');
		$deps = $this->get_source_key($handle_ver, 'deps');
		$ver = $this->get_source_key($handle_ver, 'ver');
        $on_footer = $this->get_source_key($handle_ver, 'on_footer');
        $media = $this->get_source_key($handle_ver, 'media');
        if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Update Enqueues -- Handle : %s -- handle_ver : %s -- type : %s',$handle, $handle_ver, $type) ); }
        $register = false;
        
		if($type === 'script'){
			if( wp_script_is( $handle, 'registered' )){
				if($this->dequeue_script($handle)){
                    wp_register_script($handle, $src, $deps, $ver, $on_footer);
                    wp_enqueue_script($handle);
                    $register = true;
                }
                else{ 
                    if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Script %s is registered --> dequeue error -- is_enqueued : %d', $handle, wp_script_is( $handle, 'enqueued' )) ); } 
                }
			}
			else{
				if($force_register === true){
					if($this->dequeue_script($handle)){
                        wp_register_script($handle, $src, $deps, $ver, $on_footer);
                        wp_enqueue_script($handle);
                        $register = true;
                    }
                    else{ 
                        if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Script %s is not registered (force_register) --> dequeue error -- is_enqueued : %d', $handle, wp_script_is( $handle, 'enqueued' )) ); } 
                    }
				}
				else{
					if($this->dequeue_script($handle)) { 
                        wp_enqueue_script($handle, $src, $deps, $ver, $on_footer); 
                        $register = true;
                    }
                    else{ 
                        if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Script %s is not registered --> dequeue error -- is_enqueued : %d', $handle, wp_script_is( $handle, 'enqueued' )) ); } 
                    }
				}
            }
            
			
		}
		else if($type === 'style'){
			if( wp_style_is( $handle, 'registered' )){
				if($this->dequeue_style($handle)){
                    wp_register_style($handle, $src, $deps, $ver, $media);
                    wp_enqueue_style($handle);
                    $register = true;
                }
                else{ 
                    if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Style %s is registered --> dequeue error -- is_enqueued : %d', $handle, wp_style_is( $handle, 'enqueued' )) ); } 
                }
			}
			else{
				if($force_register === true){
					if($this->dequeue_style($handle)){
                        wp_register_style($handle, $src, $deps, $ver, $media);
                        wp_enqueue_style($handle);
                        $register = true;
                    }
                    else{ 
                        if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Style %s is not registered (force_register) --> dequeue error -- is_enqueued : %d', $handle, wp_style_is( $handle, 'enqueued' )) ); } 
                    }
					
				}
				else{
					if($this->dequeue_style($handle)){
                        wp_enqueue_style($handle, $src, $deps, $ver, $media);
                        $register = true;
                    }
                    else{ 
                        if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Style %s is not registered --> dequeue error -- is_enqueued : %d', $handle, wp_style_is( $handle, 'enqueued' )) ); } 
                    }
				}
            }
        }

        if($register) { $this->add_version_handle($handle, $handle_ver); }
		return $register;
    }
    

    /**
	 * Replace to cdn providers list of handles
	 *
	 * @since   1.0.0
	 */
	private function replace_sources_list($list){
        $tst = false;
        if(is_array($list)){
            if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Replace sources from list list_items -> %d',count($list)) ); }
            $type = ''; $tst_i = true; $tst = true;
            foreach ($list as $value) {
                $type = $this->get_source_key($value, 'type'); 
                if( !empty($type) ){
                    $tst_i = $this->flatep_update_enqueues($this->get_source_key($value, 'handle'), $value, true);
                    if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Replace enqueued %s -- %s -- test : %d', $type, $value, $tst_i) ); }
                    $tst = (!$tst_i) ? false : $tst;
                }
            }
        }
        else{
            if( $this->debug ){ FlaTep_Debug::print_debug( 1, 'Error - Replace Source List - Bad parameter type' ); }
        }
        return $tst;		
    }

    /**
	 * Replace to cdn providers list of handles
	 *
	 * @since   1.0.0
	 */
	private function woocomerce_conditional(){
        $tst = -1;
        if( is_woocommerce_activated() ){
            $list = array();
            if( get_theme_mod( 'flatep_src_woo_disable_card', false ) ){
                $list = array(
                    'wc-cart-fragments' => 'script',
                    'wc-add-to-cart' => 'script',
                );
            }

            $act = get_theme_mod( 'flatep_src_woo_enqueue', 'default' );
            $is_shop_page = false;
            if($act === 'shop_pages'){
                $is_shop_page = (! is_cart() && ! is_checkout() );
            }
            $is_base = $this->is_conditional_loader_base($act, get_theme_mod( 'flatep_src_woo_pages', '' ));
            if( $is_shop_page || $is_base ){
                $list['woocommerce-layout'] = 'style';
                $list['woocommerce-general']    = 'style';
                $list['woocommerce-smallscreen'] = 'style';
                $list['wc-cart-fragments'] = 'script';
                $list['woocommerce'] = 'script';
                $list['flatsome-theme-woocommerce-js'] = 'script';
                $list['wc-add-to-cart'] = 'script';
            }
            $nb = $this->dequeue_style_list($list);
            if( $this->debug ){ FlaTep_Debug::print_debug( 3, sprintf('Woocommerce conditional load : nb dequeued -> %d / %d -- is_shop : %d -- is_base : %d', $nb, count($list), $is_shop_page, $is_base)); }
        }	
        return $tst;
    }

    

    /**
	 * Conditional load of jetpack scripts and styles.
     *
	 * @since   1.0.0
     *  
     * @return mixed	 True if all list is dequeued (dequeue only if already enqueued script)
     *                   False if part 
	 */
	private function jetpack_conditional(){
        $tst = -1;
        if( class_exists( 'Jetpack' )){
            $tst = false;
            $act = get_theme_mod( 'flatep_src_jetpack_enqueue', 'default' );
            $is_base = $this->is_conditional_loader_base($act, get_theme_mod( 'flatep_src_jetpack_pages', '' ));
            if( $is_base ){
                add_filter( 'jetpack_sharing_counts', '__return_false', 99 );
                add_filter( 'jetpack_implode_frontend_css', '__return_false', 99 );
                $tst = true;
            }
            
            if( $this->debug ){ FlaTep_Debug::print_debug( 3, sprintf('Jetpack conditional load : is_base : %d', $is_base)); }
        }
        	
        return $tst;
    }

    /**
	 * Test if is comon conditional loader parameter and if valid condition.
     *
	 * @since   1.0.0
     * 
     * @param string $act    		Loader action provided by flatep_src_woo_enqueue theme_mod.
     * @param string $pages    		Pages list separated by comma, -1 for home page.
     * 
     * @return bool	 True :
     *                  - If loader action is 'selected_pages' and current page is not in list $pages
     *                  - If loader action is 'never'
	 */
	private function is_conditional_loader_base($act, $pages=false){
        if( $act === 'selected_pages' && !is_flatep_page_from_list($pages, false)){
            return true;
        }
        else if( $act === 'never' ){
            return true;
        }
        	
        return false;
    }

    /**
	 * Constructor 
	 *
	 * @since   1.0.0
	 */
    function __construct(){
		// 
        $this->sources   = array();
        $this->versions  = array();
        $this->debug  = FlaTep_Debug::is_debug();
        $this->source_handles  = array();
        if( $this->debug ){ 
            FlaTep_Debug::print_debug( 4, 'Start FlaTep Header Structure Class');
            FlaTep_Debug::start_timer( 3, 'FlaTep_Setup' );
        }
        $this->run();
        if( $this->debug ){
            FlaTep_Debug::stop_timer( 3, 'FlaTep_Setup' );
        }
    }
    
    /**
	 * Initialyse data
	 *
	 * @since   1.0.0
	 */
	public function init_data(){
        $dir = get_stylesheet_directory().'/inc/functions/function-import-sources.php';
        if(is_file($dir)){
            include_once($dir);
            if(function_exists('flatep_sources_data')){
                $this->sources = flatep_sources_data();
                $nb = (is_array($this->sources)) ? count($this->sources) : 0;
                if( $this->debug ){ FlaTep_Debug::print_debug( 5, sprintf('Data Sources initialized -> %d', $nb)); }
            }
            else{
                if( $this->debug ){ FlaTep_Debug::print_debug( 1, 'Unable to initialyse source data - function flatep_sources_data unavalable'); }
            }
        }
        else{
            if( $this->debug ){ FlaTep_Debug::print_debug( 1, sprintf('Unable to initialyse source data - file %s  unavalable', $dir)); }
        }
        
    }
    
    /**
	 * Run function
	 *
	 * @since   1.0.0
	 */
	public function run(){
        $this->init_data(); //-> init data parameters
        // remove wordpress version from meta
		add_filter('the_generator', array($this, 'remove_wordpress_version'));
        
        //-> update styles and scripts loader tags
        add_filter( 'style_loader_tag', array($this, 'loader_tags_update'), 99, 3 );
        add_filter( 'script_loader_tag', array($this, 'loader_tags_update'), 99, 3 );
        
        //-> update viewport meta
        if(get_theme_mod( 'flatep_seo_viewport', false )){
            remove_action('wp_head', array($this, 'flatsome_viewport_meta'), 1);
            add_action( 'wp_head', array($this, 'flatep_viewport_meta'), 1 );
        }
        //-> Select jQuery Migrate Version
        add_action( 'wp_enqueue_scripts', array($this, 'select_jquery_mig_version'),10); 
        //-> Select jQuery Version
        add_action( 'wp_enqueue_scripts', array($this, 'select_jquery_version'), 10);
        //-> Setup Flatsome Scripts
        remove_action( 'wp_enqueue_scripts', 'flatsome_scripts', 100 );
        add_action( 'wp_enqueue_scripts', array($this, 'flatep_scripts'), 100 );
        //-> Select Replace enqued scripts
        add_action( 'wp_enqueue_scripts', array($this, 'flatep_replace_enqueued'),10);
        //-> Conditional load
        add_action( 'wp_enqueue_scripts', array($this, 'flatep_conditional_enqueues'), 105);
        /*if($this->debug){
            add_action( 'after_theme_setup', array($this, 'flatep_print_debug'), 100);
        }*/
        //> Add accessibility attributes to nav menu
        add_filter( 'nav_menu_link_attributes', array($this, 'set_nav_menu_link_attributes'), 10, 4);
               
    }
    

    public function flatep_print_debug() {
        if(is_array($this->source_handles)){
            $handles = implode(",", $this->source_handles);
            if(!empty($handles)){
                FlaTep_Debug::print_debug( 3, sprintf('Handles Enqueued -> %s', $handles));
            }
        }
        FlaTep_Debug::print_debug( 3, sprintf('No handles defined is_array() -> %s', is_array($this->source_handles)));
    }

    /**
     * Update Header Viewport Meta maximum-scale to 5. 
     * 
     * Google Audits - Accesissibility module 
     *
     * @return void
     */
    function flatep_viewport_meta() {
        echo apply_filters( 'flatsome_viewport_meta', '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped       
    }

    /**
	 * Remove meta generator version
     * 
     * Meta generator display wordpress version in header tep_disable_head_version
	 *
	 * @since   1.0.0
	 */
	public function remove_wordpress_version() {
		if( get_theme_mod( 'tep_disable_generator_version', true ) ){
			return '';
		}
    }
    
    /**
	 * Remove version of scripts and styles imported
     * Add cdn integrity parameters to imported script and styles
	 *
	 * @since   1.0.0
	 */
	public function loader_tags_update($html, $handle, $src){
		//-> remove versions from styles and scripts
		if(get_theme_mod( 'tep_disable_head_version', false )){
			if ( strpos( $src, 'ver=' ) ){
				// 
				$src_o = remove_query_arg( 'ver', $src );
				$html = str_replace($src, $src_o, $html);
				$src = $src_o;
			}
        }

        
        //-> add cdn integrity attributes to enqueued scripts and styles
        $vrs = $this->get_version_handle($handle);
        if (is_array($vrs)){
            foreach ($vrs as $handle_ver) {
                $handle_ver = sanitize_key($handle_ver);
                $type = $this->get_source_key($handle_ver, 'type');
                $src_f = $this->get_source_key($handle_ver, 'src');
                $integrity = $this->get_source_key($handle_ver, 'integrity');
                $crossorigin = $this->get_source_key($handle_ver, 'crossorigin');
                if($type && $integrity && $crossorigin && $src_f === $src){
                    if( $type === 'style' && wp_style_is( $handle, 'enqueued' ) ){
                        $html = str_replace( "media='all'", "media='all' integrity='". $integrity ."' crossorigin='". $crossorigin ."'", $html );
                    }
                    else if( $type === 'script' && wp_script_is( $handle, 'enqueued' ) ){
                        $html = str_replace( "type='text/javascript'", "type='text/javascript' integrity='". $integrity ."' crossorigin='". $crossorigin ."'", $html );
                    }
                }
            }
        }
        $debug = (FlaTep_Debug::is_debug_level(3)) ? ' <!--Handle : '.sanitize_key($handle).'-->' : '';
		return ($html . $debug);
    }
    
    /**
	 * Flatep Conditional loader. 
     * Dequeue all, plugin and themes, scripts and styles, defined.
     * Run on :
     *          - Woocommerce
     *          - Jetpack
     * 
	 *
	 * @since   1.0.0
	 */
	public function flatep_conditional_enqueues(){
        $tst = true;
        //->woocommerce conditional load of script and styles
        $tst = ($this->woocomerce_conditional() === false) ? false : $tst;
        //-> disable woocommerce add to card  
        $tst = ($this->jetpack_conditional() === false) ? false : $tst;

		if( $this->debug ){ FlaTep_Debug::print_debug( 3, sprintf('Conditional enqueues -> %d',$tst) ); }
		return $tst;
    }

    /**
	 * Replace enqueued script and styles source
	 *
	 * @since   1.0.0
	 */
	public function flatep_replace_enqueued(){
		$list = array('flatsome-infinite-scroll');
		$tst = true;
		// Check if WooCommerce plugin is active
		$tst = $this->replace_sources_list($list);
		if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Replace enqueued scripts -> %d',$tst) ); }
		return $tst;
    }
    /**
	 * Select jQuery version to load
	 *
	 * @since   1.0.0
	 */
	public function select_jquery_version(){
        $tst = false;
        $v = trim(sanitize_key(get_theme_mod( 'flatep_src_jquery_version', 'default' )));
        switch ($v) {
            case 'jquery_cdn_1_12_4':
                $tst = $this->flatep_update_enqueues('jquery', 'jquery-cdn-1-12-4', true);
                break;
			
            case 'jquery_cdn_2_2_4':
                $tst = $this->flatep_update_enqueues('jquery', 'jquery-cdn-2-2-4', true);
				break;
			
            case 'jquery_cdn_3_4_1':
                $tst = $this->flatep_update_enqueues('jquery', 'jquery-cdn-3-4-1', true);
				break;

			default:
				# code...
				break;
        }
        
        if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Select jQuery Version -> %d',$tst) ); }
		return $tst;
    }
    /**
	 * Select jQuery version to load
	 *
	 * @since   1.0.0
	 */
	public function select_jquery_mig_version(){
        $tst = false;
        $v = trim(sanitize_key(get_theme_mod( 'flatep_src_jquery_mig_version', 'default' )));
        switch ($v) {
            case 'jquery_mig_cdn_1_4_1':
                $tst = $this->flatep_update_enqueues('jquery-migrate', 'jquery-mig-cdn-1-4-1', true);
                break;
			
            case 'jquery_mig_cdn_3_1_0':
                $tst = $this->flatep_update_enqueues('jquery-migrate', 'jquery-mig-cdn-3-1-0', true);
                break;

			default:
				# code...
				break;
        }

		if( $this->debug ){ FlaTep_Debug::print_debug( 4, sprintf('Select jQuery Migrate Version -> %d', $tst) ); }
		return $tst;
	}
    
    /**
     * Setup Flatsome Styles and Scripts
     */
    function flatep_scripts() {
        $uri     = get_template_directory_uri();
        $theme   = wp_get_theme( get_template() );
        $version = $theme->get( 'Version' );

        // Styles.
        if ( ! is_rtl() ) {
            wp_enqueue_style( 'flatsome-main', $uri . '/assets/css/flatsome.css', array(), $version, 'all' );
        } else {
            wp_enqueue_style( 'flatsome-main-rtl', $uri . '/assets/css/flatsome-rtl.css', array(), $version, 'all' );
        }

        if ( is_woocommerce_activated() && ! is_rtl() ) {
            wp_enqueue_style( 'flatsome-shop', $uri . '/assets/css/flatsome-shop.css', array(), $version, 'all' );
        } elseif ( is_woocommerce_activated() ) {
            wp_enqueue_style( 'flatsome-shop-rtl', $uri . '/assets/css/flatsome-shop-rtl.css', array(), $version, 'all' );
        }

        // Load current theme styles.css file.
        if ( ! get_theme_mod( 'flatsome_disable_style_css', 0 ) ) {
            wp_enqueue_style( 'flatsome-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ), 'all' );
        }

        // Register styles (Loaded on request).
        wp_register_style( 'flatsome-effects', $uri . '/assets/css/effects.css', array(), $version, 'all' );

        // Register scripts (Loaded on request).
        wp_register_script( 'flatsome-masonry-js', $uri . '/assets/libs/packery.pkgd.min.js', array( 'jquery' ), $version, true );
        wp_register_script( 'flatsome-isotope-js', $uri . '/assets/libs/isotope.pkgd.min.js', array( 'jquery', 'flatsome-js' ), $version, true );

        // Google maps.
        $maps_api = trim( get_theme_mod( 'google_map_api' ) );
        if ( ! empty( $maps_api ) ) {
            wp_register_script( 'flatsome-maps', '//maps.googleapis.com/maps/api/js?key=' . $maps_api, array( 'jquery' ), $version, true );
        }

        // Enqueue theme scripts.
        wp_enqueue_script( 'flatsome-js', get_stylesheet_directory_uri() . '/assets/js/flatsome.js', array(
            'jquery',
            'hoverIntent',
        ), $version, true );

        $sticky_height = get_theme_mod( 'header_height_sticky', 70 );

        if ( is_admin_bar_showing() ) {
            $sticky_height = $sticky_height + 30;
        }

        $lightbox_close_markup = apply_filters('flatsome_lightbox_close_button', '<button title="%title%" type="button" class="mfp-close"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>');

        // Add variables to scripts.
        wp_localize_script( 'flatsome-js', 'flatsomeVars', array(
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
            'rtl'           => is_rtl(),
            'sticky_height' => $sticky_height,
            'lightbox'      => array(
                'close_markup'     => $lightbox_close_markup,
                'close_btn_inside' => apply_filters( 'flatsome_lightbox_close_btn_inside', false ),
            ),
            'user'          => array(
                'can_edit_pages' => current_user_can( 'edit_pages'
                ),
            ),
        ) );

        if ( is_woocommerce_activated() ) {
            wp_enqueue_script( 'flatsome-theme-woocommerce-js', $uri . '/assets/js/woocommerce.js', array( 'flatsome-js' ), $version, true );
        }

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    /**
	 * Replace enqueued script and styles source 
	 *
	 * @since   1.0.0
	 */
	public function set_nav_menu_link_attributes($atts, $item, $args, $depth){
		//print_r($atts);
        /*var_dump( $atts, $item ); // a lot of stuff we can use

        var_dump( $atts['href'] ); // string(36) "http://dev.rarst.net/our-philosophy/"

        var_dump( get_the_title( $item->object_id ) ); // string(14) "Our Philosophy", note $item itself is NOT a page

        if ( get_the_title( $item->object_id ) === 'Our Philosophy' ) { // for example

            $atts['href'] = 'https://example.com/';
        }*/
        if (!empty($atts['title'])){
            $atts['aria-label'] =  $atts['title'];
        }
        else{
            $atts['title'] = get_the_title( $item->object_id );
            $atts['aria-label'] =  $atts['title'];
        }
        
        return $atts;
    }

    
}

$flaTep_setup = new FlaTep_Setup(true);