<?php

/*
	Plugin Name: OS Publicación Type
	Plugin URI: https://www.opensistemas.com/
	Description: Crea el tipo de contenido 'publicación'.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_report_type
*/


function load_text_domain() {
    $plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain('os_report_type', false, $plugin_dir . "/languages");
}
add_action('plugins_loaded', 'load_text_domain', 10);


function report_post_type() {
  // Set UI labels for Custom Post Type
  $labels = array(
    'name'                => _x('Publicaciones', 'Post Type General Name', 'os_report_type'),
    'singular_name'       => _x('Publicación', 'Post Type Singular Name', 'os_report_type'),
    'menu_name'           => __('Publicaciones', 'os_report_type'),
    'parent_item_colon'   => __('Publicación padre', 'os_report_type'),
    'all_items'           => __('Todas las publicaciones', 'os_report_type'),
    'view_item'           => __('Ver publicación', 'os_report_type'),
    'add_new_item'        => __('Añadir nueva publicación', 'os_report_type'),
    'add_new'             => __('Añadir nueva', 'os_report_type'),
    'edit_item'           => __('Editar publicación', 'os_report_type'),
    'update_item'         => __('Actualizar publicación', 'os_report_type'),
    'search_items'        => __('Buscar publicaciones', 'os_report_type'),
    'not_found'           => __('No se ha encontrado ninguna publicación', 'os_report_type'),
    'not_found_in_trash'  => __('No se ha encontrado ninguna publicación en la papelera', 'os_report_type'),
  );
  // Set other options for Custom Post Type
  $args = array(
    'label'               => __('Publicaciones', 'os_report_type'),
    'description'         => __('Publicaciones', 'os_report_type'),
    'labels'              => $labels,
    'supports'            => array('title', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'page',
    // This is where we add taxonomies to our CPT
    'taxonomies'          => array('category', 'post_tag', 'country'),
  );
  // Registering your Custom Post Type
  register_post_type('report', $args );
}



function reports_fields_function() {
  if (function_exists("register_field_group")) {
    register_field_group(array (
      'id' => 'acf_fuente',
      'title' => 'Fuente',
      'fields' => array (
        array (
          'key' => 'field_57d2a8d7d0fb8',
          'label' => __('Nombre', 'os_report_type'),
          'name' => 'nombre',
          'type' => 'text',
          'instructions' => 'Banco Mundial',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57d2a2d0a5753',
          'label' => __('URL', 'os_report_type'),
          'name' => 'url',
          'type' => 'text',
          'instructions' => 'http://www.example.com/',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'html',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57d2a6d4148c2',
          'label' => __('Fecha de publicación', 'os_report_type'),
          'name' => 'fecha_de_publicacion',
          'type' => 'date_picker',
          'instructions' => 'DD/MM/YYYY',
          'date_format' => 'yymmdd',
          'display_format' => 'dd/mm/yy',
          'first_day' => 1,
        ),
        array (
          'key' => 'field_57d2a824895c0',
          'label' => __('Tipo', 'os_report_type'),
          'name' => 'tipo',
          'type' => 'select',
          'choices' => array (
            'Informe' => 'Informe',
          ),
          'default_value' => 'Informe',
          'allow_null' => 0,
          'multiple' => 0,
        ),
        array (
          'key' => 'field_57d2a84d895c1',
          'label' => __('Público objetivo', 'os_report_type'),
          'name' => 'publico_objetivo',
          'type' => 'select',
          'choices' => array (
            'Expertos' => 'Expertos',
          ),
          'default_value' => 'Expertos',
          'allow_null' => 0,
          'multiple' => 0,
        ),
        array (
          'key' => 'field_57d2a92cc44e1',
          'label' => __('Número de páginas', 'os_report_type'),
          'name' => 'numero_de_paginas',
          'type' => 'number',
          'instructions' => '1234',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'min' => '',
          'max' => '',
          'step' => '',
        ),
        array (
          'key' => 'field_57d2a94531506',
          'label' => __('Código JEL', 'os_report_type'),
          'name' => 'codigo_jel',
          'type' => 'number',
          'instructions' => '13423534356546',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'min' => '',
          'max' => '',
          'step' => '',
        ),
        array (
          'key' => 'field_57d2a96294b76',
          'label' => __('Edición', 'os_report_type'),
          'name' => 'edicion',
          'type' => 'text',
          'instructions' => '3º',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'html',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57d2a97828bd7',
          'label' => __('Editorial', 'os_report_type'),
          'name' => 'editorial',
          'type' => 'text',
          'instructions' => 'BBVA Colombia',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57d2a994ff817',
          'label' => __('Logo', 'os_report_type'),
          'name' => 'logo',
          'type' => 'image',
          'instructions' => __('Logo de la fuente', 'os_report_type'),
          'save_format' => 'object',
          'preview_size' => 'thumbnail',
          'library' => 'all',
        ),
      ),
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'report',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options' => array (
        'position' => 'side',
        'layout' => 'default',
        'hide_on_screen' => array (
        ),
      ),
      'menu_order' => 0,
    ));
    register_field_group(array (
        'id' => 'acf_informe-completo',
        'title' => __('Informe completo', 'os_report_type'),
        'fields' => array (
          array (
            'key' => 'field_57d2aebb3dedf',
            'label' => __('Informe', 'os_report_type'),
            'name' => 'informe',
            'type' => 'file',
            'instructions' => 'PDF',
            'save_format' => 'object',
            'library' => 'all',
          ),
        ),
        'location' => array (
          array (
            array (
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'report',
              'order_no' => 0,
              'group_no' => 0,
            ),
          ),
        ),
        'options' => array (
          'position' => 'acf_after_title',
          'layout' => 'default',
          'hide_on_screen' => array (
          ),
        ),
        'menu_order' => 0,
      ));
  }
}
add_action('acf/register_fields', 'reports_fields_function');



/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action('init', 'report_post_type', 0 );