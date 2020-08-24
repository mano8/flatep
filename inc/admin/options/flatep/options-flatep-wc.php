<?php
global $transport;
/*************
 * FlaTep Child Panel - SEO - SEO and Accessibility options
 *************/
Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_title_wc_product_list_attribute',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-wc',
	'default'  => '<div class="options-title-divider">Product list :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'      => 'sortable',
	'settings'  => 'flatep_wc_add_product_list_attribute',
	'label'         => __( 'List of attributes to show.', 'flatsome-admin' ),
	'section'   => 'flatep-options-wc',
	'transport' => $transport,
	'multiple'  => 99,
	'default'   => array( ),
	'choices'   => flatep_get_products_attributes_list(),
) );


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


