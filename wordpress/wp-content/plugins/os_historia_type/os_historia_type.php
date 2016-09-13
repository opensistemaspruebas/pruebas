<?php

/*
    Plugin Name: OS Historia Type
    Plugin URI: https://www.opensistemas.com/
    Description: Crea el tipo de contenido 'historia'.
    Version: 1.0
    Author: Marta Oliver
    Author URI: https://www.opensistemas.com/
    License: GPLv2 or later
    Text Domain: os_historia_type
*/


function load_text_domain_story() {
  load_plugin_textdomain('os_historia_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_story', 10);


function historia_type() {
  $labels = array(
    'name'                => _x('Historias', 'post type general name', 'os_historia_type'),
    'singular_name'       => _x('Historia', 'post type singular name', 'os_historia_type'),
    'menu_name'           => __('Historias', 'os_historia_type'),
    'parent_item_colon'   => __('Superior:', 'os_historia_type'),
    'all_items'           => __('Todas las historias', 'os_historia_type'),
    'view_item'           => __('Ver historia', 'os_historia_type'),
    'add_new_item'        => __('Añadir nueva historia', 'os_historia_type'),
    'add_new'             => __('Añadir nueva', 'os_historia_type'),
    'edit_item'           => __('Editar historia', 'os_historia_type'),
    'update_item'         => __('Actualizar historia', 'os_historia_type'),
    'search_items'        => __('Buscar historias', 'os_historia_type'),
    'not_found'           => __('No se han encontrado historias.', 'os_historia_type'),
    'not_found_in_trash'  => __('No se han encontrado historias en la papelera.', 'os_historia_type'),
  );
  $args = array(
      'labels'             => $labels,
      'description'        => __( 'Descripción.', 'os_historia_type'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'historia'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'           => 'dashicons-book',
      'supports'           => array('title', 'author', 'thumbnail', 'excerpt'),
      'taxonomies'         => array('category', 'post_tag', 'country')
  );
  register_post_type('historia', $args );
}
add_action('init', 'historia_type', 0);