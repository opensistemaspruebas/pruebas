<?php

/*
	Plugin Name: OS Ámbito Geográfico Taxonomy
	Plugin URI: https://www.opensistemas.com/
	Description: Crea la taxonomía 'ámbito geográfico'.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_ambito_geografico_taxonomy
*/


function create_ambito_geografico_taxonomy(){

    // Set the name of the taxonomy
    $taxonomy = 'ambito_geografico';
    // Set the post types for the taxonomy
    $object_type = 'post';
    
    // Populate our array of names for our taxonomy
    $labels = array(
        'name'               => __('Ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'singular_name'      => __('Ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'search_items'       => __('Buscar ámbitos geográficos', 'os_ambito_geografico_taxonomy'),
        'all_items'          => __('Todos', 'os_ambito_geografico_taxonomy'),
        'parent_item'        => __('Superior', 'os_ambito_geografico_taxonomy'),
        'parent_item_colon'  => __('Superior:', 'os_ambito_geografico_taxonomy'),
        'update_item'        => __('Actualizar ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'edit_item'          => __('Editar ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'add_new_item'       => __('Añadir nuevo ámbito geográfico', 'os_ambito_geografico_taxonomy'), 
        'new_item_name'      => __('Nuevo ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'menu_name'          => __('Ámbitos geográficos', 'os_ambito_geografico_taxonomy'),
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
        'rewrite'           => array('slug' => 'ambito-geografico')
    );
    
    // Call the register_taxonomy function
    register_taxonomy($taxonomy, $object_type, $args); 

}
add_action( 'init', 'create_ambito_geografico_taxonomy', 0 );