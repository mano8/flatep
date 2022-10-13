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
    include_once(dirname( __FILE__ ).'/options/helpers/options-flatep-helpers.php');
    // Include Options Flatep
    include_once(dirname( __FILE__ ).'/options/flatep/options-flatep.php');
    // Include Options Header
    include_once(dirname( __FILE__ ).'/options/header/options-header.php');
    // Include Options Styles
    include_once(dirname( __FILE__ ).'/options/styles/options-global.php');
}
