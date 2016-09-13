<?php

/*
    Plugin Name: OS Story Type
    Plugin URI: https://www.opensistemas.com/
    Description: Crea el tipo de contenido 'historia'.
    Version: 1.0
    Author: Marta Oliver
    Author URI: https://www.opensistemas.com/
    License: GPLv2 or later
    Text Domain: os_story_type
*/


function load_text_domain_story() {
  load_plugin_textdomain('os_story_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_story', 10);


function story_post_type() {
  $labels = array(
    'name'                => _x('Stories', 'post type general name', 'os_story_type'),
    'singular_name'       => _x('Story', 'post type singular name', 'os_story_type'),
    'menu_name'           => __('Stories', 'os_story_type'),
    'parent_item_colon'   => __('Parent Stories:', 'os_story_type'),
    'all_items'           => __('All Stories', 'os_story_type'),
    'view_item'           => __('View Story', 'os_story_type'),
    'add_new_item'        => __('Add New Story', 'os_story_type'),
    'add_new'             => __('Add New', 'os_story_type'),
    'edit_item'           => __('Edit Story', 'os_story_type'),
    'update_item'         => __('Update Story', 'os_story_type'),
    'search_items'        => __('Search Stories', 'os_story_type'),
    'not_found'           => __('Not stories found.', 'os_story_type'),
    'not_found_in_trash'  => __('Not stories found in Trash.', 'os_story_type'),
  );
  $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'os_story_type'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'story'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'           => 'dashicons-book',
      'supports'           => array('title', 'author', 'thumbnail', 'excerpt'),
      'taxonomies'         => array('category', 'post_tag', 'country')
  );
  register_post_type('story', $args );
}
add_action('init', 'story_post_type', 0);