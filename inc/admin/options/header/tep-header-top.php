<?php

Flatsome_Option::add_field( '', array(
	'type'     => 'custom',
	'settings' => 'top_bar_tep_title_display',
	'label'    => __( '', 'flatsome-admin' ),
	'section'  => 'top_bar',
	'default'  => '<div class="options-title-divider">Display Options :</div>',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'top_bar_tep_sel_active_pages',
	'label'    => __( 'Active Head Top on selected pages', 'flatsome-admin' ),
    'section'  => 'top_bar',
    'transport'   => 'postMessage',
	'default'  => false,
) );

Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'top_bar_tep_actived_pages',
	'label'       => __( 'Add Head Top to listed pages', 'flatsome-admin' ),
	'description' => __( 'Set page id or slug separated by comma (-1 for home page)', 'flatsome-admin' ),
	'tooltip'     => __( 'Pages must id, slug or title separated with comma<br /> (eg : 1,contact,...)', 'flatsome-admin' ),
	'section'     => 'top_bar',
	'transport'   => 'postMessage',
) );

