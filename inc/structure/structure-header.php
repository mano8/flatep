<?php
/**
 * FlaTep Structure.
 *
 * Header Structure.
 *
 * @package FlaTep\Structures
 */


class FlaTep_Header{

    private $debug;

    function __construct(){
		// Start the 'foo' timer:
		$this->debug = (get_theme_mod( 'flatep_debug', false ) === true) ? true : false;
        
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
		$debug = ($this->debug) ? ' <!--Handle : '.sanitize_key($handle).'-->' : '';
		return ($html . $debug);
	}
}

$flaTep_header = new FlaTep_Header(true);