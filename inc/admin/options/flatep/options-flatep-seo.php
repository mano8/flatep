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

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_title_seo_woo',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-seo',
	'default'  => '<div class="options-title-divider">Woocommerce :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'flatep_seo_woo_cat_link_before',
	'label'       => __( 'Words to add before category title links', 'flatsome-admin' ),
	'description' => __( 'Category links title semm : <br /> Before Category_name After', 'flatsome-admin' ),
	'section'     => 'flatep-options-seo',
	'transport'   => 'postMessage',
) );

Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'flatep_seo_woo_cat_link_after',
	'label'       => __( 'Words to add after category title links', 'flatsome-admin' ),
	'description' => __( 'Category links title semm : <br /> Before Category_name After', 'flatsome-admin' ),
	'section'     => 'flatep-options-seo',
	'transport'   => 'postMessage',
) );

Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'flatep_seo_woo_prod_link_before',
	'label'       => __( 'Words to add before products title links', 'flatsome-admin' ),
	'description' => __( 'Products links title semm : <br /> Before Product_name After', 'flatsome-admin' ),
	'section'     => 'flatep-options-seo',
	'transport'   => 'postMessage',
) );

Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'flatep_seo_woo_prod_link_after',
	'label'       => __( 'Words to add after products title links', 'flatsome-admin' ),
	'description' => __( 'Products links title semm : <br /> Before Product_name After', 'flatsome-admin' ),
	'section'     => 'flatep-options-seo',
	'transport'   => 'postMessage',
) );
