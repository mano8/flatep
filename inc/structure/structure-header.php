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

    function __construct($debug=false){
		// Start the 'foo' timer:
		$this->debug = ($debug === true) ? true : false;
		
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
        $this->init_data();                                                     //-> init data parameters
		add_filter('the_generator', array($this, 'remove_wordpress_version'));  // remove versions from meta
		
    }
    

    /**
	 * Remove meta generator version
     * 
     * Meta generator display wordpress version in header
	 *
	 * @since   1.0.0
	 */
	public function remove_wordpress_version() {
		if( get_theme_mod( 'tep_disable_generator_version', true ) ){
			return '';
		}
	}
}

$flaTep_header = new FlaTep_Header(true);