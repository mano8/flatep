<?php

/*************
 * Child Panel
 *************/

Flatsome_Option::add_panel( 'flatep-options-panel', array(
	'title'       => __( 'FlaTep Options', 'flatsome-admin' ),
	'description' => __( 'General child theme options.', 'flatsome-admin' ),
) );

Flatsome_Option::add_section( 'flatep-general-options', array(
	'title'       => __( 'General', 'flatsome-admin' ),
	'panel'       => 'flatep-options-panel',
) );

include_once(dirname( __FILE__ ).'/options-flatep-general.php');