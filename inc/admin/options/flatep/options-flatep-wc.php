<?php

/*************
 * FlaTep Child Panel - SEO - SEO and Accessibility options
 *************/
Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_title_wc_meta',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-wc',
	'default'  => '<div class="options-title-divider">Add Meta Fields :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'          => 'checkbox',
	'settings'      => 'flatep_wc_add_cat_meta_years',
    'label'         => __( 'Add meta field years.', 'flatsome-admin' ),
    'description'   => __( 'Add custom meta field to product category.', 'flatsome-admin' ),
	'section'       => 'flatep-options-wc',
	'default'       => false,
) );


