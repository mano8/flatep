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
     * @access private
     * @var bool
     */
    private static $active;

    /**
     * @static
     * @access private
     * @var int
     */
    private static $level;


    /**
	 * set Debug
	 *
	 * @since   1.0.0
	 */
	private static function set_debug($active){
        self::$active = ($active === true) ? true : false;	
    }

    /**
	 * set Debug
	 *
	 * @since   1.0.0
	 */
	private static function set_level($level){
        self::$level = ($level > 0 && $level <= 5) ? $level : 3;	
    }

    /**
	 * Constructor 
	 *
	 * @since   1.0.0
	 */
    function __construct(){
		// Start the 'foo' timer:
        self::set_debug(get_theme_mod( 'flatep_debug', false ));
        self::set_level(get_theme_mod( 'flatep_debug_level', 3 ));
        
        self::print_debug( 3, sprintf('Start FlaTepDebug Class -- active :  %d -- level : %d', self::is_debug(), self::get_level()) );
    }

    /**
	 * Is debug Active
	 *
	 * @since   1.0.0
	 */
	public static function is_debug(){
        return self::$active;	
    }

    /**
	 * Is debug Active
	 *
	 * @since   1.0.0
	 */
	public static function get_level(){
        return self::$level;	
    }

    /**
	 * Is debug Active
	 *
	 * @since   1.0.0
	 */
	public static function is_debug_level($level){
        return (current_user_can( 'manage_options') && self::is_debug() && self::get_level() > 0 && $level <= self::get_level());
    }

    /**
	 * Replace to cdn providers list of handles
	 *
	 * @since   1.0.0
	 */
	public static function print_debug($level, $msg){
        // Start the 'foo' timer:
        if(self::is_debug_level($level)){
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
        if(self::is_debug_level($level)){
            do_action( 'qm/start', $handle );
        }		
    }

    /**
	 * Replace to cdn providers list of handles
	 *
	 * @since   1.0.0
	 */
	public static function stop_timer($level, $handle){
        // Stop the 'foo' timer:
        if(self::is_debug_level($level)){
            do_action( 'qm/stop', $handle );
        }		
    }   
}

new FlaTep_Debug();