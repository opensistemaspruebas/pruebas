<?php

/*
	Plugin Name: OS Report Type
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
    'name'                => _x('Reports', 'Post Type General Name', 'os_report_type'),
    'singular_name'       => _x('Report', 'Post Type Singular Name', 'os_report_type'),
    'menu_name'           => __('Reports', 'os_report_type'),
    'parent_item_colon'   => __('Parent Report', 'os_report_type'),
    'all_items'           => __('All Reports', 'os_report_type'),
    'view_item'           => __('View Report', 'os_report_type'),
    'add_new_item'        => __('Add New Report', 'os_report_type'),
    'add_new'             => __('Add New', 'os_report_type'),
    'edit_item'           => __('Edit Report', 'os_report_type'),
    'update_item'         => __('Update Report', 'os_report_type'),
    'search_items'        => __('Search Report', 'os_report_type'),
    'not_found'           => __('Not Found', 'os_report_type'),
    'not_found_in_trash'  => __('Not Found in Trash', 'os_report_type'),
  );
  // Set other options for Custom Post Type
  $args = array(
    'label'               => __('reports', 'os_report_type'),
    'description'         => __('Reports', 'os_report_type'),
    'labels'              => $labels,
    'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
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
  register_post_type('reports', $args );
}


/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action('init', 'report_post_type', 0 );