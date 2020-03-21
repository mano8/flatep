<?php
$dir = get_template_directory() . '/inc/builder/shortcodes';
$dir_child = get_stylesheet_directory() . '/inc/builder/shortcodes';


if ( class_exists( 'EM_Events' ) ){
  require_once $dir_child . '/ux_events_list_grouped.php';

  // is active or whenever a shortcode is rendered for the
  // builder or when the builder is saving.
  $is_uxbuilder = isset( $_POST['ux_builder_action'] );
  $is_rendering = $is_uxbuilder && $_POST['ux_builder_action'] == 'do_shortcode';
  $is_saving = isset( $_POST['action'] ) && $_POST['action'] == 'ux_builder_save';
}
