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
      'supports'           => array('title', 'editor', 'thumbnail'),
      'taxonomies'         => array('category', 'ambito_geografico')
  );
  register_post_type('impacto', $args );
}
add_action('init', 'impacto_type', 0);