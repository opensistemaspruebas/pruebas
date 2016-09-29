<?php
/*
Plugin Name: OS Miembros Type
Plugin URI: http://www.opensistemas.com
Description: Crea el tipo de contenido 'Miembros'
Version: 1.0
Author: Roberto Moreno 
Author URI: http://www.opensistemas.com/
Author email: rmoreno@opensistemas.com
Text Domain: os_miembros_type
License: GPL2
*/


if (!class_exists('MiembrosCustomType')) :
  
   class MiembrosCustomType extends MiembrosPartnersCustomType{   
       
var $post_type = "miembros";
        
        function __construct() {
        	parent::__construct();
            add_action('init', array(&$this, 'create_post_type'));
            add_action('admin_enqueue_scripts', 'register_admin_scripts');
        }

         function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Miembros', 'os_miembros_type'),
                    'singular_name' => __('Miembro', 'os_miembros_type'),
                    'add_new' => __('Añadir nuevo Miembro', 'os_miembros_type'),
                    'add_new_item' => __('Añadir nuevo Miembro', 'os_miembros_type'),
                    'new_item' => __('Nuevo Miembro', 'os_miembros_type'),
                    'edit_item' => __('Editar Miembro', 'os_miembros_type'),
                    'view_item' => __('Ver Miembro', 'os_miembros_type'),
                    'parent_item_colon' => __(' ', 'os_miembros_type'),
                    'search_items' => __('Buscar Miembro', 'os_miembros_type'),
                    'not_found' => __('No se han encontrado miembros', 'os_miembros_type'),
                    'not_found_in_trash' => __('No se han encontrado miembros en la papelera', 'os_miembros_type'),
                    'menu_name' => __('Miembros', 'os_miembros_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different miembros", "os_miembros_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Miembro'),
                'menu_icon' =>  'dashicons-star-empty',
                'supports' => array("title")
            ));
        }



    }

    $osMiembros = new MiembrosCustomType();


endif;
