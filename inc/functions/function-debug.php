<?php
/**
 * FlaTep Function Debug.
 *
 * Debug theme function.
 *
 * @package FlaTep\Functions
 */

class FlaTep_Debug{

    /**
     * @static
     * @access protected
     * @var bool
     */
    private static $active;

    /**
     * @static
     * @access protected
     * @var int
     */
    private static $level;


    /**
	 * set Debug
	 *
	 * @since   1.0.0
	 */
	private static function set_debug($active){
        FlaTep_Debug::$active = ($active === true) ? true : false;	
    }

    /**
	 * set Debug
	 *
	 * @since   1.0.0
	 */
	private static function set_level($level){
        FlaTep_Debug::$level = ($level > 0 && $level <= 5) ? $level : 3;	
    }

    /**
	 * Constructor 
	 *
	 * @since   1.0.0
	 */
    function __construct(){
		// Start the 'foo' timer:
        FlaTep_Debug::set_debug(get_theme_mod( 'flatep_debug', false ));
        FlaTep_Debug::set_level(get_theme_mod( 'flatep_debug_level', 3 ));
        
        FlaTep_Debug::print_debug( 3, sprintf('Start FlaTepDebug Class -- active :  %d -- level : %d', FlaTep_Debug::is_debug(), FlaTep_Debug::get_level()) );
    }

    /**
	 * Is debug Active
	 *
	 * @since   1.0.0
	 */
	public static function is_debug(){
        return FlaTep_Debug::$active;	
    }

    /**
	 * Is debug Active
	 *
	 * @since   1.0.0
	 */
	public static function get_level(){
        return FlaTep_Debug::$level;	
    }

    /**
	 * Is debug Active
	 *
	 * @since   1.0.0
	 */
	public static function is_debug_level($level){
        return (current_user_can( 'manage_options') && FlaTep_Debug::is_debug() && FlaTep_Debug::get_level() > 0 && $level <= FlaTep_Debug::get_level());
    }

    /**
	 * Replace to cdn providers list of handles
	 *
	 * @since   1.0.0
	 */
	public static function print_debug($level, $msg){
        // Start the 'foo' timer:
        if(FlaTep_Debug::is_debug_level($level)){
            do_action( 'qm/debug', $msg );
        }		
    }

    /**
	 * Replace to cdn providers list of handles
	 *
	 * @since   1.0.0
	 */
	public static function start_timer($level, $handle){
        // Start the 'foo' timer:
        if(FlaTep_Debug::is_debug_level($level)){
            do_action( 'qm/start', $handle );
        }		
    }

    /**
	 * Replace to cdn providers list of handles
	 *
	 * @since   1.0.0
	 */
	public static function stop_timer($level, $handle){
        // Start the 'foo' timer:
        if(FlaTep_Debug::is_debug_level($level)){
            do_action( 'qm/stop', $handle );
        }		
    }   
}

new FlaTep_Debug();