<?php

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'general_title_general_child',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'flatep-general-options',
	'default'  => '<div class="options-title-divider">General :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'flatep_child_active',
	'label'    => __( 'Active child customizations', 'flatsome-admin' ),
	'section'  => 'flatep-general-options',
	'default'  => true,
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'tep_disable_generator_version',
	'label'    => __( 'Remove meta generator version', 'flatsome-admin' ),
	'section'  => 'flatep-general-options',
	'default'  => false,
) );