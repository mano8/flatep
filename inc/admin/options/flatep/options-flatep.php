<?php

/*************
 * FlaTep Child Panel
 *************/

Flatsome_Option::add_panel( 'flatep-options-panel', array(
	'title'       => __( 'FlaTep Options', 'flatsome-admin' ),
	'description' => __( 'General child theme options.', 'flatsome-admin' ),
) );

Flatsome_Option::add_section( 'flatep-options-general', array(
	'title'       => __( 'General', 'flatsome-admin' ),
	'panel'       => 'flatep-options-panel',
) );

Flatsome_Option::add_section( 'flatep-options-sources', array(
	'title'       => __( 'Script And Styles Options', 'flatsome-admin' ),
	'panel'       => 'flatep-options-panel',
) );

Flatsome_Option::add_section( 'flatep-options-seo', array(
	'title'       => __( 'Seo Options', 'flatsome-admin' ),
	'panel'       => 'flatep-options-panel',
) );

Flatsome_Option::add_section( 'flatep-options-wc', array(
	'title'       => __( 'WooCommerce Options', 'flatsome-admin' ),
	'panel'       => 'flatep-options-panel',
) );

include_once(dirname( __FILE__ ).'/options-flatep-general.php');
include_once(dirname( __FILE__ ).'/options-flatep-sources.php');
include_once(dirname( __FILE__ ).'/options-flatep-seo.php');
include_once(dirname( __FILE__ ).'/options-flatep-wc.php');