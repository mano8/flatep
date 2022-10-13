<?php
/**
 * FlaTep Class Events manager.
 *
 * Events manager theme Class.
 *
 * @package FlaTep\Classes
 */
function flatep_default_calendar_args($args){
    if(is_array($args)){
        $args['status'] = (!isset($args['status'])) ? '1' : $args['status'];
        $args['private'] = (!isset($args['private'])) ? '0' : $args['private'];
        $args['category'] = (!isset($args['category'])) ? '-annulee' : $args['category'];
    }
    //FlaTep_Debug::print_debug(2, 'Calendar default category added'.print_r($args));
    return $args;
}
add_filter('em_content_calendar_args', 'flatep_default_calendar_args' , 10, 1);
//apply_filters('em_content_calendar_args', $args)