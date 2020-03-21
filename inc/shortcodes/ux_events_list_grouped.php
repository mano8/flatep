<?php

function set_flatep_scopes($og_scope){
  $res = '';
  if(!empty($og_scope)){
    //-> $og_scope = '2020-03-02,2020-03-08';
    if($og_scope == 'next-week'){
      $date_now = new EM_DateTime();
      //obtain start of the week as per WordPress general settings
      $start_of_week = get_option('start_of_week');
      $day_of_week = $date_now->format('w');
      $offset = $day_of_week - $start_of_week;
      if($offset<0){ $offset += 7; }
      $ndate = $date_now->sub('PT3H');
      //$ndate = $date_now->sub('P'.$offset.'D');
      $res = $ndate->format('Y-m-d');

      $offset = 6;
      $ndate = $date_now->add('P'.$offset.'DT3H');
      $res .= ','.$ndate->format('Y-m-d');
    }
    else{
      $res = $og_scope;
    }
  }
  return $res;
}
// [ux_events_list_grouped]
function flatep_ux_events_list_grouped($atts, $content = null, $tag) {

  if ( ! is_array( $atts ) ) {
    $atts = array();
  }

  extract(shortcode_atts(array(
		// Meta
        'number'     => null,
        '_id' => 'evt-list-grp-'.rand(),
        'class' => '',
        'visibility' => '',
        'title' => '',
        'og_category' => '',
        'og_location' => '',
        'og_owner'=> '',
        'og_mode' => 'monthly',
        'og_limit' => 0,
        'og_offset' => '',
        'og_pagination' => 0,
        'og_scope' => 'next-week',
        'og_groupby'    => 'location_id',
        'og_orderby'    => 'category_id',
        'og_order'      => 'ASC',
        'og_groupby_orderby' => 'event_start_date, event_start_time',
        'og_groupby_order' => 'DESC',




        // Layout
      'style' => 'badge',
      'columns' => '4',
      'columns__sm' => '',
      'columns__md' => '',
      'col_spacing' => 'small',
      'type' => 'slider', // slider, row, masonery, grid
      'width' => '',
      'grid' => '1',
      'grid_height' => '600px',
      'grid_height__md' => '500px',
      'grid_height__sm' => '400px',
      'slider_nav_style' => 'reveal',
      'slider_nav_color' => '',
      'slider_nav_position' => '',
      'slider_bullets' => 'false',
      'slider_arrows' => 'true',
      'auto_slide' => 'false',
      'infinitive' => 'true',
      'depth' => '',
      'depth_hover' => '',

      // Box styles
      'animate' => '',
      'text_pos' => '',
      'text_padding' => '',
      'text_bg' => '',
      'text_color' => '',
      'text_hover' => '',
      'text_align' => 'center',
      'text_size' => '',

      'image_size' => '',
      'image_mask' => '',
      'image_width' => '',
      'image_hover' => '',
      'image_hover_alt' => '',
      'image_radius' => '',
      'image_height' => '',
      'image_overlay' => '',

      // depricated
      'bg_overlay' => '#000',
  
        ), $atts ) );
  
        
  if($tag == 'ux_events_list_grouped_grid'){
    $type = 'grid';
  }
 
  //$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

  $classes_box = array('box','box-blog-post','has-hover');
  $classes_image = array();
  $classes_text = array();
  
  // Create Grid
  if($type == 'grid'){
    $columns = 0;
    $current_grid = 0;
    $grid = flatsome_get_grid($grid);
    $grid_total = count($grid);
    flatsome_get_grid_height($grid_height, $_id);
  }  

  // Add Animations
  if($animate) {$animate = 'data-animate="'.$animate.'"';}

  // Set box style
  if($style) $classes_box[] = 'box-'.$style;
  if($style == 'overlay') $classes_box[] = 'dark';
  if($style == 'shade') $classes_box[] = 'dark';
  if($style == 'badge') $classes_box[] = 'hover-dark';
  if($text_pos) $classes_box[] = 'box-text-'.$text_pos;
  if($style == 'overlay' && !$image_overlay) $image_overlay = true;

  // Set image styles
  if($image_hover)  $classes_image[] = 'image-'.$image_hover;
  if($image_hover_alt)  $classes_image[] = 'image-'.$image_hover_alt;
  if($image_height)  $classes_image[] = 'image-cover';

  // Text classes
  if($text_hover) $classes_text[] = 'show-on-hover hover-'.$text_hover;
  if($text_align) $classes_text[] = 'text-'.$text_align;
  if($text_size) $classes_text[] = 'is-'.$text_size;
  if($text_color == 'dark') $classes_text[] = 'dark';

  $css_args_img = array(
    array( 'attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%'),
    array( 'attribute' => 'width', 'value' => $image_width, 'unit' => '%' ),
  );

  $css_image_height = array(
    array( 'attribute' => 'padding-top', 'value' => $image_height),
  );

  $css_args = array(
        array( 'attribute' => 'background-color', 'value' => $text_bg ),
        array( 'attribute' => 'padding', 'value' => $text_padding ),
  );

  $classes_col = array('product-category','col', 'evt-list-grouped-item');


  if($type == 'grid'){
    if($grid_total > $current_grid) $current_grid++;
    $current = $current_grid-1;
    $classes_col[] = 'grid-col';
    if($grid[$current]['height']) $classes_col[] = 'grid-col-'.$grid[$current]['height'];
    if($grid[$current]['span']) $classes_col[] = 'large-'.$grid[$current]['span'];
    if($grid[$current]['md']) $classes_col[] = 'medium-'.$grid[$current]['md'];

    // Set image size
    if($grid[$current]['size'] == 'large') $thumbnail_size = 'large';
    if($grid[$current]['size'] == 'medium') $thumbnail_size = 'medium';
}
  
  // if og_category
  if ( isset( $atts[ 'og_category' ] ) ) {
    $og_category = explode( ',', $atts[ 'og_category' ] );
    $og_category = array_map( 'trim', $og_category );
  } else {
    $og_category = '';
  }

  $og_scope = set_flatep_scopes($og_scope);
  /*$columns = ($columns > 0) ? $columns : 1;
  $columns__md = ($columns__md > 0) ? $columns__md : $columns;
  $columns__sm = ($columns__sm > 0) ? $columns__sm : $columns__md;

  $css_cols = 'large-columns-' . $columns . ' medium-columns-' . $columns__md . ' small-columns-' . $columns__sm; */
  ob_start();
  // Repeater options
  $repater['id'] = $_id;
  $repater['class'] = $class;
  $repater['visibility'] = $visibility;
  $repater['tag'] = $tag;
  $repater['type'] = $type;
  $repater['style'] = $style;
  $repater['format'] = $image_height;
  $repater['slider_style'] = $slider_nav_style;
  $repater['slider_nav_color'] = $slider_nav_color;
  $repater['slider_nav_position'] = $slider_nav_position;
  $repater['slider_bullets'] = $slider_bullets;
  $repater['auto_slide'] = $auto_slide;
  $repater['row_spacing'] = $col_spacing;
  $repater['row_width'] = $width;
  $repater['columns'] = $columns;
  $repater['columns__sm'] = $columns__sm;
  $repater['columns__md'] = $columns__md;
  $repater['depth'] = $depth;
  $repater['depth_hover'] = $depth_hover;


  get_flatsome_repeater_start($repater);

  
  
  $og_header = ob_get_contents();
  ob_end_clean();
  //$og_header = '<div class="row row-masonry '. $css_cols .'">';
  $og_header .= (!empty($title)) ? '<h2 class="uppercase" style="text-align: center;">' . $title . '</h2>' : '';
  $og_footer = '</div>';
  
  
  if((get_theme_mod( 'add_fontawesome_icons', false ))){
    $evt_badge = array(
      'past' => '<i class="fa fa-clock-o fa-2x" aria-hidden="true"></i>',
      'current' => '<i class="fa fa-clock-o fa-2x" aria-hidden="true"></i>',
      'future' => '<i class="fa fa-clock-o fa-2x" aria-hidden="true"></i>',
      'cancelled' => '<i class="fa fa-ban fa-2x" aria-hidden="true"></i>',
    );
    $evt_classes = array('is-xlarg');
  }
  else{
    $evt_badge = array(
      'past' => '<i class="icon-clock" aria-hidden="true"></i>',
      'current' => '<i class="icon-clock" aria-hidden="true"></i>',
      'future' => '<i class="icon-clock" aria-hidden="true"></i>',
      'cancelled' => 'Annulé',
    );
    $evt_classes = array('is-xsmall', 'uppercase');
  }  

  ob_start();
      ?>
      
        <div class="<?php echo implode(' ', $classes_col); ?>" <?php echo $animate;?> title="<?php echo $og_scope; ?>">
          <div class="col-inner">
            <a class="plain" href="#_EVENTURL">
              <div class="<?php echo implode(' ', $classes_box);?>">
                <div class="box-image" <?php echo get_shortcode_inline_css($css_args_img); ?>>
                  <div class="<?php echo implode(' ', $classes_image); ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
                    #_CATEGORYIMAGE{350,0}
                  </div>
                  <?php if($image_overlay){ ?><div class="overlay" style="background-color: <?php echo $image_overlay;?>"></div><?php } ?>
                  <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
                </div><!-- box-image -->
                <div class="box-text <?php echo implode(' ', $classes_text); ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
                  <div class="box-text-inner blog-post-inner">
                    <h4 class="evt-dates is-small uppercase">#_CATEGORYNAME</h4>
                    <div class="is-divider"></div>
                    <h5 class="evt-dates is-small uppercase">#_EVENTDATES</h5>
                    <p class="evt-hours from_the_blog_excerpt ">#_EVENTTIMES</p>
                    <div class="is-divider"></div>
                    <h5 class="evt-locations is-small uppercase">#_LOCATIONNAME</h5>
                    <p class="evt-loc-address is-xsmall op-7 uppercase">
                      #_LOCATIONADDRESS,
                    </p>
                    <p class="evt-loc-address is-small op-7 uppercase">
                      #_LOCATIONPOSTCODE - #_LOCATIONTOWN
                    </p>
                    <div class="is-divider"></div>
                    <h5 class="evt-locations is-small uppercase">Cours animés par <br />#_CONTACTNAME</h5>
                  </div>
                </div>
                
                <div class="badge absolute top post-date badge-circle-inside">
                  {is_past}<div class="badge-inner badge-evt-past <?php echo implode(' ', $evt_classes); ?>"><?php echo $evt_badge['past'] ?></div>{/is_past}
                  {is_current}<div class="badge-inner badge-evt-current <?php echo implode(' ', $evt_classes); ?>"><?php echo $evt_badge['current'] ?></div>{/is_current}
                  {is_future}<div class="badge-inner badge-evt-future <?php echo implode(' ', $evt_classes); ?>"><?php echo $evt_badge['future'] ?></div>{/is_future}
                </div>
                
                
              </div>
            </a>
          </div>
        </div>
      
     
     <?php 
      $og_content = ob_get_contents();
      ob_end_clean();
      $og_args=array(
        'header_format' => $og_header,
        'format' => $og_content,
        'footer_format'=> $og_footer,
        'mode' => $og_mode,
        'category' => $og_category,
        'scope' => $og_scope,
        'location' => $og_location,
        'limit' => (int) $og_limit,
        /*'status' => 1, //Limit search to locations with a spefic status (1 is active, 0 is pending approval) Default Value: 1
        'groupby' => $og_groupby,
        'orderby' => $og_orderby,
        'order' => $og_order,
        'groupby_orderby' => $og_groupby_orderby,
        'groupby_order' => $og_groupby_order,*/
        
      );


      $args = apply_filters('em_content_events_args', $og_args);
      $content = EM_Events::output_grouped($og_args);
      return $content;
}

add_shortcode("ux_events_list_grouped", "flatep_ux_events_list_grouped");