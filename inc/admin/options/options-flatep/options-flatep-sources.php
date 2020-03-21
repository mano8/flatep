<?php

/*************
 * FlaTep Child Panel - Sources - Script And Styles Import Options
 *************/
Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_title_jquery_sources',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => '<div class="options-title-divider">jQuery Sources :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'flatep_jquery_version',
	'label'    => __( 'Select Jquery Version', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => 'default',
	'choices'  => array(
		'default'         => __( 'jQquery Local 1.12', 'flatsome-admin' ),
		'jquery_cdn_1_12_4'         => __( 'jQquery CDN 1.12.4', 'flatsome-admin' ),
		'jquery_cdn_2_2_4'      	=> __( 'jQquery CDN 2.2.4', 'flatsome-admin' ),
        'jquery_cdn_3_4_1'      	=> __( 'jQquery CDN 3.4.1', 'flatsome-admin' ),
	),
));

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'flatep_jquery_mig_version',
	'label'    => __( 'Select Jquery Migrate Version', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => 'default',
	'choices'  => array(
		'default'  => __( 'jQquery Migrate Local 1.4.1', 'flatsome-admin' ),
		'jquery_mig_cdn_1_4_1'  => __( 'jQquery CDN Migrate 1.4.1', 'flatsome-admin' ),
		'jquery_mig_cdn_3_1_0'  => __( 'jQquery CDN Migrate 3.1.0', 'flatsome-admin' ),
	),
));