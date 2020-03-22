<?php

/*************
 * FlaTep Child Panel - SEO - SEO and Accessibility options
 *************/
Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_title_seo_accessibility',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-seo',
	'default'  => '<div class="options-title-divider">Accessibility :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'          => 'checkbox',
	'settings'      => 'flatep_seo_viewport',
    'label'         => __( 'Set viewport maximum Scale to 5.', 'flatsome-admin' ),
    'description'   => __( 'Thats minimum in Google Audit Accessibility module.', 'flatsome-admin' ),
	'section'       => 'flatep-options-seo',
	'default'       => false,
) );