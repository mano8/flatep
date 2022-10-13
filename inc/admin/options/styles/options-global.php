<?php

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'global_styles_tep_custom',
	'label'    => __( 'Select Custom Style', 'flatsome-admin' ),
	'description'    => __( 'Select Global Custom Style.', 'flatsome-admin' ),
	'section'  => 'global-styles',
	'default'  => 'default',
    'choices'  => $flatep_styles,
    'transport'   => 'postMessage',
));

Flatsome_Option::add_field( 'option',  array(
	'type'        => 'text',
	'settings'     => 'global_styles_tep_custom-pages',
    'label'       => __( 'Apply Custom Style to listed pages', 'flatsome-admin' ),
    'description'    => __( 'Set page id or slug separated by comma (-1 for home page).', 'flatsome-admin' ),
	'section'     => 'global-styles',
	'transport'   => 'postMessage',
	'default'     => '',
));