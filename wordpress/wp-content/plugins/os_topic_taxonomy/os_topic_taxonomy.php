<?php

/*
	Plugin Name: OS Topic Taxonomy
	Plugin URI: https://www.opensistemas.com/
	Description: Crea la taxonomía 'Topic' para el tipo de contenido 'Evento'.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_topic_taxonomy
*/


if (!class_exists('OS_Topic_Taxonomy')) {

    class OS_Topic_Taxonomy {

        var $taxonomy = 'topic';
        var $object_type = 'evento';


        function __construct() {
            add_action('init', array(&$this, 'create_taxonomy'));
        }


        function create_taxonomy() {
            $labels = array(
                'name'                       => _x('Topics', 'taxonomy general name', 'os_topic_taxonomy'),
                'singular_name'              => _x('Topic', 'taxonomy singular name', 'os_topic_taxonomy'),
                'search_items'               => __('BUscar topics', 'os_topic_taxonomy'),
                'popular_items'              => __('Más utilizados', 'os_topic_taxonomy'),
                'all_items'                  => __('Todos los topics', 'os_topic_taxonomy'),
                'parent_item'                => __('Superior', 'os_topic_taxonomy'),
                'parent_item_colon'          => __('Superior:', 'os_topic_taxonomy'),
                'edit_item'                  => __('Editar topic', 'os_topic_taxonomy'),
                'update_item'                => __('Actualizar topic', 'os_topic_taxonomy'),
                'add_new_item'               => __('Añadir nuevo topic', 'os_topic_taxonomy'),
                'new_item_name'              => __('Añadir nuevo nombre de topic', 'os_topic_taxonomy'),
                'separate_items_with_commas' => __('Separar topics por comas', 'os_topic_taxonomy'),
                'add_or_remove_items'        => __('Añadir o eliminar topics', 'os_topic_taxonomy'),
                'choose_from_most_used'      => __('Seleccione entre los topics más utilizados', 'os_topic_taxonomy'),
                'not_found'                  => __('No se han encontrado topics.', 'os_topic_taxonomy'),
                'menu_name'                  => __('Topics', 'os_topic_taxonomy'),
            );
            $args = array(
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var'             => true,
                'rewrite'               => array('slug' => 'topic'),
            );
            register_taxonomy($this->taxonomy, $this->object_type, $args); 
        }

    }

    $os_topic_taxonomy = new OS_Topic_Taxonomy();

}