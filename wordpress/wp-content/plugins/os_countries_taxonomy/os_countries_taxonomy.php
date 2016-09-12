<?php

/*
	Plugin Name: OS Países Taxonomy
	Plugin URI: https://www.opensistemas.com/
	Description: Crea la taxonomía países..
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_countries_taxonomy
*/


function create_country_taxonomy() {

    // Set the name of the taxonomy
    $taxonomy = 'country';
    // Set the post types for the taxonomy
    $object_type = 'post';
    
    // Populate our array of names for our taxonomy
    $labels = array(
        'name'               => __('Países', 'os_countries_taxonomy'),
        'singular_name'      => __('País', 'os_countries_taxonomy'),
        'search_items'       => __('Buscar países', 'os_countries_taxonomy'),
        'all_items'          => __('Todos los países', 'os_countries_taxonomy'),
        'parent_item'        => __('País padre', 'os_countries_taxonomy'),
        'parent_item_colon'  => __('País padre:', 'os_countries_taxonomy'),
        'update_item'        => __('Actualizar país', 'os_countries_taxonomy'),
        'edit_item'          => __('Editar país', 'os_countries_taxonomy'),
        'add_new_item'       => __('Añadir nuevo país', 'os_countries_taxonomy'), 
        'new_item_name'      => __('Nuevo nombre de país', 'os_countries_taxonomy'),
        'menu_name'          => __('Países', 'os_countries_taxonomy'),
    );
    
    // Define arguments to be used 
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'how_in_nav_menus'  => true,
        'public'            => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'country')
    );
    
    // Call the register_taxonomy function
    register_taxonomy($taxonomy, $object_type, $args); 

}
add_action('init', 'create_country_taxonomy', 0);