<?php

/*************
 * FlaTep Child Panel - General Options
 *************/

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_title_general_child',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-general',
	'default'  => '<div class="options-title-divider">General Options :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'flatep_child_active',
	'label'    => __( 'Active child customizations', 'flatsome-admin' ),
	'section'  => 'flatep-options-general',
	'default'  => true,
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'flatep_debug',
    'label'    => __( 'Active debug.', 'flatsome-admin' ),
    'description' => __( 'Show debug on Query monitor plugin and html source.', 'flatsome-admin' ),
	'section'  => 'flatep-options-general',
	'default'  => false,
) );

Flatsome_Option::add_field( 'option',  array(
	'type'          => 'slider',
	'settings'      => 'flatep_debug_level',
	'label'         => __( 'Set debug level to show.', 'flatsome-admin' ),
	'description'   => __( 'Set 5 to show all, and 1 to view only warnings', 'flatsome-admin' ),
	'section'       => 'flatep-options-general',
	'default'       => 3,
	'choices'       => array(
		'min'  => 1,
		'max'  => 5,
		'step' => 1
	),
	'transport' => 'postMessage',

));

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'flatep_title_display_versions',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-options-general',
	'default'  => '<div class="options-title-divider">Versions Display :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'tep_disable_generator_version',
	'label'    => __( 'Remove meta generator version', 'flatsome-admin' ),
	'section'  => 'flatep-options-general',
	'default'  => false,
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'tep_disable_head_version',
	'label'    => __( 'Remove All js and css import versions.', 'flatsome-admin' ),
	'description' => __( "Active when finish web creation. That's Enable Navigator caching.", 'flatsome-admin' ),
	'section'  => 'flatep-options-general',
	'default'  => false,
) );