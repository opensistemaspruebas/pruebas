<?php

/*
    Plugin Name: OS Impacto Type
    Plugin URI: https://www.opensistemas.com/
    Description: Crea el tipo de contenido 'impacto'.
    Version: 1.0
    Author: Marta Oliver
    Author URI: https://www.opensistemas.com/
    License: GPLv2 or later
    Text Domain: os_impacto_type
*/


function load_text_domain_impacto() {
  load_plugin_textdomain('os_impacto_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_impacto', 10);


function impacto_type() {
  $labels = array(
    'name'                => _x('Impactos', 'post type general name', 'os_impacto_type'),
    'singular_name'       => _x('Impacto', 'post type singular name', 'os_impacto_type'),
    'menu_name'           => __('Impactos', 'os_impacto_type'),
    'parent_item_colon'   => __('Superior:', 'os_impacto_type'),
    'all_items'           => __('Todas los impactos', 'os_impacto_type'),
    'view_item'           => __('Ver impacto', 'os_impacto_type'),
    'add_new_item'        => __('Añadir nueva impacto', 'os_impacto_type'),
    'add_new'             => __('Añadir nueva', 'os_impacto_type'),
    'edit_item'           => __('Editar impacto', 'os_impacto_type'),
    'update_item'         => __('Actualizar impacto', 'os_impacto_type'),
    'search_items'        => __('Buscar impactos', 'os_impacto_type'),
    'not_found'           => __('No se han encontrado impactos.', 'os_impacto_type'),
    'not_found_in_trash'  => __('No se han encontrado impactos en la papelera.', 'os_impacto_type'),
  );
  $args = array(
      'labels'             => $labels,
      'description'        => __( 'Descripción.', 'os_impacto_type'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'impacto'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'           => 'dashicons-chart-pie',
      'supports'           => array('title'),
      'taxonomies'         => array()
  );
  register_post_type('impacto', $args );
}
add_action('init', 'impacto_type', 0);


function impacto_meta_boxes() {
  add_meta_box('impacto_color', __('Color del impacto', 'os_impacto_type'), 'meta_box_color', 'impacto', 'normal', 'high');
}
add_action('add_meta_boxes', 'impacto_meta_boxes');


function load_impacto_scripts() {

  // Cargar scripts
  wp_register_script('jquery_simplecolorpicker_js', get_template_directory_uri() . '/resources/js/jquery.simplecolorpicker.js', array('jquery'));
  wp_enqueue_script('jquery_simplecolorpicker_js');
  wp_register_script('os_impacto_type_js', plugins_url('js/os_impacto_type.js' , __FILE__), array('jquery', 'jquery_simplecolorpicker_js'));
  wp_enqueue_script('os_impacto_type_js');

  // Cargar styles
  wp_register_style('jquery_simplecolorpicker_css', get_template_directory_uri() . '/resources/css/jquery.simplecolorpicker.css', false, '1.0.0' );
  wp_enqueue_style('jquery_simplecolorpicker_css');

}
add_action('admin_enqueue_scripts', 'load_impacto_scripts');


// Campo para seleccionar el color
function meta_box_color($post) {

  wp_nonce_field(basename(__FILE__), 'meta_box_color-nonce');

  $color = get_post_meta($post->ID, 'color', true);

  ?>
  <div class="form-group">
    <label class="col-sm-4 control-label" for="colorpicker-bootstrap3-form"><?php _e('Seleccione un color', 'os_impacto_type'); ?></label>
    <div class="col-sm-6">
      <select name="color" id="color" class="form-control">
        <option value="#5bbeff"><?php _e('Azul claro', 'os_impacto_type'); ?></option>
        <option value="#f8cd51"><?php _e('Amarillo', 'os_impacto_type'); ?></option>
        <option value="#14afb0"><?php _e('Azul verdoso', 'os_impacto_type'); ?></option>
      </select>
    </div>
  </div>
  <?php
}


function meta_boxes_impacto_save($post_id) {

  if (isset($_POST['color'])) {
    update_post_meta($post_id, 'color', strip_tags($_POST['color']));
  }

}
add_action('save_post', "meta_boxes_impacto_save");