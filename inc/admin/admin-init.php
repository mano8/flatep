<?php
/**
 * FlaTep Admin Engine Room.
 * This is where all Admin Functions run
 *
 * @package flatep
 */


// Add Child Options

if(is_customize_preview()){
    // Include Options Helpers
    include_once(dirname( __FILE__ ).'/options/options-flatep/options-flatep.php');
}
