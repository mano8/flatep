<?php

/*************
 * FlaTep Child Panel - Sources - Script And Styles Import Options
 *************/
Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_src_title_jquery',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => '<div class="options-title-divider">jQuery Sources :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'flatep_src_jquery_version',
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
	'settings' => 'flatep_src_jquery_mig_version',
	'label'    => __( 'Select Jquery Migrate Version', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => 'default',
	'choices'  => array(
		'default'  => __( 'jQquery Migrate Local 1.4.1', 'flatsome-admin' ),
		'jquery_mig_cdn_1_4_1'  => __( 'jQquery CDN Migrate 1.4.1', 'flatsome-admin' ),
		'jquery_mig_cdn_3_1_0'  => __( 'jQquery CDN Migrate 3.1.0', 'flatsome-admin' ),
	),
));

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_src_title_fontawesome',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => '<div class="options-title-divider">Font Awesome :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     		=> 'checkbox',
	'settings' 		=> 'flatep_src_fontawesome_add',
	'label'    		=> __( 'Add FontAwesome Icons', 'flatsome-admin' ),
	'description' 	=> __( 'Active font awesome icons on selected pages', 'flatsome-admin' ),
	'section'  		=> 'flatep-options-sources',
	'default'  		=> false,
) );


Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'flatep_src_fontawesome_version',
	'label'    => __( 'Select FontAwesome Versions', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => 'cdn_fontawesome_4_7',
	'choices'  => array(
        'cdn_fontawesome_4_7'         => __( 'CDN FontAwesome 4.7', 'flatsome-admin' ),
		'cdn_fontawesome_5_12_1'      => __( 'CDN FontAwesome 5.12.1', 'flatsome-admin' ),
	),
));

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'flatep_src_fontawesome_classes',
	'label'    => __( 'Fontawesome class to load', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => 'brands_solid',
	'choices'  => array(
        'all'               => __( 'All', 'flatsome-admin' ),
        'brands_solid'      => __( 'Brands and Solid', 'flatsome-admin' ),
		'brands'            => __( 'Brands', 'flatsome-admin' ),
		'solid'             => __( 'Solid', 'flatsome-admin' ),
	),
));

Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'flatep_src_fontawesome_pages',
	'label'       => __( 'Pages list to add FontAwesome', 'flatsome-admin' ),
	'description' => __( 'If null fontawesome be loaded on all pages <br /> (very bad for speed purpose) <br />Set to -1 for home and set list of page ids or slug separated by a coma.', 'flatsome-admin' ),
	'tooltip'     => __( 'Pages must id, slug or title separated with comma<br /> (eg : 1,contact,...)', 'flatsome-admin' ),
	'section'     => 'flatep-options-sources',
	'transport'   => 'postMessage',
) );

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_src_title_woo',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => '<div class="options-title-divider">Woocommerce :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     		=> 'checkbox',
	'settings' 		=> 'flatep_src_woo_disable_card',
	'label'    		=> __( 'Disable shop card on all pages', 'flatsome-admin' ),
	'description' 	=> __( 'Disable all woocommerce shop card imports', 'flatsome-admin' ),
	'section'  		=> 'flatep-options-sources',
	'default'  		=> false,
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'flatep_src_woo_enqueue',
	'label'    => __( 'Woocommerce conditional load', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => 'default',
	'choices'  => array(
        'default'               => __( '', 'flatsome-admin' ),
        'selected_pages'      => __( 'Only on selected pages', 'flatsome-admin' ),
		'shop_pages'            => __( 'Only on shop pages', 'flatsome-admin' ),
		'never'             => __( 'Never', 'flatsome-admin' ),
	),
));
Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'flatep_src_woo_pages',
	'label'       => __( 'Pages list to load woocommerce', 'flatsome-admin' ),
	'description' => __( 'Set to -1 for home and set list of page ids or slug separated by a coma.', 'flatsome-admin' ),
	'section'     => 'flatep-options-sources',
	'transport'   => 'postMessage',
) );

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_src_title_jetpack',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => '<div class="options-title-divider">Woocommerce :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'flatep_src_jetpack_enqueue',
	'label'    => __( 'Jetpack conditional load', 'flatsome-admin' ),
	'section'  => 'flatep-options-sources',
	'default'  => 'default',
	'choices'  => array(
        'default'               => __( '', 'flatsome-admin' ),
        'selected_pages'      => __( 'Only on selected pages', 'flatsome-admin' ),
		'never'             => __( 'Never', 'flatsome-admin' ),
	),
));
Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'flatep_src_jetpack_pages',
	'label'       => __( 'Pages list to load jetpack', 'flatsome-admin' ),
	'description' => __( 'Set to -1 for home and set list of page ids or slug separated by a coma.', 'flatsome-admin' ),
	'section'     => 'flatep-options-sources',
	'transport'   => 'postMessage',
) );


