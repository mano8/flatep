<?php
/**
 * FlaTep Structure Headers sources data.
 *
 * Header Structure.
 *
 * @package FlaTep\Structure\Complements
 */
function flatep_sources_data(){
    return array(
        //-> 
        'flatsome-js' => array(
            'type' => 'script',
            'handle' => 'flatsome-js',
            'src' => get_stylesheet_directory_uri() . '/assets/js/flatsome.js',
            'integrity' => false,
            'crossorigin' => false,
            'deps' => array('jquery', 'hoverIntent'),
            'ver' => null,
            'on_footer' => true,
        ),
    );
}
