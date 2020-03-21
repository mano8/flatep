<?php
$dir = get_template_directory() . '/inc/builder/shortcodes';
$dir_child = get_stylesheet_directory() . '/inc/builder/shortcodes';



// Shortcode to display events list grouped
$repeater_col_spacing = 'small';
$repeater_columns = '4';
$repeater_type = 'slider';

$default_text_align = 'center';

$options = array(
'style_options' => array(
    'type' => 'group',
    'heading' => __( 'Style' ),
    'options' => array(
         'style' => array(
            'type' => 'select',
            'heading' => __( 'Style' ),
            'default' => 'badge',
            'options' => require( $dir . '/values/box-layouts.php' )
        )
    ),
),
'layout_options' => require( $dir . '/commons/repeater-options.php' ),
'layout_options_slider' => require( $dir . '/commons/repeater-slider.php' ),
'evt_meta' => array(
    'type' => 'group',
    'heading' => __( 'Meta' ),
    'options' => array(
    
    'og_mode' => array(
        'type' => 'select',
        'heading' => 'Mode',
        'description' => 'Decides how to split events up, possible options are : yearly, monthly, weekly, daily. Default: monthly',
        'default' => 'monthly',
        'options' => array(
            'yearly' => 'Yearly',
            'monthly' => 'Monthly',
            'weekly' => 'Weekly',
            'daily' => 'Daily',
        )
    ),
    'og_category' => array(
        'type' => 'select',
        'heading' => 'Categories',
        'param_name' => 'og_category',
        'config' => array(
            'multiple' => true,
            'placeholder' => 'Select..',
            'termSelect' => array(
                'post_type' => 'event-categories',
                'taxonomies' => 'event-categories'
            ),
        )
    ),
    'og_location' => array(
        'type' => 'select',
        'heading' => 'Places',
        'param_name' => 'og_location',
        'config' => array(
            'multiple' => true,
            'placeholder' => 'Select..',
            'postSelect' => array(
                'post_type' => 'location'
            ),
        )
    ),//-> todo : 
    'og_owner' => array(
        'type' => 'textfield',
        'heading' => 'Owners',
        'description' => 'Set owners separated by comma',
        'default' => '',
    
    ),
    'og_limit' => array(
        'type' => 'slider',
        'heading' => 'Limit',
        'responsive' => true,
        'min'        => 0,
        'max'        => 100
    ),
    'og_offset'          => array(
        'type'       => 'slider',
        'heading'    => 'Offset',
        'responsive' => true,
        'min'        => 0,
        'max'        => 100
    ),
    'og_pagination'            => array(
        'type'    => 'radio-buttons',
        'heading' => 'Pagination',
        'default' => '0',
        'options' => array(
            '1'  => array( 'title' => 'Active' ),
            '0' => array( 'title' => 'None' ),
        ),
    ),
    'og_scope' => array(
        'type' => 'select',
        'heading' => 'Scope',
        'description' => 'Choose the time frame of events to show. , 12-months, all)',
        'default' => 'next-week',
        'options' => array(
            'next-week' => 'Next Week',
            'future' => 'Future',
            'past' => 'Past',
            'today' => 'Today',
            'tomorrow' => 'Tomorrow',
            'month' => 'Month',
            'next-month' => 'Next Month',
            '1-months' => '1 Month',
            '2-months' => '2 Month',
            '3-months' => '3 Month',
            '6-months' => '6 Month',
            '12-months' => '12 Month',
            'all' => 'All',
        )
    ),

    'og_scope_times' => array(
        'type' => 'textfield',
        'heading' => 'Scope times',
        'description' => 'Choose the time frame of events to show. You can supply dates (in format of YYYY-MM-DD), either single for events on a specific date or two dates separated by a comma (e.g. 2010-12-25,2010-12-31) for events ocurring between these dates.',
        'default' => '',
    ),
    'og_groupby' => array(
        'type' => 'textfield',
        'heading' => __( 'Group By' ),
        'default' => 'location_id',
    ),
    'og_orderby' => array(
        'type' => 'textfield',
        'heading' => __( 'Order By' ),
        'default' => 'category_id',
    ),
    'og_order' => array(
        'type' => 'select',
        'heading' => __( 'Order' ),
        'default' => 'asc',
        'options' => array(
            'asc' => 'ASC',
            'desc' => 'DESC',
        )
    ),
    'og_groupby_orderby' => array(
        'type' => 'textfield',
        'heading' => __( 'Group By Order By' ),
        'default' => 'event_start_date, event_start_time',
    ),
    'og_groupby_order' => array(
        'type' => 'select',
        'heading' => __( 'Group By Order' ),
        'default' => 'desc',
        'options' => array(
            'asc' => 'ASC',
            'desc' => 'DESC',
        )
    ),
  ),
)
);


$box_styles = require( $dir . '/commons/box-styles.php' );
$options = array_merge($options, $box_styles);

$advanced = array('advanced_options' => require( $dir . '/commons/advanced.php'));
$options = array_merge($options, $advanced);

add_ux_builder_shortcode( 'ux_events_list_grouped', array(
    'name' => 'Events List Grouped',
    'category' => __( 'Events' ),
    'priority' => 3,
    #'wrap' => false,
    'thumbnail' =>  flatsome_ux_builder_thumbnail( 'categories' ),

   'presets' => array(
        array(
            'name' => __( 'Default' ),
            'content' => '[ux_events_list_grouped]'
        ),
        array(
            'name' => __( 'Simple' ),
            'content' => '[ux_events_list_grouped style="normal"]'
        ),array(
            'name' => __( 'Overlay' ),
            'content' => '[ux_events_list_grouped style="overlay" slider_nav_style="simple" slider_nav_position="outside" image_overlay="rgba(0, 0, 0, 0.19)" image_hover="overlay-remove-50" image_hover_alt="zoom"]'
        ),array(
            'name' => __( 'Grid' ),
            'content' => '[ux_events_list_grouped style="overlay" type="grid" grid="3" columns="3" animate="fadeInLeft" number="4" orderby="name" image_size="large" image_overlay="rgba(38, 38, 38, 0.16)" text_pos="middle" text_size="large"]'
        ),array(
            'name' => __( 'Circle Style' ),
            'content' => '[ux_events_list_grouped style="overlay" slider_nav_style="simple" slider_nav_position="outside" image_height="100%" image_radius="100" image_overlay="rgba(0, 0, 0, 0.19)" image_hover="overlay-remove-50" image_hover_alt="zoom" text_pos="middle" text_size="large" text_hover="bounce"]'
        ),array(
            'name' => __( 'Grid Dark' ),
            'content' => '[ux_events_list_grouped style="overlay" type="grid" grid="13" col_spacing="small" columns="3" depth_hover="5" animate="fadeInLeft" number="5" orderby="name" image_size="large" image_overlay="rgba(38, 38, 38, 0.16)" image_hover="color" image_hover_alt="zoom-long" text_pos="middle" text_size="large"]'
        ),
    ),
    'options' => $options
) );
