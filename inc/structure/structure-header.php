<?php
/**
 * FlaTep Structure.
 *
 * Header Structure.
 *
 * @package FlaTep\Structures
 */


class FlaTep_Header{
    private $sources;
    private $debug;

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
        $handle = sanitize_key($handle);
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
        if($this->debug) {do_action( 'qm/debug', 'Update Enqueues -- Handle : '.$handle.' -- handle_ver : '.$handle_ver.' -- type : '.$type );}
		
		if($type === 'script'){
			if( wp_script_is( $handle, 'registered' )){
				$this->dequeue_script($handle);
				wp_register_script($handle, $src, $deps, $ver, $on_footer);
				wp_enqueue_script($handle);
			}
			else{
				if($force_register === true){
					$this->dequeue_script($handle);
					wp_register_script($handle, $src, $deps, $ver, $on_footer);
					wp_enqueue_script($handle);
				}
				else{
					$this->dequeue_script($handle);
					wp_enqueue_script($handle, $src, $deps, $ver, $on_footer);
				}
            }
            $this->add_version_handle($handle, $handle_ver);
			return true;   
		}
		else if($type === 'style'){
			if( wp_style_is( $handle, 'registered' )){
				$this->dequeue_style($handle);
				wp_register_style($handle, $src, $deps, $ver);
				wp_enqueue_style($handle);
			}
			else{
				if($force_register === true){
					$this->dequeue_style($handle);
					wp_register_style($handle, $src, $deps, $ver);
					wp_enqueue_style($handle);
				}
				else{
					$this->dequeue_style($handle);
					wp_enqueue_style($handle, $src, $deps, $ver);
				}
            }
            $this->add_version_handle($handle, $handle_ver);
			return true;   
		}
		return false;
    }
    

    /**
	 * Replace to cdn providers list of handles
	 *
	 * @since   1.0.0
	 */
	private function replace_sources_list($list){
        // Start the 'foo' timer:
        if(is_array($list)){
            if($this->debug) {do_action( 'qm/debug', 'Replace sources from list list_items -> '.count($list) );}
            $type = '';
            foreach ($list as $value) {
                $type = $this->get_source_key($value, 'type');
                if( !empty($type) ){
                    
                    if($this->debug) {do_action( 'qm/debug', 'Replace enqueued '.$type.' '.$value );}
                    $this->flatep_update_enqueues($this->get_source_key($value, 'handle'), $value, true);
                }
            }
        }		
    }
    
    /**
	 * Constructor 
	 *
	 * @since   1.0.0
	 */
    function __construct(){
		// Start the 'foo' timer:
		$this->debug     = (get_theme_mod( 'flatep_debug', false ) === true) ? true : false;
        $this->sources   = array();
        $this->versions  = array();
        
        if($this->debug) {do_action( 'qm/debug', 'Start FlaTep Header Structure Class' );}
		if($this->debug) {do_action( 'qm/start', 'FlaTep_Header' );}
        
        $this->run();
        
        if($this->debug) {do_action( 'qm/stop', 'FlaTep_Header' );}
    }
    
    /**
	 * Initialyse data
	 *
	 * @since   1.0.0
	 */
	public function init_data(){
        include_once(dirname( __FILE__ ).'/complements/structure-header-sources.php');
        if(function_exists('flatep_sources_data')){
            $this->sources = flatep_sources_data();
            $nb = (is_array($this->sources)) ? count($this->sources) : 0;
            if($this->debug) {do_action( 'qm/debug', 'Data Sources initialized -> ' . $nb);}
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
            remove_action('wp_head', 'flatsome_viewport_meta', 1);
            add_action( 'wp_head', 'flatep_viewport_meta', 1 );
        }
        //-> After theme setup
        add_action( 'wp_enqueue_scripts', array($this, 'select_jquery_mig_version'),10); 
        //-> Select jQuery Version
        add_action( 'wp_enqueue_scripts', array($this, 'select_jquery_version'), 10);
        
        
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
        //$this->is_version_handle()

		$debug = ($this->debug) ? ' <!--Handle : '.sanitize_key($handle).'-->' : '';
		return ($html . $debug);
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
	 * Replace enqueued script and styles source
	 *
	 * @since   1.0.0
	 */
	public function flatep_replace_enqueued(){
		$list = array();
		$tst = true;
		// Check if WooCommerce plugin is active
		$tst = $this->replace_sources_list($list);
		if($this->debug) {do_action( 'qm/debug', 'Replace enqueued scripts -> '.(($tst ===true) ? 'True' : 'False') );}
		return $tst;
    }
    /**
	 * Select jQuery version to load
	 *
	 * @since   1.0.0
	 */
	public function select_jquery_version(){
        $tst = false;
        $v = trim(sanitize_key(get_theme_mod( 'flatep_jquery_version', 'default' )));
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
        
        if($this->debug) {do_action( 'qm/debug', 'Select jQuery Version -> '.(($tst ===true) ? 'True' : 'False') );}
		return $tst;
    }
    /**
	 * Select jQuery version to load
	 *
	 * @since   1.0.0
	 */
	public function select_jquery_mig_version(){
        $tst = false;
        $v = trim(sanitize_key(get_theme_mod( 'flatep_jquery_mig_version', 'default' )));
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

		if($this->debug) {do_action( 'qm/debug', 'Select jQuery Migrate Version -> '.(($tst ===true) ? 'True' : 'False') );}
		return $tst;
	}
    

    
}

$flaTep_header = new FlaTep_Header(true);